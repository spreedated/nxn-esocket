#include <RCSwitch.h>
#include <ESP8266WiFi.h>
#include <WiFiUDP.h>

// SETUP vars
// ----------
// 2019 (c) neXn-Systems

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

//Node Pin setup
const int trasmitterDataPin = 16;

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
char data[200] ={};
int packetsize = 0; 
String receiveddata = "";
// # ### #

void setup() {
  Serial.begin(74880);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }
  Serial.println("Welcome to the neXn-Systems NodeMCU v1.0");

  //WiFi Connection
  Serial.printf("Connecting to %s ", ssid);
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

void loop() {  
  int packetsize = UDPListener.available();
  char message = UDPListener.parsePacket();
  
  if (message){
    UDPListener.read(data,packetsize);
     delay(100);
     //Serial.println(data);
     UDPListener.endPacket();
  }
  
  if(packetsize) {
      //Serial.println(packetsize);
      for (int i=0;packetsize > i ;i++)
      {
        receiveddata+= (char)data[i];
      }
        
      Serial.println(receiveddata);
      Serial.println();
      String homecode = getValue(receiveddata, '#',0);
      String socket = getValue(receiveddata, '#',1);
      String onORoff = getValue(receiveddata, '#',2);
      receiveddata="";

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
      
      if(onORoff == "0") {
        nxnSwitch.switchOff((char*)homecode.c_str(),(char*)socket.c_str());
        Serial.println("OFF - " + homecode + " " + socket);
      }else if(onORoff == "1") {
        nxnSwitch.switchOn((char*)homecode.c_str(),(char*)socket.c_str());
        Serial.println("ON - " + homecode + " " + socket);
      }
  }
  delay(200); //Small delay
}
