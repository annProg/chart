# chart api

包含graphviz，gnuplot，ditaa, 思维导图, 雷达图, mscgen的画图api

## 部署

### graphviz
使用包管理工具安装，需要安装`graphviz-gd`

### gnuplot
使用包管理工具安装

### ditaa
使用`tools/ditaa`, 复制 `tools/ditaa`到`/usr/local/bin`目录下即可

这里使用的ditaa是go语言实现的ditaa版本:https://github.com/akavel/ditaa

git pull 拉取代码到web目录，执行`cp config.php.sample config.php` ，根据实际情况修改 `config.php`

### blockdiag
```
pip install blockdiag
```
如需使用中文，请配置中文字体，参考配置
```
cp -r fonts/* /usr/share/fonts
cat > /home/www/.blockdiagrc <<EOF
[blockdiag]
fontpath = /usr/share/fonts/wqy-microhei/wqy-microhei.ttc
EOF
```

### 雷达图
```
npm install svg-radar-chart -g
npm install virtual-dom-stringify
```

### mscgen
使用`tools/mscgen`, 复制 `tools/mscgen`到`/usr/local/bin`目录下即可

### book cover
使用racovimge
```
pip install racovimge
yum install librsvg2
```
Centos7上没有`rsvg`命令，可以从Centos6直接拷贝过去

### CORS支持
Nginx增加如下配置

```
add_header Access-Control-Allow-Origin *;
add_header Access-Control-Allow-Methods POST,OPTIONS;
add_header Access-Control-Allow-Headers Content-Type;
```


## 在线演示
https://api.annhe.net/gv/editor.php

## 使用方法
使用GET或者POST方法，提供以下参数

| 参数 | 用途 |
| ---- | ---- |
| cht  | plot引擎 |
| chl  | plot源码 |
| chof | 输出格式 |

### cht
graphviz可选：
```
gv, gv:dot, gv:neato, gv:fdp, gv:sfdp, gv:twopi, gv:circo
```
其中 `gv=gv:dot`

gnuplot可选:
```
gp
```

ditaa可选:
```
ditaa
```

markdown mindmap可选
```
markdown, markdown:dot, markdown:neato, markdown:fdp, markdown:sfdp, markdown:twopi, markdown:circo
```
其中`markdown=markdown:dot`

雷达图可选
```
radar
```

mscgen可选
```
msc
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
```
