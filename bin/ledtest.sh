#!/bin/bash


echo none | sudo tee /sys/class/leds/led0/trigger
echo gpio | sudo tee /sys/class/leds/led1/trigger

echo 1 | sudo tee /sys/class/leds/led0/brightness
echo 1 | sudo tee /sys/class/leds/led1/brightness
