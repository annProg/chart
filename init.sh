#!/bin/sh
CACHEDIR=$WWWROOT/cache
[ ! -d $CACHEDIR ] && mkdir $CACHEDIR
cp static/error.png $CACHEDIR
chown -R www-data:www-data $CACHEDIR
#ln -s $APP_CONFIG_PATH/CONFIG $WWWROOT/config.php

PHP_CONF="/etc/php/7.3/fpm/pool.d/www.conf"
# catch_workers_output = yes 日志输出到stdout stderr
echo "catch_workers_output = yes" >> $PHP_CONF
env |grep -v "=$" | grep "=" | sed -r "s/([a-zA-Z0-9_.]+)=(.*)/env[\1]='\2'/" |grep "^env\[" >> $PHP_CONF

exec supervisord -n

