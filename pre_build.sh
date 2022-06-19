#!/usr/bin/env bash

if [ -f ".env" ]; then
    cp .env .env.example
    sed -i '3d' .env.example
    sed -i "s@\=.*@\=@" .env.example
fi

## 校验 composer.json 
composer validate --strict

## 修复错误
vendor/bin/phpstan analyse src tests

## 修正语法
vendor/bin/php-cs-fixer fix --verbose