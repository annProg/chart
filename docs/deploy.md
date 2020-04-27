# Deployment

## Install

| cht | Install | Note |
| -- | -- | -- |
|gv | install `graphviz` by yum, apt etc | require `graphviz-gd` |
|gp | install `gnuplot` by yum, apt etc | |
|ditaa |copy `tools/ditaa` to `/usr/local/bin`|https://github.com/akavel/ditaa|
|blockdiag |`pip install blockdiag` |The CJK configuration method is in the next section |
|radar |`npm install svg-radar-chart -g && npm install virtual-dom-stringify`||
|msc | copy `tools/mscgen` to `/usr/local/bin`||
|cover |`pip install racovimge && yum install librsvg2` |CentOS7 no `rsvg`，you can copy it from CentOS6|
|cover:ten |`pip install cairocffi` |tenprintcover.py(https://github.com/mgiraldo/tenprintcover-py)|
|qr |`pip install myqr` ||
|url2img |install `wkhtmltopdf` by yum, apt etc||
|asy | install `asymptote` by yum, apt etc||

## blockdiag CJK configuration
```
cp -r fonts/* /usr/share/fonts
cat > /home/www/.blockdiagrc <<EOF
[blockdiag]
fontpath = /usr/share/fonts/wqy-microhei/wqy-microhei.ttc
EOF
``` 

## CORS
Nginx configuration

```
add_header Access-Control-Allow-Origin *;
add_header Access-Control-Allow-Methods POST,OPTIONS;
add_header Access-Control-Allow-Headers Content-Type;
```

## scheme

Nginx configuration

```
proxy_set_header X-Forwarded-Proto $scheme;
```

## CDN

CDN 源站加以下配置， `root` 是 `chart` 的 `cache` 所在目录

```
location ^~ /cache/ {
	root /home/chart;
}
```
