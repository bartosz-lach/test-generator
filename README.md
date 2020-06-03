# Test Generator
Test Generator powered by Laravel and Vue.js (SPA)
## Table of contents
* [Features](#Features)
* [Technologies](#technologies)
* [Setup](#setup)
* [Screenshots](#Screenshots)
## Features:
* Creating and managing tests.
* Creating test groups
* Generating tests as PDF with randomize questions and answers.
## Technologies
Project is created with:
* Lavarel: 5.8
* MariaDB: 10.4
* Vue.js: 2.5.17
* Vuetify: 2.1.13
## Setup
* Clone project
* Go to the folder application using cd command on your cmd or terminal
* Run ```composer install``` on your cmd or terminal
* Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu
* Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
By default, the username is root and you can leave the password field empty. (This is for Xampp)
By default, the username is root and password is also root. (This is for Lamp)
* Run ```npm install```
* Run ```npm run dev```
* Run ```php artisan key:generate```
* Run ```php artisan migrate```
* Run ```php artisan serve```
* Go to localhost:8000

## Screenshots
#### Create test
[![add-question-and-answer.png](https://i.postimg.cc/4yR5HHRT/add-question-and-answer.png)](https://postimg.cc/dkndz10W)
#### Tests list
[![test-list.png](https://i.postimg.cc/yYBjVRTm/test-list.png)](https://postimg.cc/XXHdLpmq)

#### Test version list
[![test-version-list.png](https://i.postimg.cc/KvNN4Y9d/test-version-list.png)](https://postimg.cc/8j7W0TgH)

#### Generated test as PDF
[![test-sheet.png](https://i.postimg.cc/pLLBjt4y/test-sheet.png)](https://postimg.cc/zV4Wm4J1)

#### Generated answers sheet as PDF
[![questions-sheet.png](https://i.postimg.cc/mZ7Vfj7Z/questions-sheet.png)](https://postimg.cc/RqVwwcP2)

#### Generated sheet to check answers as PDF
[![check-sheet.png](https://i.postimg.cc/br0RxYqS/check-sheet.png)](https://postimg.cc/RJFf9B6v)
