#!/usr/bin/python

import socket
import sys
import datetime
import pymysql.cursors

if len(sys.argv) > 2:
	Message = sys.argv[1] + "#" + sys.argv[2] + "#" + sys.argv[3]
else:
	print("Not enough arguments!")
	sys.exit()

now = datetime.datetime.now()
clientSock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)

connection = pymysql.connect(host='192.168.1.105',
							 user='root',
							 password='',
							 db='nxn_esocket',
							 charset='utf8mb4',
							 cursorclass=pymysql.cursors.DictCursor)

try:
	with connection.cursor() as cursor:
		cursor.execute("SELECT ip,port,is_active FROM nxn_esocket.nodes")
		for row in cursor:
			rightnow = '[ '+str(now.day)+'.'+str(now.month)+'.'+str(now.year)+' -- '+str(now.hour)+':'+str(now.minute)+':'+str(now.second)+':'+str(now.microsecond)+' ] '
			try:
				if row['is_active']:
					UDP_IP_ADDRESS = row['ip']
					UDP_PORT_NO = int(row['port'])
					clientSock.sendto(Message, (UDP_IP_ADDRESS, UDP_PORT_NO))
					print(rightnow + 'sent to ' + row['ip'] + ':' + row['port'])
			except Exception as e:
				print("Error: " + rightnow + str(e))
	#
	# update state
	#
	with connection.cursor() as cursor2:
		cursor2.execute('UPDATE nxn_esocket.sockets SET state='+sys.argv[3]+' WHERE dip_main=' + sys.argv[1] + ' AND dip_second=' + sys.argv[2])
finally:
	connection.commit()
	connection.close()
