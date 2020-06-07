FROM ubuntu:19.10

ENV TIMEZONE Asia/Shanghai
ENV WWWROOT /home/wwwroot/default

RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone

RUN mkdir -p ${WWWROOT} && \
	mkdir -p /run/nginx && \
	mkdir /var/log/supervisor && \
	mkdir /home/nobody && chown -R nobody:nogroup /home/nobody && \
	sed -ri 's#^(nobody:.*)?:/:(.*)#\1:/home/nobody:\2#g' /etc/passwd

# nginx + php
RUN	apt-get update && \
	apt-get install --no-install-recommends -y supervisor nginx php7.3 php7.3-fpm php7.3-gd \
	php7.3-json php7.3-curl php7.3-mbstring php7.3-iconv php7.3-opcache && \
	rm -fr /var/cache/apt/*
RUN	sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/7.3/fpm/php-fpm.conf && \
    sed -i "s|;date.timezone =.*|date.timezone = ${TIMEZONE}|" /etc/php/7.3/fpm/php.ini

# graphviz asymptote wkhtmltopdf
RUN	apt-get update && \
	apt-get install --no-install-recommends -y graphviz asymptote wkhtmltopdf && \
	rm -fr /var/cache/apt/*

# python3
RUN	apt-get update && \
	apt-get install --no-install-recommends -y python3 python3-numpy python3-pillow librsvg2-bin python3-cffi python3-pip python3-setuptools && \
	rm -rf /var/cache/apt/*


RUN pip3 install myqr blockdiag racovimge cairocffi

# gnuplot
RUN	apt-get update && \
	apt-get install --no-install-recommends -y gnuplot && \
	rm -rf /var/cache/apt/*

# fix racovimge font dir
RUN sed -i 's|~|/tmp|g' /usr/local/lib/python3.7/dist-packages/racovimge/racovimge.py

# fix wkhtmltopdf ref:https://github.com/wkhtmltopdf/wkhtmltopdf/issues/4497
RUN apt-get install --no-install-recommends -y binutils && rm -rf /var/cache/apt/*
RUN strip --remove-section=.note.ABI-tag /usr/lib/x86_64-linux-gnu/libQt5Core.so.5

# draft
RUN apt-get update && apt-get install --no-install-recommends -y wget && \
	wget https://github.com/lucasepe/draft/releases/download/v0.1.0/draft_0.1.0_linux_64-bit.tar.gz -O /tmp/draft.tar.gz && \
	tar zxvf /tmp/draft.tar.gz -C /usr/bin && rm -f /tmp/draft.tar.gz && \
	apt-get remove -y wget --purge && \
   	apt-get autoremove -y && apt-get clean

COPY conf/default.conf /etc/nginx/sites-enabled/default
COPY conf/supervisord.conf /etc/supervisord.conf
COPY conf/.blockdiagrc /home/nobody/.blockdiagrc
COPY conf/rsvg /usr/bin/rsvg

RUN chmod +x /usr/bin/rsvg

COPY conf/www.conf /etc/php/7.3/fpm/pool.d/www.conf
RUN mkdir /run/php

# 更新代码
RUN chown -R www-data:www-data ${WWWROOT}
COPY *.php ${WWWROOT}/
COPY libs ${WWWROOT}/libs
COPY functions ${WWWROOT}/functions
COPY images ${WWWROOT}/images
COPY static ${WWWROOT}/static
COPY fonts/wqy-microhei /usr/share/fonts/wqy-microhei
COPY tools/ditaa /usr/bin
COPY tools/mscgen /usr/bin
COPY tools/tenprintcover.py /usr/bin
COPY vendor ${WWWROOT}/vendor
COPY init.sh /
RUN ls ${WWWROOT}

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

CMD ["sh", "/init.sh"]
