#!/bin/bash

############################
# Usage:
# File Name: run.sh
# Author: annhe  
# Mail: i@annhe.net
# Created Time: 2018-03-15 17:10:40
############################

[ $# -lt 1 ] && echo "$0 /path/of/config.php /path/of/cachedir" && exit 1
function run() {
	docker stop ann-chart-docker &>/dev/null
	docker rm ann-chart-docker &>/dev/null
	docker run -d --name ann-chart-docker -p 8080:80 -v $1:/home/wwwroot/default/config.php -v $2:/home/wwwroot/default/cache ann/chart
}

run $1 $2
