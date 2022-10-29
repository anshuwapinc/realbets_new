#!/bin/bash

while true; do
 bash <(curl -s http://php:9000/365exchange/admin/events/addCasinoEvents/32c);
 sleep 0.3;
done
