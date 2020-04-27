IMAGENAME ?= $(shell pwd |awk -F'/' '{print $$NF}')
REGISTRY ?= ann17
IMAGE = $(REGISTRY)/$(IMAGENAME)
TAG ?= latest
APP ?= chart
exists ?= $(shell docker ps -a |grep $(APP) &>/dev/null && echo "yes" || echo "no")
PORT ?= 8080
PWD =$(shell pwd)
APP_CONFIG_PATH ?= /run/secret/appconfig
CDN ?=
DISABLED ?=
BAIDU ?=

all: build push

build:
	docker build -t $(IMAGE):$(TAG) .
push:
	checktag $(TAG)
	docker tag $(IMAGE):$(TAG) $(IMAGE):latest
	docker push $(IMAGE):$(TAG)
	docker push $(IMAGE):latest
build-gv:
	docker build -t $(IMAGE)-gv:$(TAG) -f Dockerfile.graphviz .
push-gv:
	checktag $(TAG)
	docker tag $(IMAGE)-gv:$(TAG) $(IMAGE)-gv:latest
	docker push $(IMAGE)-gv:$(TAG)
	docker push $(IMAGE)-gv:latest

run:
ifeq ($(exists), yes)
	docker stop $(APP);docker rm $(APP)
endif
	docker run --name $(APP) -d -e "BAIDU=$(BAIDU)" -e "DISABLED=$(DISABLED)" -e "CDN=$(CDN)" -p $(PORT):80 --env APP_CONFIG_PATH=$(APP_CONFIG_PATH) -v $(PWD)/config.php:$(APP_CONFIG_PATH)/CONFIG -v $(PWD)/cache:/home/wwwroot/default/cache --restart=always $(IMAGE):$(TAG)

