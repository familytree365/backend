## Family Tree 365 - Open Source Family Tree Software - Laravel 8 Backend API
 ![Latest Stable Version](https://img.shields.io/github/release/familytree365/backend.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/familytree365/backend/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/familytree365/backend/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/familytree365/backend/badges/build.png?b=master)](https://scrutinizer-ci.com/g/familytree365/backend/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/familytree365/backend/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![StyleCI](https://github.styleci.io/repos/316440677/shield?branch=master)](https://github.styleci.io/repos/316440677)
[![CodeFactor](https://www.codefactor.io/repository/github/familytree365/backend/badge/master)](https://www.codefactor.io/repository/github/familytree365/backend/overview/master)
[![codebeat badge](https://codebeat.co/badges/911f9e33-212a-4dfa-a860-751cdbbacff7)](https://codebeat.co/projects/github-com-modulargenealogy-genealogy-master)
[![Build Status](https://travis-ci.org/familytree365/backend.svg?branch=master)](https://travis-ci.org/familytree365/backend)
[![CircleCI](https://circleci.com/gh/familytree365/backend.svg?style=svg)](https://circleci.com/gh/familytree365/backend)

## Build Setup

Run following commands
```bash
# install dependencies
$ composer install
$ cp .env.testing .env
```

Set the database information in .env [DB_DATABASE, DB_USERNAME, DB_PASSWORD], then run following commands

```bash
$ php artisan key:generate
$ php artisan migrate --path=database/migrations/landlord --database=landlord
$ php artisan db:seed

# serve with hot reload at localhost:8000
$ php artisan serve
```

## Broadcasting Setup

```bash
# install dependencies
$ npm install -g laravel-echo-server

$ laravel-echo-server configure
$ nano .env

  BROADCAST_DRIVER=redis
  REDIS_PREFIX=

$ laravel-echo-server start
```

If you want to keep it in background proccess you should install pm2 or supervisor

## Description

Browser based genealogy software for interacting and processing data efficiently. Easily create your
own family tree by importing your existing data or manual data entry. Storage of all data is securely on your own server and does
not leave your environment without your permission. In the future there will be optional
smart matching with other servers. This is the Laravel 8 backend, see the frontend repository for the Nuxt / Vue client side support.

## Demo

https://www.familytree365.com - register a free account


<!--h-->

### Thanks

Built with Laravel 8

Special thanks to [Taylor Otwell](https://laravel.com/), [Jeffrey Way](https://laracasts.com)

### Contributions

are welcome. Pull requests are great, but issues are good too.

## Contributors

This project exists thanks to all the people who contribute.
<a href="graphs/contributors"><img src="https://opencollective.com/genealogy/contributors.svg?width=890&button=false" /></a>


## Backers

Thank you to all our backers! 🙏 [[Become a backer](https://opencollective.com/genealogy#backer)]

<a href="https://opencollective.com/genealogy#backers" target="_blank"><img src="https://opencollective.com/genealogy/backers.svg?width=890"></a>


## Sponsors

Support this project by becoming a sponsor. Your logo will show up here with a link to your website. [[Become a sponsor](https://opencollective.com/genealogy#sponsor)]
