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

`APP_KEY=`

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

## Usage
The API only accepts POST requests to https://www.aocapi.com/api/v1/{year}/{day}/{part} and takes the param 'input'.

<br/>

## Contribution
To add to the API add a function to the Functions.php file for the year/day that accepts `$input` and `$part`. Base the function name off the AoC title. Please comment your function with `// {year}-{day}`.

<br/>
Then map the function response in the AocController using the switch statement based on year/day.

<br/>
Update completed functions below

### Functions:

- 2015
  - [ ] Day 1
  - [ ] Day 2
  - [ ] Day 3
  - [ ] Day 4
  - [ ] Day 5
  - [ ] Day 6
  - [ ] Day 7
  - [ ] Day 8
  - [ ] Day 9
  - [ ] Day 10
  - [ ] Day 11
  - [ ] Day 12
  - [ ] Day 13
  - [ ] Day 14
  - [ ] Day 15
  - [ ] Day 16
  - [ ] Day 17
  - [ ] Day 18
  - [ ] Day 19
  - [ ] Day 20
  - [ ] Day 21
  - [ ] Day 22
  - [ ] Day 23
  - [ ] Day 24
  - [ ] Day 25
- 2016
  - [ ] Day 1
  - [ ] Day 2
  - [ ] Day 3
  - [ ] Day 4
  - [ ] Day 5
  - [ ] Day 6
  - [ ] Day 7
  - [ ] Day 8
  - [ ] Day 9
  - [ ] Day 10
  - [ ] Day 11
  - [ ] Day 12
  - [ ] Day 13
  - [ ] Day 14
  - [ ] Day 15
  - [ ] Day 16
  - [ ] Day 17
  - [ ] Day 18
  - [ ] Day 19
  - [ ] Day 20
  - [ ] Day 21
  - [ ] Day 22
  - [ ] Day 23
  - [ ] Day 24
  - [ ] Day 25
- 2017
  - [x] Day 1
  - [x] Day 2
  - [x] Day 3
  - [ ] Day 4
  - [x] Day 5
  - [ ] Day 6
  - [ ] Day 7
  - [ ] Day 8
  - [ ] Day 9
  - [ ] Day 10
  - [ ] Day 11
  - [ ] Day 12
  - [ ] Day 13
  - [ ] Day 14
  - [ ] Day 15
  - [ ] Day 16
  - [ ] Day 17
  - [ ] Day 18
  - [ ] Day 19
  - [ ] Day 20
  - [ ] Day 21
  - [ ] Day 22
  - [ ] Day 23
  - [ ] Day 24
  - [ ] Day 25
- 2018
  - [x] Day 1
  - [ ] Day 2
  - [ ] Day 3
  - [ ] Day 4
  - [ ] Day 5
  - [ ] Day 6
  - [ ] Day 7
  - [ ] Day 8
  - [ ] Day 9
  - [ ] Day 10
  - [ ] Day 11
  - [ ] Day 12
  - [ ] Day 13
  - [ ] Day 14
  - [ ] Day 15
  - [ ] Day 16
  - [ ] Day 17
  - [ ] Day 18
  - [ ] Day 19
  - [ ] Day 20
  - [ ] Day 21
  - [ ] Day 22
  - [ ] Day 23
  - [ ] Day 24
  - [ ] Day 25
- 2019
  - [x] Day 1
  - [x] Day 2
  - [x] Day 3
  - [x] Day 4
  - [x] Day 5
  - [ ] Day 6
  - [ ] Day 7
  - [ ] Day 8
  - [ ] Day 9
  - [ ] Day 10
  - [ ] Day 11
  - [ ] Day 12
  - [ ] Day 13
  - [ ] Day 14
  - [ ] Day 15
  - [ ] Day 16
  - [ ] Day 17
  - [ ] Day 18
  - [ ] Day 19
  - [ ] Day 20
  - [ ] Day 21
  - [ ] Day 22
  - [ ] Day 23
  - [ ] Day 24
  - [ ] Day 25

<br/>

## To-Do
- auth0