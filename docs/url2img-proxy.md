# url2img 代理

使用cdn时，配置到源站上

```
location ~ /url2img/(.*) {
	proxy_pass http://127.0.0.1:8080/api.php?cht=url2img&chl=$1&chs=400x300;
}
```
