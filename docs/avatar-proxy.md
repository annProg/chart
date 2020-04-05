# avatar 代理

使用cdn时，配置到源站上

```
location ~ /uc_server/data/avatar/(\d\d\d)/(\d\d)/(\d\d)/(\d\d)_avatar_(.+?).jpg {
	root /discuz/uc_server;
	set $avatar1 $1;
	set $avatar2 $2;
	set $avatar3 $3;
	set $avatar4 $4;
	set $avatarsize $5;
	try_files $uri @avatar;
}

location @avatar {
	if ($avatarsize ~* "small") {
		proxy_pass http://127.0.0.1:8080/api.php?cht=avatar&chl=$avatar1.$avatar2.$avatar3.$avatar4&chs=48x48;
	}
	if ($avatarsize ~* "middle") {
		proxy_pass http://127.0.0.1:8080/api.php?cht=avatar&chl=$avatar1.$avatar2.$avatar3.$avatar4&chs=120x120;
	}
	if ($avatarsize ~* "big") {
		proxy_pass http://127.0.0.1:8080/api.php?cht=avatar&chl=$avatar1.$avatar2.$avatar3.$avatar4&chs=150x150;
	}
}

```

## discuz配置 sub_filter 替换 静态头像的请求为 CDN 请求

注意，sub_filter对gzip无效，需要修改 discuz 配置(实测直接用nginx的压缩就够了，速度差不多，压缩率也差不多，可以把 gzip_comp_level 设置大一些)

```
$_config['output']['gzip'] = '0';
```

然后配置nginx

```
# cdn 
sub_filter_types text/xml;
sub_filter_once off;
sub_filter 'https://www.discuz.com/uc_server/data/avatar/' 'https://attcdn.discuz.com/uc_server/data/avatar/';
```

类似的方法还可以将某些引入大 `js` 文件的插件放入cdn

```
sub_filter 'source/plugin/xxx' 'https://attcdn.discuz.com/source/plugin/xxx'
```
