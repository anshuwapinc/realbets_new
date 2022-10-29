#!/bin/bash

while true; do
 bash <(curl -s http://php:9000/365exchange/casinoBetSettle/ltp);
 sleep 1;
done
