# 部署方法


| cht | 安装方式 | 说明 |
| -- | -- | -- |
|gv | yum,apt等安装graphviz | 依赖`graphviz-gd` |
|gp | yum,apt等安装gnuplot | |
|ditaa |使用`tools/ditaa`, 复制 `tools/ditaa`到`/usr/local/bin`目录下即可|https://github.com/akavel/ditaa|
|blockdiag |`pip install blockdiag` |中文字体参考下文配置 |
| radar |`npm install svg-radar-chart -g && npm install virtual-dom-stringify`||
|msc | 使用`tools/mscgen`, 复制 `tools/mscgen`到`/usr/local/bin`目录下即可||
|cover |`pip install racovimge && yum install librsvg2` |Centos7上没有`rsvg`命令，可以从Centos6直接拷贝过去|
|cover:ten |`tenprintcover.py已位于./tools/目录 pip install cairocffi` |tenprintcover.py(https://github.com/mgiraldo/tenprintcover-py)|
| qr |`pip install myqr` ||

### blockdiag配置中文字体
```
cp -r fonts/* /usr/share/fonts
cat > /home/www/.blockdiagrc <<EOF
[blockdiag]
fontpath = /usr/share/fonts/wqy-microhei/wqy-microhei.ttc
EOF
``` 

### CORS支持
Nginx增加如下配置

```
add_header Access-Control-Allow-Origin *;
add_header Access-Control-Allow-Methods POST,OPTIONS;
add_header Access-Control-Allow-Headers Content-Type;
```

