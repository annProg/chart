# gnuplot

```
plot sin(x)*x;
```

![](https://api.annhe.net/api.php?cht=gnuplot&chl=plot+sin%28x%29%2Ax%3B)

## 基本信息

| -- | -- |
| 代码 | <https://github.com/annProg/chart> |
| 功能 | 接受 gnuplot 命令，返回图片 |

## 参数说明

| -- | -- |
| cht=gnuplot | gnuplot 使用 gnuplot（[graphviz 使用 gv](https://www.annhe.net/article-3196.html)） |
| chl=<gnuplot command> | gnuplot 命令（目前只支持 png 格式，即 set term gif 等无效）|

## 演示
![](https://api.annhe.net/api.php?cht=gnuplot\&chl=plot x)
![sin(x)](https://api.annhe.net/api.php?cht=gnuplot\&chl=plot sin\(x\))

![sin(x)*tan(x)](https://api.annhe.net/api.php?cht=gnuplot\&chl=plot sin\(x\)*tan\(x\))

![多个函数](https://api.annhe.net/api.php?cht=gnuplot&chl=plot%20sin(x)%20title%20%27sin%27,tan(x)%20title%20%27tan%27,cos(x))

![x*y*y](https://api.annhe.net/api.php?cht=gnuplot\&chl=splot x*y*y)

![pm3d 图](https://api.annhe.net/api.php?cht=gnuplot\&chl=set pm3d%0aset isosamples 50,50%0asplot x**2+y**2)
