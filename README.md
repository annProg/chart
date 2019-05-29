# Text to Chart API

文本转图片接口

支持graphviz，gnuplot，ditaa, 思维导图, 雷达图, mscgen等

## 快速开始

Demo:  https://api.annhe.net/gv/editor.php

使用GET或者POST方法，提供以下参数

| 参数 | 用途 |
| ---- | ---- |
| cht  | plot引擎 |
| chl  | plot源码 |
| chof | 输出格式 |


支持的画图引擎(cht参数)

| cht | 功能 |
| ---- | ---- |
| gv:(dot\|neato\|fdp\|sfdp\|twopi\|circo) | graphviz|
| gv | =gv:dot |
| gp  | gnuplot |
| ditaa | ditaa |
| markdown:(dot\|neato\|fdp\|sfdp\|twopi\|circo) | markdown mindmap |
| markdown | =markdown:dot |
| radar | 雷达图 |
| msc | mscgen |
| cover | 书籍封面 racovimge |
| cover:ten | 书籍封面 tenprintcover.py |
| qr | 二维码 |
| blockdiag | blockdiag |

## 部署

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




## 演示

graphviz

```
digraph G{node[fillcolor=mintcream,style=filled];rankdir=LR;plot->graphviz;}
```

![](http://api.annhe.net/gv/api.php?cht=gv&chl=digraph+G+%7Bnode%5Bfillcolor%3Dmintcream%2Cstyle%3Dfilled%5D%3Brankdir%3DLR%3Bplot-%3Egraphviz%3B%7D)

ditaa

```
       +----------+ edit +----------+   input +----------+ compile +----------+
       |  cPNK    |      |  cRED    |         |   cGRE   |         |  cPNK    |
       | refined  |<-----+ h,cpp    +-------->+ compiler,+-------->+Executable|
       |   h,cpp  |      |          |         | linker   |         |   File   |
       | {s}      |      |  {io}    |         |          |         |    {s}   |
       +----------+      +----+-----+         +----------+         +----------+
                              | input
                              v
                         +----------+
                         |  cGRE    |
                         | doxygen  |
                         |          |
                         +----+-----+
                              | process
                              v
                         +----------+
                         |  cPNK    |
                         | Doxgen   |
                         | Document |
                         |    {d}   |
                         +----------+
```

![](https://api.annhe.net/gv/api.php?cht=ditaa&chl=+++++++%2B----------%2B+edit+%2B----------%2B+++input+%2B----------%2B+compile+%2B----------%2B%0D%0A+++++++%7C++cPNK++++%7C++++++%7C++cRED++++%7C+++++++++%7C+++cGRE+++%7C+++++++++%7C++cPNK++++%7C%0D%0A+++++++%7C+refined++%7C%3C-----%2B+h%2Ccpp++++%2B--------%3E%2B+compiler%2C%2B--------%3E%2BExecutable%7C%0D%0A+++++++%7C+++h%2Ccpp++%7C++++++%7C++++++++++%7C+++++++++%7C+linker+++%7C+++++++++%7C+++File+++%7C%0D%0A+++++++%7C+%7Bs%7D++++++%7C++++++%7C++%7Bio%7D++++%7C+++++++++%7C++++++++++%7C+++++++++%7C++++%7Bs%7D+++%7C%0D%0A+++++++%2B----------%2B++++++%2B----%2B-----%2B+++++++++%2B----------%2B+++++++++%2B----------%2B%0D%0A++++++++++++++++++++++++++++++%7C+input%0D%0A++++++++++++++++++++++++++++++v%0D%0A+++++++++++++++++++++++++%2B----------%2B%0D%0A+++++++++++++++++++++++++%7C++cGRE++++%7C%0D%0A+++++++++++++++++++++++++%7C+doxygen++%7C%0D%0A+++++++++++++++++++++++++%7C++++++++++%7C%0D%0A+++++++++++++++++++++++++%2B----%2B-----%2B%0D%0A++++++++++++++++++++++++++++++%7C+process%0D%0A++++++++++++++++++++++++++++++v%0D%0A+++++++++++++++++++++++++%2B----------%2B%0D%0A+++++++++++++++++++++++++%7C++cPNK++++%7C%0D%0A+++++++++++++++++++++++++%7C+Doxgen+++%7C%0D%0A+++++++++++++++++++++++++%7C+Document+%7C%0D%0A+++++++++++++++++++++++++%7C++++%7Bd%7D+++%7C%0D%0A+++++++++++++++++++++++++%2B----------%2B)

gnuplot

```
plot sin(x)*x;
```

![](http://api.annhe.net/gv/api.php?cht=gp&chl=plot+sin%28x%29%2Ax%3B)

markdown mindmap

```
# plot
## graphviz
### dot
### neato
### fdp
### sfdp
### twopi
### circo
## ditaa
## gnuplot
## markdown mindmap
### graphviz
```

![](http://api.annhe.net/gv/api.php?cht=markdown&chl=%23+plot%0D%0A%23%23+Graphviz%0D%0A%23%23%23+dot%0D%0A%23%23%23+neato%0D%0A%23%23%23+fdp%0D%0A%23%23%23+sfdp%0D%0A%23%23%23+twopi%0D%0A%23%23%23+circo%0D%0A%23%23+ditaa%0D%0A%23%23+gnuplot%0D%0A%23%23+markdown+mindmap%0D%0A%23%23%23+graphviz)


radar chart

```
name,价格,易用性,性能,外观,功能
iphoneX,.5,.9,1,.9,.8
Mi6,.8,.9,.9,.8,.8
P10,.6,.9,.9,.8,.8
```

![](https://api.annhe.net/gv/cache/images/9e2055259519baca0f6eb86a5d4cdedfradar.svg)

mscgen
```
# Fictional client-server protocol
msc {
 arcgradient = 8;

 a [label="Client"],b [label="Server"];

 a=>b [label="data1"];
 a-xb [label="data2"];
 a=>b [label="data3"];
 a<=b [label="ack1, nack2"];
 a=>b [label="data2", arcskip="1"];
 |||;
 a<=b [label="ack3"];
 |||;
}
```

![](https://api.annhe.net/gv/api.php?cht=msc&chl=%23+Fictional+client-server+protocol%0D%0Amsc+%7B%0D%0A+arcgradient+%3D+8%3B%0D%0A%0D%0A+a+%5Blabel%3D%22Client%22%5D%2Cb+%5Blabel%3D%22Server%22%5D%3B%0D%0A%0D%0A+a%3D%3Eb+%5Blabel%3D%22data1%22%5D%3B%0D%0A+a-xb+%5Blabel%3D%22data2%22%5D%3B%0D%0A+a%3D%3Eb+%5Blabel%3D%22data3%22%5D%3B%0D%0A+a%3C%3Db+%5Blabel%3D%22ack1%2C+nack2%22%5D%3B%0D%0A+a%3D%3Eb+%5Blabel%3D%22data2%22%2C+arcskip%3D%221%22%5D%3B%0D%0A+%7C%7C%7C%3B%0D%0A+a%3C%3Db+%5Blabel%3D%22ack3%22%5D%3B%0D%0A+%7C%7C%7C%3B%0D%0A%7D)

book cover

```
标题
作者
子标题(tenprintcover支持子标题)
```

qrcode
```
文本
```
