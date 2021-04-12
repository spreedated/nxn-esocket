#ifndef _NXN_NTP_H
#define _NXN_NTP_H

#include "Arduino.h"
#include <Udp.h>

class neXn_NTP
{
public:
	neXn_NTP(UDP& udpConn);
	/// <summary>
	/// By Hours
	/// </summary>
	/// <param name="offset"></param>
	void setTimezoneOffset(int offset);
	String Time;
	int Hour;
	int Minute;
	int Second;
private:
	NTPClient ntpClient;
	int TimezoneOffset;
};

#endif // !_NXN_NTP_H
