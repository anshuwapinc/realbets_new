#!/bin/bash

while true; do
 bash <(curl -s http://php:9000/365exchange/casinoBetSettle/dt20);
 sleep 1;
done
