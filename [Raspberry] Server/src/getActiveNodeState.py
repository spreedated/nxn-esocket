#!/usr/bin/python

from subprocess import PIPE
from subprocess import Popen
import socket
import sys
import os
import datetime
import pymysql.cursors
import ConfigParser
import time

version = '1.1'

now = datetime.datetime.now()

#Get DB Config
database_credentials = {}
def read_database_config():
	global database_credentials
	Config = ConfigParser.ConfigParser()
	dir_path = os.path.dirname(os.path.realpath(__file__))
	Config.read(dir_path + "/config.conf")
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

def get_nodes():
	nodes = []
	try:
		with connection.cursor() as cursor:
			cursor.execute("SELECT ip,port FROM nxn_esocket.nodes")
			for row in cursor:
				nodes.append(row['ip'] + '#' + row['port'])
	finally:
		return nodes

def setNodeActive(ip, isActive):
	try:
		with connection.cursor() as cursor:
			cursor.execute("UPDATE nxn_esocket.nodes SET is_active = \'" + str(isActive) + "\' WHERE nxn_esocket.nodes.ip = '" + ip + '\'')
		connection.commit()
	except Exception as e:
		pass

def terminate():
	connection.close()

def getAnswer(nodes):
	print('checking...')
	for node in nodes:
		mynode = node.split('#')
		print('Checking -> ' + str(mynode[0]) + ':' + str(mynode[1]))
		isOn = 0
		try:
			sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM) #UDP
			sock.settimeout(3.0)
			sock.sendto('nxn#2675#1338', (str(mynode[0]), int(mynode[1])))
			data, address = sock.recvfrom(4096)
			if(data):
				print(data)
				if ('Genuine neXn-Systems device.' in str(data)):
					print(str(mynode[0]) + ':' + str(mynode[1]) +' --- Node up!')
					isOn = 1
		except Exception as e:
			print(str(mynode[0]) + ':' + str(mynode[1]) +' --- Node down!')
		finally:
			setNodeActive(str(mynode[0]), isOn)


if __name__ == "__main__":
	while True:
		getAnswer(get_nodes())
		time.sleep(600)
	terminate()
