# pomodoro-app
## Functionalities 
* Measuring time of work, short and long break
* Notification when time expire
* Registration/Login
* Statistics in form of dashboard

## Link to app deployed at Heroku
https://pomodoro-app-5c54483095d7.herokuapp.com/

## Vizualization of working
![](./Pomodoro.gif)

## To start this app at your machine execute:
```
sudo ./startDocker.sh
```
**Notice:** <br />
Script 'startDocker.sh' remove all docker containers and images from system, so in case when there are another docker images at your machine execute the following command:
```
docker swarm init
openssl rand -base64 12 | docker secret create db_root_password -
docker compose build
docker stack deploy --compose-file=docker-compose.yml db_root_password
```
## Used technologies
* PHP - without any framework, goal of this project was to learn this language
* HTML
* Bootsrap
* MySQL
* JavaScript, jQuery - there is mix of this two, because at the beginning I wasn't conscious that something like jQuery exists
* Bash - to create script to start docker
* Docker
* Python - to generate data to db

