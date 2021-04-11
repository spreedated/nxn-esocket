#include <NTPClient.h>

neXn_NTP::neXn_NTP(UDP& udpConn)
{
	this->ntpClient = NTPClient(udpConn, "de.pool.ntp.org", 3600, 60000);
}