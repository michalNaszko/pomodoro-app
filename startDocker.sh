#!/bin/bash

docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
docker rmi $(docker images -q)
docker swarm init
openssl rand -base64 12 | docker secret create db_root_password -
docker compose build
docker stack deploy --compose-file=docker-compose.yml db_root_password