Address Book 
=============

![Build Status](https://github.com/samapraku/symfony-address-book/workflows/.github/workflows/php.yml/badge.svg)
[![Symfony 3.4](https://img.shields.io/badge/Symfony%203.4-Symfony-blue)](https://symfony.com/doc/current/index.html)
[![Twig](https://img.shields.io/badge/Twig%20v2-Twig-green)](https://twig.symfony.com/)
[![Doctrine](https://img.shields.io/badge/Doctrine-Doctrine-lightgrey)](https://www.doctrine-project.org/index.html)

This project is an Address book application written with Symfony Framework (3.4). 

# [📖 Docs]

- [[📖 Docs]](#-docs)
  - [Quick Start](#quick-start)
- [Technology](#technology)
- [Dependencies](#dependencies)
- [Screenshots](#screenshots)

## Quick Start

Get up and running with the following.

- Clone from Github

```bash
git clone https://github.com/samapraku/symfony-address-book.git address_book

cd address_book

# Install composer packages
composer install

# Run tests

./bin/phpunit

# Start Symfony development server to run application
#This starts the web server at localhost:8000

php bin/console server:start

# By default, the web server listens on port 8000 on the loopback device. 
# You can change the socket by passing an IP address and a port as a command-line argument:

php bin/console server:start 192.168.0.1:8080

# To stop the web server, run

php bin/console server:stop

```

# Dependencies
- Symfony 3.4 Framework
- Twig Templating Engine
- Doctrine
- PHPUnit

# Screenshots
![Image](screenshots/1.jpg?raw=true "1")
