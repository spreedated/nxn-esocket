#ifndef _NXN_NTP_H
#define _NXN_NTP_H

class neXn_NTP
{
public:
	neXn_NTP(UDP& udpConn);
	String Time;
	int Hour;
	int Minute;
	int Second;
	int TimezoneOffset;
private:
	NTPClient ntpClient;
};

#endif // !_NXN_NTP_H
