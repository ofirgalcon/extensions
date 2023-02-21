#!/usr/local/munkireport/munkireport-python3

# Written by Tuxudo
# With much help from frogor

import objc
from Foundation import NSBundle
from Foundation import NSURL

import plistlib
import os
import subprocess
import sys

# Get kexts info
IOKit = NSBundle.bundleWithIdentifier_('com.apple.framework.IOKit')
functions = [('KextManagerCopyLoadedKextInfo', b'@@@'),('KextManagerCreateURLForBundleIdentifier', b'@@@'),]
objc.loadBundleFunctions(IOKit, globals(), functions)
kernel_dict = KextManagerCopyLoadedKextInfo(None, None)

info = {}    
count = 0

for kernelname in kernel_dict:
    if kernelname != '__kernel__' and not kernelname.startswith('com.apple.'):
        bundle_path = kernel_dict[kernelname]['OSBundlePath']
        bundle_version = kernel_dict[kernelname]['CFBundleVersion']
        bundle_executable = kernel_dict[kernelname]['OSBundleExecutablePath']
        bundle_codesign = ''
        developer_name = ''
        team_id = ''

        from subprocess import Popen, PIPE
        stdout = Popen("/usr/bin/codesign -dv --verbose=4 '"+bundle_path+"'", shell=True, stderr=PIPE).stderr        
        output = stdout.read()
                
        for line in output.decode().splitlines():
            if "Authority=Developer ID Application: " in line:
                bundle_codesign = line.replace("Authority=Developer ID Application: ", "")
                developer_name = " ".join(bundle_codesign.split()[:-1])
                team_id = bundle_codesign.split()[-1].strip("()")

        info[str(count)] = {'bundle_id':kernelname,'path':bundle_path,'version':bundle_version,'executable':bundle_executable,'developer':developer_name, 'teamid':team_id}
        count = count+1

# Write results to cache file
cachedir = '%s/cache' % os.path.dirname(os.path.realpath(__file__))
output_plist = os.path.join(cachedir, 'extensions.plist')
try:
    plistlib.writePlist(info, output_plist)
except:
    with open(output_plist, 'wb') as fp:
        plistlib.dump(info, fp, fmt=plistlib.FMT_XML)
