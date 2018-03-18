FROM alpine:edge

ENV TIMEZONE Asia/Shanghai

RUN mkdir -p /home/wwwroot/ && \
	mkdir -p /run/nginx && \
	mkdir /var/log/supervisor && \
	mkdir /home/nobody && chown -R nobody.nobody /home/nobody && \
	sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && \
	sed -ri 's#^(nobody:.*)?:/:(.*)#\1:/home/nobody:\2#g' /etc/passwd

RUN	apk update && \
	apk add --no-cache tzdata && \
	cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && \
	echo "${TIMEZONE}" > /etc/timezone && \
	apk add --no-cache supervisor nginx php7 php7-fpm php7-common php7-gd \
	php7-json php7-curl php7-mbstring php7-iconv php7-opcache \
	graphviz python3 py3-numpy py3-pillow librsvg py3-cffi nodejs-npm && \
	sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php7/php-fpm.conf && \
    sed -i "s|;date.timezone =.*|date.timezone = ${TIMEZONE}|" /etc/php7/php.ini && \
	rm -rf /var/cache/apk/*


COPY conf/pip.conf /root/.pip/pip.conf

RUN pip3 install myqr blockdiag racovimge cairocffi
RUN npm install -g svg-radar-chart virtual-dom-stringify

COPY conf/default.conf /etc/nginx/conf.d/
COPY conf/supervisord.conf /etc/supervisord.conf
COPY conf/.blockdiagrc /home/nobody/.blockdiagrc
COPY conf/rsvg /usr/bin/rsvg

RUN chmod +x /usr/bin/rsvg

# asymptote
RUN apk add --no-cache gsl-dev freeglut-dev gc-dev fftw-dev  \
	texlive texlive-xetex texlive-dvi ghostscript texmf-dist-latexextra && \
	rm -rf /var/cache/apk/*

RUN apk add --no-cache --virtual .build-deps git build-base bison flex zlib-dev autoconf && \
	cd /root && \
	git clone http://github.com/vectorgraphics/asymptote && \
	cd asymptote && \
	sed -i "s/#define HAVE_FEENABLEEXCEPT/\/\/#define HAVE_FEENABLEEXCEPT/g" fpu.h && \
	./autogen.sh && \
	./configure && \
	make asy && \
	make asy-keywords.el && \
	make install-asy && \
	cd ../ && rm -fr asymptote && \
	ln -s /usr/local/bin/asy /bin/asy && \
	rm -rf /var/cache/apk/* && \
	apk del .build-deps
	

# 更新代码
RUN	apk add --no-cache --virtual .build-deps git && \
	cd /home/wwwroot/ && \
	git clone https://github.com/annProg/chart && \
	mv chart default && \
	cd default && \
	rm -fr conf Dockerfile run.sh .git/ && \
	mv fonts/wqy-microhei/wqy-microhei.ttc /usr/share/fonts && \
	rm -f tools/ditaa0_9.jar && \
	mv tools/ditaa /usr/bin && \
	mv init.sh / && \
	mv tools/mscgen /usr/bin && \
	rm -fr /var/cache/apk/* && \
	chown -R nginx.nginx /home/wwwroot/default && \
	apk del .build-deps

CMD ["sh", "/init.sh"]
