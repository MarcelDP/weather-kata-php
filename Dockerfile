FROM php:7.1.33-apache-stretch

RUN apt-get update && apt-get install make

COPY . .
