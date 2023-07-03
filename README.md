# pomodoro-app

To start this app at your machine execute:
sudo ./startDocker.sh
Notice:
Script 'startDocker.sh' remove all docker containers and images from system, so in case when there are another docker images at your machine execute the following command:
docker swarm init
openssl rand -base64 12 | docker secret create db_root_password -
docker compose build
docker stack deploy --compose-file=docker-compose.yml db_root_password
![Presentation]./pomodoro.mp4
