# 使用容器部署

```
make
make run
```

## 可用环境变量

```
DISABLED  指定禁用的cht，逗号分隔
```

## 获取正确scheme

容器前有nginx时，须配置

```
proxy_set_header X-Forwarded-Proto $scheme;
```
