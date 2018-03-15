#!/bin/sh
chown -R nobody.nobody /home/wwwroot/default/cache
supervisord -n
