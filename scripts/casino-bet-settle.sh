#!/bin/bash

while true; do
 bash <(curl -s http://php:9000/365exchange/casinoBetSettle/t20);
 sleep 1;
done

