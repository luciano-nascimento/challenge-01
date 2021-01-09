
<p align="center">
  <img width="500" height="150" src="logo.png">
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

- considering that the requirements did not say whether the files would be inserted in a specific order, I chose not to create relationship to the shiporder and people tables   
- considering that there could be a large volume of data I opted to index some fields of the bank