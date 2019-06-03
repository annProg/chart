FROM alpine:3.9

ENV TIMEZONE Asia/Shanghai
ENV WWWROOT /home/wwwroot/default

RUN mkdir -p ${WWWROOT} && \
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
	graphviz python3 py3-numpy py3-pillow librsvg py3-cffi && \
	sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php7/php-fpm.conf && \
    sed -i "s|;date.timezone =.*|date.timezone = ${TIMEZONE}|" /etc/php7/php.ini && \
	rm -rf /var/cache/apk/*

# asymptote
RUN apk add --no-cache gsl-dev freeglut-dev gc-dev fftw-dev  \
	texlive texlive-xetex texlive-dvi ghostscript texmf-dist-latexextra;true && \
	rm -rf /var/cache/apk/*
RUN apk add --no-cache --virtual .build-deps git build-base bison flex zlib-dev autoconf && \
	cd /root && \
	wget https://github.com/vectorgraphics/asymptote/archive/2.44.tar.gz && \
	tar zxvf 2.44.tar.gz && \
	cd asymptote-2.44 && \
	sed -i "s/#define HAVE_FEENABLEEXCEPT/\/\/#define HAVE_FEENABLEEXCEPT/g" fpu.h && \
	./autogen.sh && \
	./configure && \
	make asy && \
	make asy-keywords.el && \
	make install-asy && \
	cd ../ && rm -fr asymptote* *.tar.gz && \
	ln -s /usr/local/bin/asy /bin/asy && \
	rm -rf /var/cache/apk/* && \
	apk del .build-deps


COPY conf/pip.conf /root/.pip/pip.conf
RUN pip3 install myqr blockdiag racovimge cairocffi

COPY conf/default.conf /etc/nginx/conf.d/
COPY conf/supervisord.conf /etc/supervisord.conf
COPY conf/.blockdiagrc /home/nobody/.blockdiagrc
COPY conf/rsvg /usr/bin/rsvg

RUN chmod +x /usr/bin/rsvg

# 更新代码
RUN chown -R nginx.nginx ${WWWROOT}
COPY *.php ${WWWROOT}/
COPY libs ${WWWROOT}/libs
COPY functions ${WWWROOT}/functions
COPY images ${WWWROOT}/images
COPY static ${WWWROOT}/static
COPY fonts/wqy-microhei /usr/share/fonts/wqy-microhei
COPY tools/ditaa /usr/bin
COPY tools/mscgen /usr/bin
COPY init.sh /
RUN ls ${WWWROOT}

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

CMD ["sh", "/init.sh"]
