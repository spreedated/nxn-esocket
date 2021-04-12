#include <NTPClient.h>
#include "nxn_ntp.h"

neXn_NTP::neXn_NTP(UDP& udpConn)
{
	this->ntpClient = NTPClient(udpConn, "de.pool.ntp.org", 3600, 60000);
}

void neXn_NTP::setTimezoneOffset(int offset)
{
	
}