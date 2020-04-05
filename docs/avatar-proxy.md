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
		proxy_pass http://127.0.0.1:8080/api.php?cht=avatar&chl=$1$2$3$4small&chs=48x48;
	}
	if ($avatarsize ~* "middle") {
		proxy_pass http://127.0.0.1:8080/api.php?cht=avatar&chl=$1$2$3$4small&chs=120x120;
	}
	if ($avatarsize ~* "big") {
		proxy_pass http://127.0.0.1:8080/api.php?cht=avatar&chl=$1$2$3$4small&chs=150x150;
	}
}
```

