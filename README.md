# OMED Project

[![Build Status](https://travis-ci.org/kilip/omed.svg?branch=master)](https://travis-ci.org/kilip/omed)
[![codecov](https://codecov.io/gh/kilip/omed/branch/master/graph/badge.svg)](https://codecov.io/gh/kilip/omed)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a4b2450d-0fce-427a-a7c0-ab451c5a8f93/mini.png)](https://insight.sensiolabs.com/projects/a4b2450d-0fce-427a-a7c0-ab451c5a8f93)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kilip/omed/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kilip/omed/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/5a93c7d60fb24f11ef24fbbb/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/5a93c7d60fb24f11ef24fbbb)

OMED project is my project that contains a latest technology available
in web development.

### Technology Stack
#### Backend
- Symfony 4 Framework
- api-platform
- phpspec
- Behat
- Docker
#### Frontend
- React
- Vue (Not implemented yet)
- AngularJS (Not implemented yet)


Installation
====
```bash

$ cd path/to/omed
$ composer install
$ yarn install

```

Docker and Debugging
====
Copy `docker/php/99-custom.ini.dist` to `99-custom.ini`, and edit to match your local environment.
By default `xdebug` is disabled, in order to enable `xdebug` you need to define in `99-custom.ini`:

```ini

; path/to/omed/docker/php/99-custom.ini
; xdebug configuration
zend_extension=xdebug.so
xdebug.remote_host=172.20.0.1
xdebug.remote_autostart=1

```

Start development server by starting a docker: 

```bash

# or if you have docker
$ cd path/to/omed
$ docker-compose up

```

Frontend Development
====
If you working on a frontend, you can watch file changes by using this command: 

```bash

$ cd path/to/omed
$ yarn watch

```
