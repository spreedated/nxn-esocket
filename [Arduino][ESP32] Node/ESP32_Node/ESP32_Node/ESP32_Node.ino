#include <MQTT.h>
#include <MQTTClient.h>

#include <RCSwitch.h>

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

#define ARDUINOJSON_ENABLE_STD_STREAM 0 //Resolves VMciro IntelliSense Error
#include <ArduinoJson.h>

// SETUP vars
// ----------
// 2019-2021 (c) neXn-Systems

//Node Information
const char* nodeVersion = "5.0";

//Connect to WiFi
const char* ssid = "nxn-fritz";
const char* password = "69469573606998461850";

//Node Ethernet Information
const char* nodeHostname = "nxn-nodeESP32-95";
const String nodeIP = "192.168.1.95";
const String inetDNSServer = "192.168.1.254";
const String inetGateway = "192.168.1.254";
const String inetSubnet = "255.255.255.0";

//MQTT
const char* mqtt_server = "192.168.1.106";
const char* nodeTopic = "/neXn/433/nodes/";
const char* commandTopic = "/neXn/433/commands/";
const char* mqtt_username = "cdavid";
const char* mqtt_password = "cdavid";
const char* clientID = "node1";
const char* capabilities[] = { "433", "WLAN", "MQTT" };

//433 Switch DataPin
const int trasmitterDataPin = 32;

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
#pragma endregion

//IPAddress from String
const IPAddress nodeIPa = IPAddress(SplitStringValue(nodeIP, '.', 0).toInt(), SplitStringValue(nodeIP, '.', 1).toInt(), SplitStringValue(nodeIP, '.', 2).toInt(), SplitStringValue(nodeIP, '.', 3).toInt());
const IPAddress inetDNSServerA = IPAddress(SplitStringValue(inetDNSServer, '.', 0).toInt(), SplitStringValue(inetDNSServer, '.', 1).toInt(), SplitStringValue(inetDNSServer, '.', 2).toInt(), SplitStringValue(inetDNSServer, '.', 3).toInt());
const IPAddress inetGatewayA = IPAddress(SplitStringValue(inetGateway, '.', 0).toInt(), SplitStringValue(inetGateway, '.', 1).toInt(), SplitStringValue(inetGateway, '.', 2).toInt(), SplitStringValue(inetGateway, '.', 3).toInt());
const IPAddress inetSubnetA = IPAddress(SplitStringValue(inetSubnet, '.', 0).toInt(), SplitStringValue(inetSubnet, '.', 1).toInt(), SplitStringValue(inetSubnet, '.', 2).toInt(), SplitStringValue(inetSubnet, '.', 3).toInt());

//RCSwitch
RCSwitch nxnSwitch = RCSwitch();
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

void MQTT_Publish(String msg)
{
    if (!client.publish(nodeTopic, msg))
    {
        client.connect(clientID);
        delay(10);
        client.publish(nodeTopic, msg, false, 1);
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
        MQTT_Publish("{\"client\":\"" + String(clientID) + "\"}");
    }
}

// JSON - Deserialize Vars
const char* jsonClients[48];
const char* command;
bool state;
const char* homecode;
const char* socket;
//# ### #

void MQTT_OnReceive(String& topic, String& payload) 
{
    Serial.print("| [MQTT] Message Received - Topic \"");
    Serial.print(topic);
    Serial.print("\" - Payload \"");
    Serial.print(payload);
    Serial.println("\"");

    DynamicJsonDocument doc(1024);
    deserializeJson(doc, payload);

    state = doc["state"];
    homecode = doc["homecode"];
    socket = doc["socket"];

    int arraySize = doc["clients"].size();

   for (int i = 0; i < arraySize; i++) {

        jsonClients[i] = doc["clients"][i];
    }

    Serial.println("State:" + String(state));
    Serial.println("HomeCode:" + String(homecode));
    Serial.println("Socket:" + String(socket));
    Serial.println("ASize:" + String(arraySize));
    Serial.println("Array0:" + String(jsonClients[0]));

    if (arraySize > 0 && KeyWordComparison(jsonClients, arraySize, clientID))
    {
        Serial.println("Yes ME!");
    }
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
void Command_Reset() 
{
    //if (String(rcvd) == "nxn#reset") {
    //    //Answer
    //    Serial.println("Restarting device...");
    //    SendUDPMessage("Restarting device...", &UDPListener);
    //    UDPListener.stop();
    //    //# ### #
    //    Serial.println("5 seconds...");
    //    delay(1000);
    //    Serial.println("4 seconds...");
    //    delay(1000);
    //    Serial.println("3 seconds...");
    //    delay(1000);
    //    Serial.println("2 seconds...");
    //    delay(1000);
    //    Serial.println("1 seconds...");
    //    delay(1000);
    //    Serial.println("Restarting... please stand by.");
    //    ESP.restart();
    //}
}

bool Command_IsOriginal() 
{
    //if (rcvd.startsWith("nxn#") && rcvd.length() > 4) {
    //    int dividend = SplitStringValue(rcvd, '#', 1).toInt();
    //    int divisor = SplitStringValue(rcvd, '#', 2).toInt();
    //    if (dividend % divisor == 1337) { //nxn#2675#1338
    //        char buf[100];
    //        strcpy(buf, nodeHostname);
    //        strcpy(buf, " operating on nominal parameters");
    //        Serial.println("Genuine neXn-Systems device.");
    //        //Serial.println(buf);
    //        Serial.println("Firmware Version: " + nodeVersion);
    //        Serial.println(UDPListener.remoteIP());
    //        Serial.println(UDPListener.remotePort());
    //        //Answer
    //        //SendUDPMessage("Genuine neXn-Systems device#" + nodeVersion, &UDPListener);
    //        //# ### #
    //        return;
    //    }
    //}
}

void Command_SwitchSocket()
{
    //String homecode = SplitStringValue(String(rcvd), '#', 0);
    //String socket = SplitStringValue(String(rcvd), '#', 1);
    //String onORoff = SplitStringValue(String(rcvd), '#', 2);

    ////Legacy
    //if (socket == "1") {
    //    socket = "10000";
    //}
    //if (socket == "2") {
    //    socket = "01000";
    //}
    //if (socket == "3") {
    //    socket = "00100";
    //}
    //if (socket == "4") {
    //    socket = "00010";
    //}
    //if (socket == "5") {
    //    socket = "00001";
    //}
    ////# ### #

    //if (onORoff == "0") {
    //    //SendUDPMessage("OFF#" + homecode + "#" + socket, &UDPListener);
    //    //Send 5 times
    //    for (int i = 0; i <= 4; i++) {
    //        nxnSwitch.switchOff((char*)homecode.c_str(), (char*)socket.c_str());
    //        delay(50);
    //    }
    //    Serial.println("OFF - " + homecode + " " + socket);
    //}
    //else if (onORoff == "1") {
    //    //SendUDPMessage("ON#" + homecode + "#" + socket, &UDPListener);
    //    for (int i = 0; i <= 4; i++) {
    //        nxnSwitch.switchOn((char*)homecode.c_str(), (char*)socket.c_str());
    //        delay(50);
    //    }
    //    Serial.println("ON - " + homecode + " " + socket);
    //}
}
#pragma endregion

#pragma region  WiFi Handling
void WiFiSetup()
{
    Serial.printf("| [WiFi] Connecting to %s ", ssid);
    WiFi.mode(WIFI_STA);
    WiFi.config(nodeIPa, inetDNSServerA, inetGatewayA, inetSubnetA);
    WiFi.setAutoReconnect(true);
    WiFi.begin(ssid, password);
    WiFi.setHostname(nodeHostname); //Set Hostname AFTER WiFi.begin();
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

void setup() {
    Serial.begin(115200);
    while (!Serial) {
        ; // wait for serial port to connect.
    }
    Serial.print("Welcome to the neXn-Systems NodeMCU v");
    Serial.println(nodeVersion);
    Serial.println("| [NodeInfo] Node MAC: " + WiFi.macAddress());
    Serial.println("| [NodeInfo] Node IP: " + nodeIP);

    //WiFi Connection
    WiFiSetup();
    //# ### #

    //RCSwitch
    nxnSwitch.enableTransmit(trasmitterDataPin);
    nxnSwitch.setRepeatTransmit(9);
    //# ### #

    MQTT_Begin();
}

void loop() {
    // MQTT loop
    client.loop();
    //# ### #

    int wifistat = WiFi.status();
    if (wifistat == WL_DISCONNECTED || wifistat == WL_CONNECTION_LOST)
    {
        WiFiReconnect();
    }

    MQTT_PublishAlive();
 
    delay(5); //Small delay
}
