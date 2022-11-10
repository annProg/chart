#!/bin/sh
CACHEDIR=$WWWROOT/cache
[ ! -d $CACHEDIR ] && mkdir $CACHEDIR
cp $WWWROOT/static/error.png $CACHEDIR
chown -R www-data:www-data $CACHEDIR
#ln -s $APP_CONFIG_PATH/CONFIG $WWWROOT/config.php

PHP_CONF="/etc/php/7.3/fpm/pool.d/www.conf"
# catch_workers_output = yes 日志输出到stdout stderr
echo "catch_workers_output = yes" >> $PHP_CONF
env |grep -v "=$" | grep "=" | sed -r "s/([a-zA-Z0-9_.]+)=(.*)/env[\1]='\2'/" |grep "^env\[" >> $PHP_CONF

ln -s $WWWROOT/editor.php $WWWROOT/index.php

# 修复 tenprintcover.py 中文字体. Noto Sans CJK SC 大于 100MB，使用文泉驿字体代替
sed -i 's/Noto Sans CJK SC/WenQuanYi Micro Hei/g' /usr/bin/tenprintcover.py

# 复制truck图片，并统一设置宽度

cp -r $WWWROOT/images/truck $CACHEDIR
cd $CACHEDIR/truck
for id in `ls`;do
	mogrify -resize 150 $id
done

exec supervisord -n

