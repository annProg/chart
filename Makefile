IMAGENAME ?= $(shell pwd |awk -F'/' '{print $$NF}')
REGISTRY ?= registry.cn-beijing.aliyuncs.com/kubebase
IMAGE = $(REGISTRY)/$(IMAGENAME)
TAG ?= latest
APP ?= chart
exists ?= $(shell docker ps -a |grep $(APP) &>/dev/null && echo "yes" || echo "no")
PORT ?= 8080
PWD =$(shell pwd)
APP_CONFIG_PATH ?= /run/secret/appconfig

all: build push

build:
	docker build -t $(IMAGE) .

push:
	docker push $(IMAGE)

run:
ifeq ($(exists), yes)
	docker stop $(APP);docker rm $(APP)
endif
	docker run --name $(APP) -d -p $(PORT):80 --env APP_CONFIG_PATH=$(APP_CONFIG_PATH) $(IMAGE):latest
