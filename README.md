# chart api

包含graphviz，gnuplot，ditaa的画图api

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

### CORS支持
Nginx增加如下配置

```
add_header Access-Control-Allow-Origin *;
add_header Access-Control-Allow-Methods POST,OPTIONS;
add_header Access-Control-Allow-Headers Content-Type;
```


## 在线演示
https://api.annhe.net/gv/test.php

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

