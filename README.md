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

| cht | 功能 | 备注 |
| ---- | ---- | -- |
| gv:(dot\|neato\|fdp\|sfdp\|twopi\|circo) | graphviz| gv=gv:dot |
| gp  | gnuplot ||
| ditaa | ditaa ||
| markdown:(dot\|neato\|fdp\|sfdp\|twopi\|circo) | markdown mindmap |markdown=markdown:dot|
| radar | 雷达图 ||
| msc | mscgen ||
| cover | 书籍封面 racovimge ||
| cover:ten | 书籍封面 tenprintcover.py ||
| qr | 二维码 ||
| blockdiag | blockdiag ||


## 部署

- [常规方法](docs/deploy.md)
- [Docker](docs/docker.md)

## 演示

graphviz

```
digraph G{node[fillcolor=mintcream,style=filled];rankdir=LR;plot->graphviz;}
```

![](https://api.annhe.net/gv/api.php?cht=gv&chl=digraph+G+%7Bnode%5Bfillcolor%3Dmintcream%2Cstyle%3Dfilled%5D%3Brankdir%3DLR%3Bplot-%3Egraphviz%3B%7D)

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

![](https://api.annhe.net/gv/api.php?cht=gp&chl=plot+sin%28x%29%2Ax%3B)

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

![](https://api.annhe.net/gv/api.php?cht=markdown&chl=%23+plot%0D%0A%23%23+Graphviz%0D%0A%23%23%23+dot%0D%0A%23%23%23+neato%0D%0A%23%23%23+fdp%0D%0A%23%23%23+sfdp%0D%0A%23%23%23+twopi%0D%0A%23%23%23+circo%0D%0A%23%23+ditaa%0D%0A%23%23+gnuplot%0D%0A%23%23+markdown+mindmap%0D%0A%23%23%23+graphviz)



