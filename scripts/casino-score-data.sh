#!/bin/bash
while true; do
bash <(curl -s http://php:9000/365exchange/admin/events/getScoreDataByEventId);
sleep 0.3;
done


