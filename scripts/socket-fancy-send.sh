#!/bin/bash
while true; do
bash <(curl -s http://node:3000/getMarketBookOddsFancy);
sleep 0.3;
done


