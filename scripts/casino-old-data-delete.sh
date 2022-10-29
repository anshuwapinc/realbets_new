#!/bin/bash

while true; do
 bash <(curl -s http://php:9000/365exchange/admin/deleteOldCasinoData);
 sleep 5;
done

