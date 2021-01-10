
<p align="center">
  <img width="500" height="150" src="documentation/logo.png">
</p>
<br/>

# Motivation   
Challenge proposed by Invillia
<br/>

# Installation (via docker)

- first of all build and start container   
```sh
$ docker-compose up -d
```

- then run migration   
```sh
docker-compose exec app-php php artisan migrate
```
<br/>

# Tests
Run tests using
```sh
docker-compose exec app-php php artisan test --env=testing
```
<br/>

# API documentation

http://localhost:8001/api/documentation
<br/>

# Decisions

- I kept the .env files in github repo just to  make run easy, even it's not a good practice  
- considering that it could be a large volume of data I opted to index some fields of the bank
- xml data could be processed async or sync