#!/bin/bash
CURDIR=`pwd`
/usr/bin/nohup $CURDIR/bin/sms >> $CURDIR/logs 2>&1 &