#!/bin/bash

echo mmc0 | sudo tee /sys/class/leds/led0/trigger
echo input | sudo tee /sys/class/leds/led1/trigger