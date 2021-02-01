#include <MQTT.h>
#include <MQTTClient.h>

#include <RCSwitch.h>

#include <WiFiClientSecure.h>
#include <ssl_client.h>
#include <WiFiUdp.h>
#include <WiFiType.h>
#include <WiFiSTA.h>
#include <WiFiServer.h>
#include <WiFiScan.h>
#include <WiFiMulti.h>
#include <WiFiGeneric.h>
#include <WiFiClient.h>
#include <WiFiAP.h>
#include <WiFi.h>
#include <ETH.h>

#include <ArduinoJson.h>

// SETUP vars
// ----------
// 2019-2021 (c) neXn-Systems

//Connect to WiFi
const char* ssid = "nxn-fritz";
const char* password = "69469573606998461850";

//Node Ethernet Information
const char* nodeHostname = "nxn-nodeESP32-95";
const String nodeIP = "192.168.1.95";
const int nodePort = 13337;
const String inetDNSServer = "192.168.1.105";
const String inetGateway = "192.168.1.254";
const String inetSubnet = "255.255.255.0";
const String nodeVersion = "5.0";

//433 Switch DataPin
const int trasmitterDataPin = 32;

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//GetValue function
//-------------------------------------------------------------------------
String getValue(String data, char separator, int index)
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
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//Split String function
//-------------------------------------------------------------------------
void SendUDPMessage(char * msg, WiFiUDP *listener)
{
    uint8_t replyPacket[200];

    for (size_t i = 0; i < sizeof(msg)/sizeof(msg[0]); i++)
    {
        replyPacket[i] = (uint8_t)msg[i];
    }

    listener->beginPacket(listener->remoteIP(), listener->remotePort());
    listener->write(replyPacket, (sizeof(replyPacket) / sizeof(replyPacket[0])));
    listener->endPacket();
    delay(50);
    listener->stop();
    listener->begin(nodePort);
}
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
const IPAddress nodeIPa = IPAddress(getValue(nodeIP, '.', 0).toInt(), getValue(nodeIP, '.', 1).toInt(), getValue(nodeIP, '.', 2).toInt(), getValue(nodeIP, '.', 3).toInt());
const IPAddress inetDNSServerA = IPAddress(getValue(inetDNSServer, '.', 0).toInt(), getValue(inetDNSServer, '.', 1).toInt(), getValue(inetDNSServer, '.', 2).toInt(), getValue(inetDNSServer, '.', 3).toInt());
const IPAddress inetGatewayA = IPAddress(getValue(inetGateway, '.', 0).toInt(), getValue(inetGateway, '.', 1).toInt(), getValue(inetGateway, '.', 2).toInt(), getValue(inetGateway, '.', 3).toInt());
const IPAddress inetSubnetA = IPAddress(getValue(inetSubnet, '.', 0).toInt(), getValue(inetSubnet, '.', 1).toInt(), getValue(inetSubnet, '.', 2).toInt(), getValue(inetSubnet, '.', 3).toInt());
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

//RCSwitch
RCSwitch nxnSwitch = RCSwitch();
//# ### #

//UDP Listener
WiFiUDP UDPListener;
// # ### #


#pragma region MQTT Functions
const char* mqtt_server = "192.168.1.106";  // IP of the MQTT broker
const char* nodeTopic = "/neXn/433/nodes/";
const char* commandTopic = "/neXn/433/commands/";
const char* mqtt_username = "cdavid"; // MQTT username
const char* mqtt_password = "cdavid"; // MQTT password
const char* clientID = "node1"; // MQTT client ID
const char* capabilities[] = { "433", "WLAN", "MQTT" };

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
        Serial.println("Connected to MQTT :)");
        client.subscribe(commandTopic);
    }
    else
    {
        Serial.println("MQTT connection failed ;( -- " + String(client.lastError()));
    }
}

void MQTT_Publish(String msg)
{
    if (!client.publish(nodeTopic, msg))
    {
        client.connect(clientID);
        delay(10);
        client.publish(nodeTopic, msg);
    }
}

void MQTT_PublishAlive()
{
    if (millis() - lastMillis > 1000) {
        if (!client.connected()) {
            Serial.print("lastError: ");
            Serial.println(client.lastError());
        }
        lastMillis = millis();
        MQTT_Publish("{\"client\":\"" + String(clientID) + "\"}");
    }
}

void MQTT_OnReceive(String& topic, String& payload) {

    Serial.println("Received MQTT");
    Serial.println("--------------");
    Serial.println("Topic: " + topic);
    Serial.println("Payload: " + payload);

    DynamicJsonDocument doc(1024);
    deserializeJson(doc, payload);

    bool state = doc["state"];
    String homecode = doc["homecode"];
    String socket = doc["socket"];
    const char * clients[48];

    int arraySize = doc["clients"].size();

   for (int i = 0; i < arraySize; i++) {

        clients[i] = doc["clients"][i];
    }

    Serial.println("State:" + String(state));
    Serial.println("HomeCode:" + homecode);
    Serial.println("Socket:" + socket);
    Serial.println("ASize:" + String(arraySize));
    Serial.println("Array0:" + String(clients[0]));

    if (arraySize > 0 && KeyWordComparison(clients, arraySize, clientID))
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

String readUDPPacket() {
    char data[255] = {};

    int packetSize = UDPListener.parsePacket();

    if (packetSize != 0) // if(packetsize)
    {
        Serial.println("// ---------------------------- //");
        Serial.println(UDPListener.available());
        Serial.println("// Package RCVD");
        Serial.println("// IP  : " + UDPListener.remoteIP().toString());
        Serial.print("// PORT: ");
        Serial.println(UDPListener.remotePort());
        Serial.println("// ---------------------------- //");
        Serial.println("// -----------Content---------- //");

        int len = UDPListener.read(data, 255);

        if (len > 0) {
            data[len] = 0;
        }

        Serial.println(data);
        Serial.println("// ---------------------------- //\n");

        return String(data);
    }

    return "";
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

void setup() {
    Serial.begin(115200);
    while (!Serial) {
        ; // wait for serial port to connect. Needed for native USB port only
    }
    Serial.println("Welcome to the neXn-Systems NodeMCU v" + nodeVersion);

    //WiFi Connection
    Serial.println("Node MAC: " + WiFi.macAddress());
    Serial.println("Node IP: " + nodeIP);
    Serial.printf("Connecting to %s ", ssid);
    WiFi.mode(WIFI_STA);
    WiFi.config(nodeIPa, inetDNSServerA, inetGatewayA, inetSubnetA);
    WiFi.setAutoReconnect(true);
    WiFi.begin(ssid, password);
    WiFi.setHostname(nodeHostname); //Set Hostname AFTER WiFi.begin();
    WiFiConnect();
    //# ### #

    //UDP Listener
    UDPListener.begin(nodePort);
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

    String rcvd = readUDPPacket();

    if (rcvd == "") {
        return;
    }

    Serial.print("T: ");
    Serial.print(rcvd);
    Serial.print("\n");

    if (String(rcvd) == "nxn#reset") {
        //Answer
        Serial.println("Restarting device...");
        SendUDPMessage("Restarting device...", &UDPListener);
        UDPListener.stop();
        //# ### #
        Serial.println("5 seconds...");
        delay(1000);
        Serial.println("4 seconds...");
        delay(1000);
        Serial.println("3 seconds...");
        delay(1000);
        Serial.println("2 seconds...");
        delay(1000);
        Serial.println("1 seconds...");
        delay(1000);
        Serial.println("Restarting... please stand by.");
        ESP.restart();
    }

    if (rcvd.startsWith("nxn#") && rcvd.length() > 4) {
        int dividend = getValue(rcvd, '#', 1).toInt();
        int divisor = getValue(rcvd, '#', 2).toInt();
        if (dividend % divisor == 1337) { //nxn#2675#1338
            char buf[100];
            strcpy(buf, nodeHostname);
            strcpy(buf, " operating on nominal parameters");
            Serial.println("Genuine neXn-Systems device.");
            //Serial.println(buf);
            Serial.println("Firmware Version: " + nodeVersion);
            Serial.println(UDPListener.remoteIP());
            Serial.println(UDPListener.remotePort());
            //Answer
            //SendUDPMessage("Genuine neXn-Systems device#" + nodeVersion, &UDPListener);
            //# ### #
            return;
        }
    }

    String homecode = getValue(String(rcvd), '#', 0);
    String socket = getValue(String(rcvd), '#', 1);
    String onORoff = getValue(String(rcvd), '#', 2);

    //Legacy
    if (socket == "1") {
        socket = "10000";
    }
    if (socket == "2") {
        socket = "01000";
    }
    if (socket == "3") {
        socket = "00100";
    }
    if (socket == "4") {
        socket = "00010";
    }
    if (socket == "5") {
        socket = "00001";
    }
    //# ### #

    if (onORoff == "0") {
        //SendUDPMessage("OFF#" + homecode + "#" + socket, &UDPListener);
        //Send 5 times
        for (int i = 0; i <= 4; i++) {
            nxnSwitch.switchOff((char*)homecode.c_str(), (char*)socket.c_str());
            delay(50);
        }
        Serial.println("OFF - " + homecode + " " + socket);
    }
    else if (onORoff == "1") {
        //SendUDPMessage("ON#" + homecode + "#" + socket, &UDPListener);
        for (int i = 0; i <= 4; i++) {
            nxnSwitch.switchOn((char*)homecode.c_str(), (char*)socket.c_str());
            delay(50);
        }
        Serial.println("ON - " + homecode + " " + socket);
    }

    delay(5); //Small delay
}
