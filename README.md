# pomodoro-app

Ubuntu server configuration steps:
1. Create file pomodoro-app.conf in the following directory: /etc/apache2/sites-available/
2. Put in this file the following contents:
    <VirtualHost *:80>

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/pomodoro-app
            ServerName pomodoro
        ServerAlias www.pomodoro

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        SetEnv mysql.default.user "your MySql user name"             <-- You need to configure it!!!
        SetEnv mysql.default.password "your MySql password"          <-- You need to configure it!!!
        SetEnv mysql.default.servername "name of your host with db"  <-- You need to configure it!!!
        SetEnv mysql.default.db "db name"                            <-- You need to configure it!!!

    </VirtualHost>
