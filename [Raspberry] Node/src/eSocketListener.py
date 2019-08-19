#!/usr/bin/python

import socket
import os
import datetime
from subprocess import Popen
from subprocess import PIPE
import sys
import esocket
import ConfigParser
import time

version = '1.10'

UDP_IP_ADDRESS = ''
UDP_PORT_NO = 0
INTERFACE = ''

log = esocket.Log()
log.logfile_location = '/var/log/esocket_listener.log'

def read_config():
	global UDP_PORT_NO,INTERFACE
	try:
		log.write_log('Reading config...', 'read_config', 'INIT')
		Config = ConfigParser.ConfigParser()
		dir_path = os.path.dirname(os.path.realpath(__file__))
		Config.read(dir_path + '/config.conf')
		UDP_PORT_NO = Config.getint('Listener','port')
		INTERFACE = Config.get('Listener','interface')
		log.write_log('Config loaded!', 'read_config', 'INIT')
	except Exception as e:
		log.write_log('[' + str(e) + ']', 'read_config', 'FATALERROR')

def get_own_ip(interface):
	global UDP_IP_ADDRESS
	p = Popen(['ifconfig','-a'], stdout=PIPE, stderr=PIPE)
	stdout,stderr = p.communicate()
	stdout = stdout.splitlines()
	stdpos = 0
	for line in stdout:
		stdpos += 1
		if (line.find(interface) != -1):
			linewithip = stdout[stdpos]
			ip = linewithip[linewithip.find('inet')+4:]
			ip = ip[:ip.find('netmask')]
			ip = ip.replace(' ','')
			log.write_log('IP Found [' + ip + ']', 'get_own_ip','INIT')
			UDP_IP_ADDRESS = ip
			return True
	log.write_log('Could not find local IP', 'get_own_ip', 'FATALERROR')
	log.write_log('Exiting...', 'get_own_ip', 'FATALERROR')
	sys.exit()
	return False

if __name__ == "__main__":
	read_config()
	get_own_ip(INTERFACE)
	log.write_log('Service start - Version: ' + version,'MAIN','INIT')

	serverSock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
	serverSock.bind((UDP_IP_ADDRESS, UDP_PORT_NO))
	log.write_log('Started listening on ' + UDP_IP_ADDRESS + ':' + str(UDP_PORT_NO),'MAIN','INIT')

	while True:
		data, addr = serverSock.recvfrom(4096)
		if(len(data) < 1):
			continue
		if(str(data).startswith('nxn#')):
			try:
				dt = data.split('#')
				if((int(dt[1]) % int(dt[2])) == 1337):
					serverSock.sendto('Genuine neXn-Systems device.', addr)
			except Exception as e:
				print(str(e))
			continue
		try:
			socket = data.split("#")
			for i in range(5):
				p = Popen(['/src/raspberry-remote/send','-b',socket[0],str(int(socket[1],2)),socket[2]], stdout=PIPE, stderr=PIPE)
				stdout, stderr = p.communicate()
				stdout = stdout.replace('\n',' --- ')
				stderr = stderr.replace('\n',' --- ')
				if(len(stdout) <= 0):
					log.write_log('Housecode['+socket[0]+'] - Device['+socket[1]+'] - State['+socket[2]+']' + '[RAW->] ' + stderr, 'MAIN','ERROR')
				else:
					log.write_log('Data sent -> Housecode['+socket[0]+'] - Device['+socket[1]+'] - State['+socket[2]+']' + '[RAW->] ' + stdout, 'MAIN','DATARCVD')
				time.sleep(0.2)
		except Exception, e:
			log.write_log('[' + str(e) + '] - Data rcvd: [' + str(data) + '] from [' + str(addr[0]) + ']', 'MAIN', 'ERROR')
