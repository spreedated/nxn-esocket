#!/usr/bin/python
import datetime
import sys
import os
from pathlib import Path
from subprocess import Popen
from subprocess import PIPE

version = 'v1.2'

class PID():
	"""self.filename should be declared as '__file__' for instance 'pid.filename = __file__' """
	def __init__(self):
		self.filename = None

	def write_pid_file(self):
		filename = str(self.filename).replace('./','')
		filename = filename[:filename.find('.')] + '.pid'

		if(Path('/var/run/'+ filename).is_file()):
			f = open('/var/run/'+ filename,'r')
			print('PID already exists with: ' + str(f.read()) + ' !')
			f.close()
			sys.exit()

		f = open('/var/run/'+ filename,'w')
		f.write(str(os.getpid()))
		f.close()

class Log():
	def __init__(self):
		self.logfile_location = None
		self.version = 'v1.0'

	def write_log(self, log, sender, type = 'INFO'):
		now = datetime.datetime.now()
		rightnow = '['+str(now.day).zfill(2)+'.'+str(now.month).zfill(2)+'.'+str(now.year).zfill(2)+' -- '+str(now.hour).zfill(2)+':'+str(now.minute).zfill(2)+':'+str(now.second).zfill(2) + ':' + str(now.microsecond) + ']'
		f = open(self.logfile_location, 'a')
		f.write('\n' + rightnow + ' | ' + type + '\t|' + sender + '\t|   |' + log)
		f.close()
	def show_log(self):
		#column -tx -s $'\t' -n /var/log/esocket_listener.log
		p = Popen(['column','-tx','-s','$\'\t\'','-n',self.logfile_location], stdout=PIPE, stderr=PIPE)
		stdout, stderr = p.communicate()
		if(len(stdout) >= 1):
			if(stdout.rfind('\n') == len(stdout)-1):
				print(stdout[:stdout.rfind('\n')])
			else:
				print(stdout)
		elif(len(stderr) >= 1):
			print(stderr)
