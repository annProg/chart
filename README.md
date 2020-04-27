# Text to Chart API
[![Build Status](https://ci.annhe.net/api/badges/annProg/chart/status.svg)](https://ci.annhe.net/annProg/chart)

This API is used to convert Graph Description Language (GDL) and simple text into images. Such as `dot`, `asymptote`, `ditaa`, `markdown-mindmap`, `identicon` etc.

![](static/text2img.png)

## Quick Start

- Web Editor Demo:  https://api.annhe.net/editor.php
- Call API use `GET` or `POST` with params:

| param | description |
| ---- | ---- |
| cht  | plot engine |
| chl  | plot text |
| chof | ouput format |

- Available engine (cht)

| cht | description | note | demo |
|----|----|--|--|
| gv:[dot\|neato\|fdp\|sfdp\|twopi\|circo] | graphviz| gv=gv:dot |[graphviz](docs/demo/graphviz.md) |
| gnuplot  | gnuplot ||[gnuplot](docs/demo/gnuplot.md)|
| ditaa | ditaa ||[ditaa](docs/demo/ditaa.md)|
| markdown:[dot\|neato\|fdp\|sfdp\|twopi\|circo] | markdown mindmap |markdown=markdown:dot|[mindmap](docs/demo/mindmap.md) |
| radar | radar chart ||[radar](docs/demo/radar.md) |
| msc | mscgen ||[mscgen](docs/demo/mscgen.md) |
| cover | book cover (racovimge) ||[book cover](docs/demo/bookcover.md) |
| cover:ten | book cover (tenprintcover.py) ||[book cover](docs/demo/bookcover.md) |
| qr | qrcode ||[qrcode](docs/demo/qrcode.md) |
| blockdiag | blockdiag ||[blockdiag](docs/demo/blockdiag.md) |
| asy |asymptote ||[asymptote](docs/demo/asymptote.md) |
| url2img | website screenshot ||[url2img](docs/demo/url2img.md) |
| avatar | identicon avatar||[avatar](docs/demo/avatar.md) |

## Deployment

- [Normal method](docs/deploy.md)
- [Docker](docs/docker.md)