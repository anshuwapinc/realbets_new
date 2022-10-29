#!/bin/bash

while true; do
 bash <(curl -s http://node:3000/send-casino-response);
 sleep 0.3;
done
