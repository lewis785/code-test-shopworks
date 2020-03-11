# code-test-shopworks

### Setup

##### Start Docker Containers
This project is built using docker. To start the developer environment run:
```
docker-compose up -d
```

##### Initial Setup
Requires starting, stopping, and starting the containers again. This is due to vendor files being downloaded the first time.


##### Run Test
To run test from outside the container just run:
```shell script
docker-compose exec rota-service vendor/bin/codecept run
```

### Usage

##### UI
A basic user interface exists to allow the creation of entities, to access it navigate to: http://localhost:81

##### Endpoints
* `/rota/{rotaId}/singlemannedtime` - Returns a json object containing the single manned minutes for a specific rota 
