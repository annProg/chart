# gnuplot

```
plot sin(x)*x;
```

![](https://api.annhe.net/api.php?cht=gp&chl=plot+sin%28x%29%2Ax%3B)

## 基本信息

| -- | -- |
| 代码 | <https://github.com/annProg/chart> |
| 功能 | 接受 gnuplot 命令，返回图片 |

## 参数说明

| -- | -- |
| cht=gp | gnuplot 使用 gp（[graphviz 使用 gv](http://www.annhe.net/article-3196.html)） |
| chl=<gnuplot command> | gnuplot 命令（目前只支持 png 格式，即 set term gif 等无效）|

## 演示
![](http://api.annhe.net/gv/api.php?cht=gp\&chl=plot x)
![sin(x)](http://api.annhe.net/gv/api.php?cht=gp\&chl=plot sin\(x\))

![sin(x)*tan(x)](http://api.annhe.net/gv/api.php?cht=gp\&chl=plot sin\(x\)*tan\(x\))

![多个函数](http://api.annhe.net/gv/api.php?cht=gp&chl=plot%20sin(x)%20title%20%27sin%27,tan(x)%20title%20%27tan%27,cos(x))

![x*y*y](http://api.annhe.net/gv/api.php?cht=gp\&chl=splot x*y*y)

![pm3d 图](http://api.annhe.net/gv/api.php?cht=gp\&chl=set pm3d%0aset isosamples 50,50%0asplot x**2+y**2)
