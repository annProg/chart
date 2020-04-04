#!/bin/sh
CACHEDIR=$WWWROOT/cache
[ ! -d $CACHEDIR ] && mkdir $CACHEDIR
chown -R nobody.nobody $CACHEDIR
#ln -s $APP_CONFIG_PATH/CONFIG $WWWROOT/config.php
exec supervisord -n
