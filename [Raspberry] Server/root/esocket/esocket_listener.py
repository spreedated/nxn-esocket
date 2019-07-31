#!/usr/bin/python

import socket
import os
import datetime
from subprocess import Popen
from subprocess import PIPE
import sys
import esocket

# pid = nexn.PID()
# pid.filename = __file__
# pid.write_pid_file()

version = '1.6'

UDP_IP_ADDRESS = ''
UDP_PORT_NO = 0
INTERFACE = ''

log = esocket.Log()
log.logfile_location = '/var/log/esocket_listener.log'

def read_config():
	global UDP_PORT_NO,INTERFACE
	try:
		filepath = str(__file__)
		filepath = filepath[:filepath.rfind('/')+1]
		f = open(filepath + 'esocket_listener.config','r')
		content = f.read()
		f.close()
		log.write_log('Reading config...', 'read_config', 'INIT')
		for line in content.splitlines():
			if line.find('PORT') >= 1:
				UDP_PORT_NO = int(line[line.find('=')+1:])
			if line.find('INTERFACE') >= 1:
				INTERFACE = int(line[line.find('=')+1:])
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
		data, addr = serverSock.recvfrom(1024)
		if(len(data) > 1):
			pass
		else:
			continue
		try:
			socket = data.split("#")
			#os.system("/src/raspberry-remote/send " + socket[0] + " " + socket[1] + " " +  socket[2])
			p = Popen(['/src/raspberry-remote/send',socket[0],socket[1],socket[2]], stdout=PIPE, stderr=PIPE)
			stdout, stderr = p.communicate()
			stdout = stdout.replace('\n',' --- ')
			stderr = stderr.replace('\n',' --- ')
			if(len(stdout) <= 0):
				log.write_log('Housecode['+socket[0]+'] - Device['+socket[1]+'] - State['+socket[2]+']' + '[RAW->] ' + stderr, 'MAIN','ERROR')
			else:
				log.write_log('Data sent -> Housecode['+socket[0]+'] - Device['+socket[1]+'] - State['+socket[2]+']' + '[RAW->] ' + stdout, 'MAIN','DATARCVD')
		except Exception, e:
			log.write_log('[' + str(e) + '] - Data rcvd: [' + str(data) + '] from [' + str(addr[0]) + ']', 'MAIN', 'ERROR')
