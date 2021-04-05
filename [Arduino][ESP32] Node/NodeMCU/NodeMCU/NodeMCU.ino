#include <ArduinoOTA.h>

#include <MQTT.h>
#include <MQTTClient.h>

#include <RCSwitch.h>

#if defined(ESP32)
  //#include "config.h"
  #include "config_nodemcu_107.h"
  #include <WiFiClientSecure.h>
  #include <ssl_client.h>
  #include <WiFiType.h>
  #include <WiFiSTA.h>
  #include <WiFiServer.h>
  #include <WiFiScan.h>
  #include <WiFiMulti.h>
  #include <WiFiGeneric.h>
  #include <WiFiClient.h>
  #include <WiFi.h>
  #include <ETH.h>
  #include <WebServer.h>
#elif defined(ESP8266)
  #include "config_nodemcu_107.h"
  #include <ESP8266WiFi.h>
  #include <WiFiUDP.h>
  #include <ESP8266WebServer.h>
#endif

#define ARDUINOJSON_ENABLE_STD_STREAM 0 //Resolves VMciro IntelliSense Error
#include <ArduinoJson.h>

#include "webpage.h"

// 2019-2021 (c) neXn-Systems

//Node Information
#if defined (_DEBUG)
const char* nodeVersion = "6.1-DEBUG";
#else
const char* nodeVersion = "6.1";
#endif

#pragma region  Helper Functions
String SplitStringValue(String data, char separator, int index)
{
    int found = 0;
    int strIndex[] = { 0, -1 };
    int maxIndex = data.length() - 1;

    for (int i = 0; i <= maxIndex && found <= index; i++) {
        if (data.charAt(i) == separator || i == maxIndex) {
            found++;
            strIndex[0] = strIndex[1] + 1;
            strIndex[1] = (i == maxIndex) ? i + 1 : i;
        }
    }

    return found > index ? data.substring(strIndex[0], strIndex[1]) : "";
}
String IpAddress2String(const IPAddress& ipAddress)
{
    return String(ipAddress[0]) + String(".") + \
        String(ipAddress[1]) + String(".") + \
        String(ipAddress[2]) + String(".") + \
        String(ipAddress[3]);
}

unsigned long interval = 3600000;
void Restart24h()
{
    if (millis() >= interval)
    {
        ESP.restart();
    }
}
#pragma endregion

//IPAddress from String
const IPAddress WiFi_IPA = IPAddress(SplitStringValue(WiFi_IP, '.', 0).toInt(), SplitStringValue(WiFi_IP, '.', 1).toInt(), SplitStringValue(WiFi_IP, '.', 2).toInt(), SplitStringValue(WiFi_IP, '.', 3).toInt());
const IPAddress WiFi_DNSServerA = IPAddress(SplitStringValue(WiFi_DNSServer, '.', 0).toInt(), SplitStringValue(WiFi_DNSServer, '.', 1).toInt(), SplitStringValue(WiFi_DNSServer, '.', 2).toInt(), SplitStringValue(WiFi_DNSServer, '.', 3).toInt());
const IPAddress WiFi_GatewayA = IPAddress(SplitStringValue(WiFi_Gateway, '.', 0).toInt(), SplitStringValue(WiFi_Gateway, '.', 1).toInt(), SplitStringValue(WiFi_Gateway, '.', 2).toInt(), SplitStringValue(WiFi_Gateway, '.', 3).toInt());
const IPAddress WiFi_SubnetA = IPAddress(SplitStringValue(WiFi_Subnet, '.', 0).toInt(), SplitStringValue(WiFi_Subnet, '.', 1).toInt(), SplitStringValue(WiFi_Subnet, '.', 2).toInt(), SplitStringValue(WiFi_Subnet, '.', 3).toInt());

//RCSwitch
RCSwitch nxnSwitch = RCSwitch();
//# ### #

// Set web server port number to 80
#if defined(ESP32)
  WebServer server(80);
#elif defined(ESP8266)
  ESP8266WebServer server(80);
#endif
//# ### #

#pragma region MQTT Functions
unsigned long lastMillis = 0;
MQTTClient client;
WiFiClient net;

void MQTT_Begin()
{
    client.setBufSize(1024);

    client.begin(mqtt_server, 1883, net);
    client.connect(clientID);
    client.onMessage(MQTT_OnReceive); 

    if (client.connected())
    {
        Serial.print("| [MQTT] Connected to MQTT Broker -");
        Serial.print(mqtt_server);
        Serial.println("-");
        client.subscribe(commandTopic);
        Serial.print("| [MQTT] Subscribed to Topic -");
        Serial.print(commandTopic);
        Serial.println("-");
    }
    else
    {
        Serial.println("| [MQTT] Connection failed -- " + String(client.lastError()));
    }
}

void MQTT_Publish(String msg, const char * topic = commandResponseTopic)
{
    //Serial.println(msg);
    const char* tt = msg.c_str();

    if (!client.publish(topic, tt, false, 1))
    {
        client.connect(clientID);
        delay(10);
        client.publish(topic, tt, false, 1);
    }
}

void MQTT_PublishAlive()
{
    if (millis() - lastMillis > 10000) {
        if (!client.connected()) {
            Serial.print("| [MQTT] LastError: ");
            Serial.println(client.lastError());
        }
        lastMillis = millis();
        MQTT_Publish("{\"client\":\"" + String(clientID) + "\", \"firmware\":\"" + String(nodeVersion) + "\"}", nodeTopic);
    }
}

// JSON - Deserialize Vars
const char* jsonClients[48];
const char* command;
bool state;
const char* homecode;
const char* socket;
int genuineNum1;
int genuineNum2;
//# ### #

void MQTT_ClearDVars()
{
    for (size_t i = 0; i < sizeof(jsonClients)/sizeof(jsonClients[0]); i++)
    {
        jsonClients[i] = NULL;
    }
    command = "\0";
    homecode = "\0";
    socket = "\0";
    state = 0;
    genuineNum1 = 0;
    genuineNum2 = 0;
}

void MQTT_OnReceive(String& topic, String& payload) 
{
    MQTT_ClearDVars();

    Serial.print("| [MQTT] Message Received - Topic \"");
    Serial.print(topic);
    Serial.print("\" - Payload \"");
    Serial.print(payload);
    Serial.println("\"");

    //De-Serialize
    DynamicJsonDocument doc(1024);
    deserializeJson(doc, payload);

    int arraySize = doc["clients"].size();

    for (int i = 0; i < arraySize; i++) {

        jsonClients[i] = doc["clients"][i];
    }

    if (arraySize <= 0 || !KeyWordComparison(jsonClients, arraySize, clientID)) //Is this message for us?
    {
        Serial.println("| [MQTT] Message not for me, won't process.");
        return;
    }

    state = doc["state"];
    homecode = doc["homecode"];
    socket = doc["socket"];
    command = doc["command"];
    genuineNum1 = doc["gNum1"];
    genuineNum2 = doc["gNum2"];
    //# ### #

    //Process commands
    if (String(command) == "switch" || String(command) == "socket")
    {
        Command_SwitchSocket(homecode, socket, state);
        return;
    }
    if (String(command) == "reset" || String(command) == "restart")
    {
        Command_Reset();
        return;
    }
    if ((String(command) == "original" || String(command) == "genuine") && genuineNum1 != 0 && genuineNum2 != 0)
    {
        Command_IsGenuine(genuineNum1, genuineNum2);
        return;
    }
    if (String(command) == "info" || String(command) == "information")
    {
        Command_Info();
        return;
    }

    Serial.println("| [MQTT] Unknown command or command missing parameters");
}

bool KeyWordComparison(const char * haystack[], int sizeOfHaystack, const char * needle) 
{
    for (int x = 0; x < sizeOfHaystack; x++)
    {
        if (String(haystack[x]) == "all" || String(needle) == String(haystack[x]))
        {
            return true;
        }
    }
    return false;
}
#pragma endregion

#pragma region Command routines
void Command_Info()
{
    Serial.println("| [MQTT] Executing Command \"Info\"");

    DynamicJsonDocument doc(1024);

    doc["firmware"] = nodeVersion;
    doc["mac"] = WiFi.macAddress();
    doc["clientID"] = clientID;

    JsonArray Jcap = doc.createNestedArray("capabilities");
    for (size_t i = 0; i < sizeof(capabilities)/sizeof(capabilities[0]); i++)
    {
        Jcap.add(capabilities[i]);
    }

    JsonObject jWifi = doc.createNestedObject("wifi");
    jWifi["assignedIPv4"] = IpAddress2String(WiFi.localIP());
    jWifi["connectedSSID"] = WiFi.SSID();
    jWifi["signalStrengh"] = WiFi.RSSI();

    JsonObject jHardware = doc.createNestedObject("hardware");
#if defined (ESP32)
    esp_chip_info_t chip_info;
    esp_chip_info(&chip_info);
    jHardware["cpuFreq"] = getCpuFrequencyMhz();
    jHardware["cores"] = chip_info.cores;
    jHardware["model"] = chip_info.model;
    jHardware["revision"] = chip_info.revision;
#elif defined (ESP8266)
    jHardware["chipID"] = ESP.getFlashChipId();
    jHardware["chipRealSize"] = ESP.getFlashChipRealSize();
    jHardware["chipSize"] = ESP.getFlashChipSize();
    jHardware["chipMode"] = ESP.getFlashChipMode();
#endif

    JsonObject jRCSwitch = doc.createNestedObject("rcswitch");
    jRCSwitch["dataPin"] = trasmitterDataPin;

    String JSON;
    serializeJson(doc, JSON);

    Serial.println(JSON);

    MQTT_Publish(JSON);
}

void Command_Reset() 
{
    Serial.println("| [MQTT] Executing Command \"Restart\"");
    Serial.println("5 seconds...");
    delay(1000);
    Serial.println("4 seconds...");
    delay(1000);
    Serial.println("3 seconds...");
    delay(1000);
    Serial.println("2 seconds...");
    delay(1000);
    Serial.println("1 second...");
    delay(1000);
    Serial.println("Restarting... please stand by.");
    ESP.restart();
}

bool Command_IsGenuine(int dividend, int divisor)
{
    if (dividend % divisor == 1337) { //nxn#2675#1338
        Serial.println("Genuine neXn-Systems device.");
        Serial.println("Firmware Version: " + String(nodeVersion));
        MQTT_Publish("{\"client\":\"" + String(clientID) + "\", \"info\":\"Genuine neXn-Systems device\", \"firmware\":\"" + String(nodeVersion) + "\"}");
        return true;
    }
    return false;
}

void Command_SwitchSocket(const char* homecode, const char* socket, bool state)
{
    //Legacy support
    if (String(socket) == "1") { socket = "10000"; }
    if (String(socket) == "2") { socket = "01000"; }
    if (String(socket) == "3") { socket = "00100"; }
    if (String(socket) == "4") { socket = "00010"; }
    if (String(socket) == "5") { socket = "00001"; }
    //# ### #

    if (state) 
    {
        nxnSwitch.switchOn(homecode, socket);
    }
    else
    {
        nxnSwitch.switchOff(homecode, socket);
    }

    Serial.print("| [SwitchSocket] Homecode \"");
    Serial.print(homecode);
    Serial.print("\" - Socket \"");
    Serial.print(socket);
    Serial.print("\" - State \"");
    Serial.print(state);
    Serial.println("\"");
}
#pragma endregion

#pragma region  WiFi Handling
void WiFiSetup()
{
    Serial.printf("| [WiFi] Connecting to %s ", WiFi_SSID);
    WiFi.mode(WIFI_STA);
    WiFi.config(WiFi_IPA, WiFi_DNSServerA, WiFi_GatewayA, WiFi_SubnetA);
    WiFi.setAutoReconnect(true);
    WiFi.begin(WiFi_SSID, WiFi_Password);
#if defined(ESP32)
    WiFi.setHostname(WiFi_Hostname); //Set Hostname AFTER WiFi.begin();
#elif defined(ESP8266)
    WiFi.hostname(WiFi_Hostname); //Set Hostname AFTER WiFi.begin();
#endif
    WiFiConnect();
}
int wifiRetries = 0;
void WiFiConnect()
{
    while (WiFi.status() != WL_CONNECTED)
    {
        delay(500);
        Serial.print(".");
        wifiRetries++;
        if (wifiRetries >= 20)
        {
            ESP.restart();
        }
    }
    Serial.println(" connected");
    wifiRetries = 0;
}

void WiFiReconnect() 
{
    WiFi.reconnect();
    WiFiConnect();
}
#pragma endregion

#pragma region OTA Update
void StartOTA()
{
    ArduinoOTA.onStart([]() {
        String type;
        if (ArduinoOTA.getCommand() == U_FLASH)
            type = "sketch";
        else // U_SPIFFS
            type = "filesystem";

        // NOTE: if updating SPIFFS this would be the place to unmount SPIFFS using SPIFFS.end()
        Serial.println("| [OTA] Start updating " + type);
        });

    ArduinoOTA.onProgress([](unsigned int progress, unsigned int total) {
        Serial.printf("| [OTA] Progress: %u%%\n", (progress / (total / 100)));
        });

    ArduinoOTA.onError([](ota_error_t error) {
                Serial.printf("| [OTA] Error[%u]: ", error);
                if (error == OTA_AUTH_ERROR) Serial.println("Auth Failed");
                else if (error == OTA_BEGIN_ERROR) Serial.println("Begin Failed");
                else if (error == OTA_CONNECT_ERROR) Serial.println("Connect Failed");
                else if (error == OTA_RECEIVE_ERROR) Serial.println("Receive Failed");
                else if (error == OTA_END_ERROR) Serial.println("End Failed");

        });

    ArduinoOTA.onEnd([]() {
        Serial.println("\n| [OTA] End");
        });

    ArduinoOTA.begin();

    Serial.println("| [OTA] Ready!");
}
#pragma endregion

#pragma WebServer
void handle_OnConnect() {
  server.send(200, "text/html", SendHTML());
}
void handle_NotFound(){
  server.send(404, "text/plain", "Not found");
}
#pragma endregion

void setup() {
    Serial.begin(115200);
    while (!Serial) {
        ; // wait for serial port to connect.
    }
    Serial.print("Welcome to the neXn-Systems NodeMCU v");
    Serial.println(nodeVersion);
    Serial.println("| [NodeInfo] Node MAC: " + WiFi.macAddress());
    Serial.println("| [NodeInfo] Node IP: " + WiFi_IP);

    //WiFi Connection
    WiFiSetup();
    //# ### #

    //RCSwitch
    nxnSwitch.enableTransmit(trasmitterDataPin);
    nxnSwitch.setRepeatTransmit(9);
    //# ### #

    MQTT_Begin();

    //OTA Update
    ArduinoOTA.setPort(otaPort);
    ArduinoOTA.setHostname(clientID);
    if (strlen(otaMD5Password) > 0)
    {
        ArduinoOTA.setPasswordHash(otaMD5Password);
    }
    else if (strlen(otaPassword) > 0)
    {
        ArduinoOTA.setPassword(otaPassword);
    }
    StartOTA();
    //# ### #

    //WebServer
    server.on("/", handle_OnConnect);
    server.onNotFound(handle_NotFound);
    server.begin();
    Serial.println("| [WebServer] HTTP server started");
    //# ### #
}

void loop() {
    server.handleClient();
    
    Restart24h();

    ArduinoOTA.handle();

    // MQTT loop
    client.loop();
    //# ### #

    int wifistat = WiFi.status();
    if (wifistat == WL_DISCONNECTED || wifistat == WL_CONNECTION_LOST)
    {
        WiFiReconnect();
    }

    if (!client.connected())
    {
        ESP.restart();
    }

    MQTT_PublishAlive();
 
    delay(5); //Small delay
}
