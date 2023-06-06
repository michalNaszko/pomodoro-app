#!/bin/bash

rm -r /var/www/pomodoro-app/*

for i in `ls ..`
do
  if [ $i != "scripts" ]; then
    cp -R ../$i /var/www/pomodoro-app/
  fi 
done
