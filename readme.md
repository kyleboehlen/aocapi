# Advent of Code - API

## Installation
Before installing the site the following tools need to be installed:
- php7.2 or higher with the extensions
- apache2
- git
- composer (added to the PATH)

<br/>
Start by cloning into the repository

`git clone https://github.com/kyleboehlen/aocapi.git`

<br/>
cd into the project directory

`cd aocapi`

<br/>
Install the required depdendencies

`composer install`

<br/>
Create a copy of the enviroment file from the template

`cp .env.example .env`

<br/>
Generate a 32 char key and set the APP_KEY in .env

<br/>
Point the ssl apache2 config entry to the public folder
- Change to the apache2 root directory

   `cd /etc/apache2/sites-available`
- Open the configuation file

   `sudo nano 000-default-le-ssl.conf`
- Edit the aocapi entry:

   `DocumentRoot /var/www/html/aocapi/public`
- Restart apache2

   `sudo service apache2 restart`

<br/>
In order to allow laravel to handle URLs, make sure the apache mod_rewrite extension is enabled and allow overrides
- Edit apache2.conf to allow overrides

   `cd etc/apache2/`

   `sudo nano apache2.conf`
- Add the following to the directory settings

```
   <Directory /var/www/html/aocapi/public>

      Options Indexes FollowSymLinks

      AllowOverride All

      Require all granted

   </Directory>
```

- Enable mod_rewrite extension

   `sudo a2enmod rewrite`
- Restart apache2

   `sudo service apache2 restart`

<br/>
Allow apache to serve the files

`sudo chown -R www-data:{your_user_group} aocapi`

<br/>
Install the node dependancies

`npm install`

<br/>

## Usage
The API only accepts POST requests to https://www.aocapi.com/api/v1/{year}/{day}/{part} and takes the param 'input'.

<br/>

## To-Do
- auth0
- request limiting