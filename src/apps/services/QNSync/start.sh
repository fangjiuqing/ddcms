#!/bin/bash
CURDIR=`pwd`
/usr/bin/nohup $CURDIR/bin/sync >> $CURDIR/logs 2>&1 &