#include <RCSwitch.h>
#include <ESP8266WiFi.h>
#include <WiFiUDP.h>

// SETUP vars
// ----------
// 2019-2020 (c) neXn-Systems

//Connect to WiFi
const char* ssid = "nxn-fritz";
const char* password = "69469573606998461850";

//Node Ethernet Information
const String nodeHostname = "nxn-nodeMCU-107";
const String nodeIP = "192.168.1.107";
const int nodePort = 13337;
const String inetDNSServer = "192.168.1.105";
const String inetGateway = "192.168.1.254";
const String inetSubnet = "255.255.255.0";
const String nodeVersion = "2.0";

//Node Pin setup
//D0 = 16
//D1 = 5
//D2 = 4
//D3 = 0
//D4 = 2
//D5 = 14
//D6 = 12
//D7 = 13
//D8 = 15
//RX = 3
//TX = 1
const int trasmitterDataPin = 0;

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//Split String function
//-------------------------------------------------------------------------
String getValue(String data, char separator, int index)
{
  int found = 0;
  int strIndex[] = {0, -1};
  int maxIndex = data.length()-1;

  for(int i=0; i<=maxIndex && found<=index; i++){
    if(data.charAt(i)==separator || i==maxIndex){
        found++;
        strIndex[0] = strIndex[1]+1;
        strIndex[1] = (i == maxIndex) ? i+1 : i;
    }
  }

  return found>index ? data.substring(strIndex[0], strIndex[1]) : "";
}
//# ### #
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//Split String function
//-------------------------------------------------------------------------
void SendUDPMessage(String msg, WiFiUDP *listener)
{
  char replyPacket[msg.length()+1];
  msg.toCharArray(replyPacket,msg.length()+1);
  if((sizeof replyPacket / sizeof *replyPacket) >= 1) {
    listener->beginPacket(listener->remoteIP(), listener->remotePort());
    listener->write(replyPacket);
    listener->endPacket();
    delay(50);
    listener->stop();
    listener->begin(nodePort);
  }
}
//# ### #
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
const IPAddress nodeIPa = IPAddress(getValue(nodeIP,'.',0).toInt(),getValue(nodeIP,'.',1).toInt(),getValue(nodeIP,'.',2).toInt(),getValue(nodeIP,'.',3).toInt());
const IPAddress inetDNSServerA = IPAddress(getValue(inetDNSServer,'.',0).toInt(),getValue(inetDNSServer,'.',1).toInt(),getValue(inetDNSServer,'.',2).toInt(),getValue(inetDNSServer,'.',3).toInt());
const IPAddress inetGatewayA = IPAddress(getValue(inetGateway,'.',0).toInt(),getValue(inetGateway,'.',1).toInt(),getValue(inetGateway,'.',2).toInt(),getValue(inetGateway,'.',3).toInt());
const IPAddress inetSubnetA = IPAddress(getValue(inetSubnet,'.',0).toInt(),getValue(inetSubnet,'.',1).toInt(),getValue(inetSubnet,'.',2).toInt(),getValue(inetSubnet,'.',3).toInt());
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

//RCSwitch
RCSwitch nxnSwitch = RCSwitch();
//# ### #

//UDP Listener
WiFiUDP UDPListener;
// # ### #

void setup() { 
  Serial.begin(74880);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }
  Serial.println("Welcome to the neXn-Systems NodeMCU v" + nodeVersion);
  
  //WiFi Connection
  Serial.printf("Connecting to %s ", ssid);
  WiFi.mode(WIFI_STA);
  WiFi.hostname(nodeHostname);
  WiFi.config(nodeIPa, inetDNSServerA, inetGatewayA, inetSubnetA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }
  Serial.println(" connected");
  //# ### #

  //UDP Listener
  UDPListener.begin(nodePort);
  //# ### #

  //RCSwitch
  nxnSwitch.enableTransmit(trasmitterDataPin);
  //# ### #
}

String readUDPPacket() {
  char data[200] ={}; 
  String receiveddata = "";
  
  int packetsize = UDPListener.available();
  char message = UDPListener.parsePacket();
  
  if (message){
    UDPListener.read(data,packetsize);
     delay(100);
     UDPListener.endPacket();
  }
  
  if(packetsize) {
      for (int i=0;packetsize > i ;i++)
      {
        receiveddata+= (char)data[i];
      }
        
      Serial.println(receiveddata);
      Serial.println();
  }
  return receiveddata;
}

void loop() {  
      String rcvd = readUDPPacket();
      if(rcvd.length() <= 0) {
        return;
      }
      
      if(rcvd == "nxn#reset"){
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
        ESP.reset();
      }
      
      if(rcvd.startsWith("nxn#") && rcvd.length() > 4){
        int dividend = getValue(rcvd, '#',1).toInt();
        int divisor = getValue(rcvd, '#',2).toInt();
        if(dividend % divisor == 1337) { //nxn#2675#1338
            Serial.println("Genuine neXn-Systems device.");
            Serial.println(nodeHostname + " operating on nominal parameters");
            Serial.println("Firmware Version: " + nodeVersion);
            Serial.println(UDPListener.remoteIP());
            Serial.println(UDPListener.remotePort());
            //Answer
            SendUDPMessage("Genuine neXn-Systems device#" + nodeVersion, &UDPListener);
            //# ### #
            return;
          }
      }
      
      String homecode = getValue(rcvd, '#',0);
      String socket = getValue(rcvd, '#',1);
      String onORoff = getValue(rcvd, '#',2);

      //Legacy
      if(socket=="1") {
        socket = "10000";
      }
      if(socket=="2") {
        socket = "01000";
      }
      if(socket=="3") {
        socket = "00100";
      }
      if(socket=="4") {
        socket = "00010";
      }
      if(socket=="5") {
        socket = "00001";
      }
      //# ### #
      
      if(onORoff == "0") {
        SendUDPMessage("OFF#" + homecode + "#" + socket, &UDPListener);
        //Send 5 times
        for (int i = 0; i <= 4; i++) {
          nxnSwitch.switchOff((char*)homecode.c_str(),(char*)socket.c_str());
          delay(50);
        }
        Serial.println("OFF - " + homecode + " " + socket);
      }else if(onORoff == "1") {
        SendUDPMessage("ON#" + homecode + "#" + socket, &UDPListener);
        for (int i = 0; i <= 4; i++) {
           nxnSwitch.switchOn((char*)homecode.c_str(),(char*)socket.c_str());
           delay(50);
        }
        Serial.println("ON - " + homecode + " " + socket);
      }

      delay(200); //Small delay
}
