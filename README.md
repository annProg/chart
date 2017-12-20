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

## 在线演示
https://api.annhe.net/gv/test.php

## 使用方法

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

![](http://api.annhe.net/gv/api.php?cht=gv&chl=digraph+G+%7Bnode%5Bfillcolor%3Dmintcream%2Cstyle%3Dfilled%5D%3Brankdir%3DLR%3Bplot-%3Egraphviz%3B%7D)

ditaa

![](http://api.annhe.net/gv/api.php?cht=ditaa&chl=%2B---------%2B%0D%0A%7C+cBLU++++%7C%0D%0A%7C+++++++++%7C%0D%0A%7C++++%2B----%2B%0D%0A%7C++++%7CcPNK%7C%0D%0A%7C++++%7C++++%7C%0D%0A%2B----%2B----%2B%0D%0A%09%09)

gnuplot

![](http://api.annhe.net/gv/api.php?cht=gp&chl=plot+sin%28x%29%2Ax%3B)

markdown mindmap

![](http://api.annhe.net/gv/api.php?cht=markdown&chl=%23+plot%0D%0A%23%23+graphviz%0D%0A%23%23%23+dot%0D%0A%23%23%23+neato%0D%0A%23%23%23+fdp%0D%0A%23%23%23+sfdp%0D%0A%23%23%23+twopi%0D%0A%23%23%23+circo%0D%0A%23%23+ditaa%0D%0A%23%23+gnuplot%0D%0A%23%23+markdown+mindmap%0D%0A%23%23%23+graphviz)
