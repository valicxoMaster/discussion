
# Comment system

The demo presents simple functionalities of a work with comments.

## Prerequisites

1. You need to have **docker** and **docker-compose** installed to run this application in the develop mode.

### Installation

1. Create a `./app/.env` from the `./app/.env.dist` file. Adapt it according to your  application

    1.1 run command:
    ```bash
    cp ./app/.env.dist ./app/.env
    ```
   1.2. set environments in the .env file
      
   1.3 _Note_ You can also skip the `-f docker-compose.yml` parameter if you run the command from inside the project root where that config file resides
   
2. Build and run containers (we need this only by first application start)

    ```bash
    docker-compose -f docker-compose.yml up -d --build
    ```
3. if you doesn't need a building of image,  you can run containers without the image build

    ```bash
    docker-compose -f docker-compose.yml up -d
    ```
4. if you don't have the folder app/vendor after start then pleas launch the following command
    ```bash
    docker-compose exec -T comments-demo-php-fpm composer install
    ```    
5. Database installation 

   The database of the application can be created with sql files in the folder app/database
   
6. Enjoy :-)

### Other

Stop and remove containers

```bash
docker-compose -f docker-compose.yml down
```

Start and create containers

```bash
docker-compose -f docker-compose.yml up -d
```

### Life cycle of the application

After launch docker project we must have three docker container:
1.  cd-php-fpm
2. cd-nginx
3. cmts-demo-mysql

The application is running on web  server nginx under the address http://localhost:80. Please see docker-compose and app/.env file for current configuration.

The code of the application locates in the folder "app". For other web server, the applicaten need MODE REWRITE and enabled global variables like $_SERVER and $_ENV.

The database is empty, but one record in the table articles must be existed with id = 1. The application doesn't have article functionality yet. All comments can be created only for dummy article wit id =1.



### Unit tests

Demo projects doesn't have tests.
