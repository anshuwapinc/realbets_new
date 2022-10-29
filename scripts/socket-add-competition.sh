#!/bin/bash

while true; do
bash <(curl -s http://node:3000/addCompetition);
sleep 0.3;
done
