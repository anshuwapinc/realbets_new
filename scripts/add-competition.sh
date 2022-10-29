#!/bin/bash

while true; do
 bash <(curl -s http://php:9000/365exchange/admin/Events/addCompetition);
 sleep 120;
done
