#!/usr/bin/python

import socket
import sys
import os
import datetime
import pymysql.cursors
import ConfigParser

version = '1.3'

if len(sys.argv) > 2:
	Message = sys.argv[1] + "#" + sys.argv[2] + "#" + sys.argv[3]
else:
	print("Not enough arguments!")
	sys.exit()

now = datetime.datetime.now()
clientSock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)

#Get DB Config
database_credentials = {}
def read_database_config():
	global database_credentials
	Config = ConfigParser.ConfigParser()
	dir_path = os.path.dirname(os.path.realpath(__file__))
	Config.read(dir_path + '/config.conf')
	for item in Config.items('Database'):
		database_credentials[item[0]] = item[1]
	return True

if read_database_config():
	print('Config loaded...')
else:
	print('Config error... exiting')
	sys.exit()

connection = pymysql.connect(host=database_credentials['host'],
							 user=database_credentials['user'],
							 password=database_credentials['password'],
							 db=database_credentials['db'],
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
		cursor2.execute('UPDATE nxn_esocket.sockets SET state='+sys.argv[3]+' WHERE housecode=' + sys.argv[1] + ' AND socketcode=' + sys.argv[2])
finally:
	connection.commit()
	connection.close()
