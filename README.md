
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

- run composer   
```sh
docker-compose exec app-php composer install
```

- then run migration   
```sh
$ docker-compose exec app-php php artisan migrate --seed
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

# API use
* DEFAUL LOGIN/PASSWORD is 
  {
	  "email":"admin@admin.com",
	  "password": "12345678"
  }

* insomnia file should be find in "documentation" folder, to make easier the use of api
* first certify that you already load some xml file
* use login route to get your token, passing email and password (could use the default one)
* now make your request using your token on token field
{
"token":"<your token here>"
}

<br/>
# Decisions

* I kept the .env files in github repo just to  make run easy, even it's not a good practice   
* considering the challenge description address table was not created because person file don't provide these data, also "ship to" is one to one, the use  of this data was not clear   
* considering the challenge description I kept the id to database because it's not clear if files come from different systems   
* considering that it could be a large volume of data I opted to index some fields of the bank   
* xml data could be processed async or sync   
* if data upload with already exist id with different data, it will be updated   