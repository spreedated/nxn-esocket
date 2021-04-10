#ifndef _WEBPAGE_H
#define _WEBPAGE_H

const char* htmlcode PROGMEM = { "<!doctype html> <html lang=\"en\"> <head> <meta charset=\"utf-8\"> <title>##DEVICE## - Web Server</title> <meta name=\"author\" content=\"Markus Wackermann\"> <style type=\"text/css\"> .TableStyle { margin: auto; border-style:double; } .TableStyle tr td { padding:5px; } </style> </head> <body> <div style=\"margin:auto;text-align:center;\"> <h1>##DEVICE## - Web Server</h1> <br/> <br/> <form method=\"POST\" action=\"/switch\" style=\"margin:auto;\"> <table class=\"TableStyle\"> <tr> <td> Homecode: </td> <td> <input name=\"homecode\" id=\"homecode\" /> </td> </tr> <tr> <td> Socketcode: </td> <td> <input name=\"socket\" id=\"socket\" /> </td> </tr> <tr> <td> State: </td> <td> <select name=\"state\" id=\"state\"> <option value=\"1\">On</option> <option value=\"0\">Off</option> </select> </td> </tr> <tr> <td style=\"text-align:center;\" colspan=\"2\"> <button type=\"submit\">Send</button> </td> </tr> </table> </form> </div> </body> </html>" };

String SendHTML(){
	String ptr = String(htmlcode);
	ptr.replace("##DEVICE##", String(WiFi_Hostname));
  return ptr;
}

#endif // !_WEBPAGE_H
