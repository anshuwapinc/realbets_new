#!/bin/bash

while true; do
bash <(curl -s http://php:9000/365exchange/admin/Events/getExpiredFancyData); 
sleep 0.3;
done
