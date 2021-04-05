#ifndef _WEBPAGE_H
#define _WEBPAGE_H

String SendHTML(){
  String ptr = "<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\"><title>" + String(deviceName) + "</title><style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}body{margin-top: 50px;} h1 {color: #444444;margin: 50px auto 30px;} h3 {color: #444444;margin-bottom: 50px;}.button {display: block;width: 80px;background-color: #3498db;border: none;color: white;padding: 13px 30px;text-decoration: none;font-size: 25px;margin: 0px auto 35px;cursor: pointer;border-radius: 4px;}.button-on {background-color: #3498db;}.button-on:active {background-color: #2980b9;}.button-off {background-color: #34495e;}.button-off:active {background-color: #2c3e50;}p {font-size: 14px;color: #888;margin-bottom: 10px;}</style></head><body><h1>" + String(deviceName) + " Web Server</h1><h3>Client-ID: " + String(clientID) + "</h3><hr/><h3>MQTT-Broker: " + String(mqtt_server) + "</h3><h3>Command-Topic: " + String(commandTopic) + "</h3><h3>Command-Response-Topic: " + String(commandResponseTopic) + "</h3><hr/><h3>OTA-Port: " + String(otaPort) + "</h3><h3>OTA-MD5: " + String(otaMD5Password) + "</h3><hr/><h3>433-Transmitter-Pin: " + String(trasmitterDataPin) + "</h3></body></html>";
  return ptr;
}

#endif // !_WEBPAGE_H
