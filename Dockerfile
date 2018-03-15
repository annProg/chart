FROM alpine:edge

ENV TIMEZONE Asia/Shanghai

RUN mkdir -p /home/wwwroot/ && mkdir -p /run/nginx && mkdir /var/log/supervisor && \
	mkdir /home/nobody && chown -R nobody.nobody /home/nobody && \
	sed -ri 's#^(nobody:.*)?:/:(.*)#\1:/home/nobody:\2#g' /etc/passwd
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && \
	apk update && \
	apk add nginx && \
	apk add --no-cache --virtual .build-deps git && \
	cd /home/wwwroot/ && \
	git clone https://github.com/annProg/chart && \
	mv chart default && \
	cd default && \
	rm -fr conf Dockerfile run.sh .git/ && \
	mkdir /usr/share/fonts && \
	mv fonts/wqy-microhei/wqy-microhei.ttc /usr/share/fonts && \
	rm -f tools/ditaa0_9.jar && \
	mv tools/ditaa /usr/bin && \
	mv init.sh / && \
	mv tools/mscgen /usr/bin && \
	rm -fr /var/cache/apk/* && \
	chown -R nginx.nginx /home/wwwroot/default && \
	apk del .build-deps

RUN apk add graphviz python3 py3-numpy py3-pillow && \
	rm -rf /var/cache/apk/*
RUN pip3 install myqr

RUN apk add --no-cache supervisor tzdata && \
	cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && \
	echo "${TIMEZONE}" > /etc/timezone && \
	apk add --no-cache php7 php7-fpm php7-common php7-gd \
	php7-json php7-curl php7-mbstring php7-iconv php7-opcache && \
	sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php7/php-fpm.conf && \
    sed -i "s|;date.timezone =.*|date.timezone = ${TIMEZONE}|" /etc/php7/php.ini && \
	rm -rf /var/cache/apk/*


COPY conf/default.conf /etc/nginx/conf.d/
COPY conf/supervisord.conf /etc/supervisord.conf

CMD ["sh", "/init.sh"]
