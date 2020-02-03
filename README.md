# Wild Circus

This is a little project in Symfony 4.4 to create in 2 days, for pass the last checkpoint in my coding school


## Wireframe

<p align="center">
  <img src="https://i.postimg.cc/QN47qCKk/wireframe.png" alt="Wireframe">
</p>

## CMD

<p align="center">
  <img src="https://i.postimg.cc/9QYwrYTb/CMD.png" alt="CMD">
</p>

## User story

- Create a counter service for in cart and paid tickets
- Write fixtures to insert demo data and users with different roles to project
- Add flash messages for added in cart and paid tickets
- Create uploader service for images

## Installation  

1. Clone project  

`git clone https://github.com/magomeddeniev/WildCircus.git`  

2. Install composer dependencies  
  
`composer install`  

3. Configure .env.local file and create database

`php bin/console doctrine:database:create`  

`php bin/console doctrine:schema:update --force`  

`php bin/console doctrine:fixtures:load` 

4. Start server  

`symfony server:start`

## Roles

Through fixtures i created two users with different roles, for log in with this users enter the following data.

### 1) Admin rights

**Username:** admin  
**Password:** admin

### 2) User rights

**Username:** yavuz  
**Password:** yavuz
