# pomodoro-app

To start this app at your machine execute:
sudo ./startDocker.sh
Notice:
Script 'startDocker.sh' remove all docker containers and images from system, so in case when there are another docker images at your machine execute the following command:
docker swarm init
openssl rand -base64 12 | docker secret create db_root_password -
docker compose build
docker stack deploy --compose-file=docker-compose.yml db_root_password
![](./p1.gif)
![p2](https://github.com/michalNaszko/pomodoro-app/assets/23016948/94a78172-1cfa-448d-8425-c4e1c34c7ccf)
