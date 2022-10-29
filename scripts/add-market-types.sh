#!/bin/bash

while true; do
bash <(curl -s http://php:9000/365exchange/admin/Events/addMarketTypes); 
sleep  300;
done
