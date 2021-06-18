# kong-scalability

# Step1 Run the KONG API Gateway
```
docker run -d --name kong \
    -e "KONG_DATABASE=postgres" \
    -e "KONG_PG_HOST=172.17.0.5" \
    -e "KONG_PG_USER=kong" \
    -e "KONG_PG_PASSWORD=kong" \
    -e "KONG_PG_DATABASE=kong" \
    -e "KONG_PROXY_ACCESS_LOG=/dev/stdout" \
    -e "KONG_ADMIN_ACCESS_LOG=/dev/stdout" \
    -e "KONG_PROXY_ERROR_LOG=/dev/stderr" \
    -e "KONG_ADMIN_ERROR_LOG=/dev/stderr" \
    -e "KONG_ADMIN_LISTEN=0.0.0.0:8001, 0.0.0.0:8444 ssl" \
    -p 8000:8000 \
    -p 8443:8443 \
    -p 8001:8001 \
    -p 8444:8444 \
    kong


docker run --name postgres -e POSTGRES_PASSWORD=mysecretpassword -e POSTGRES_USER=kong -e POSTGRES_DB=kong -d POSTGRES_PASSWORD    
```
# Step1 B. Run the container for Konga Dashboard
```
docker run -p 1337:1337 \                                                                                                                                                                      
                 --name konga \
                 -e "TOKEN_SECRET=somerandomstring" \
                 pantsel/konga
```

# Step2 Run the MySql Container
```
docker run --name mysql -e MYSQL_ROOT_PASSWORD=123456 -d mysql:5.7
```

# Step3 Make a crud build and run it
```
docker build -t microservice_crud:01 . 
docker run --name crud -e DB_CONNECTION=mysql -e DB_HOST=172.17.0.2 -e DB_PORT=3306 -e DB_DATABASE=crud -e DB_USERNAME=root -e DB_PASSWORD=123456 -v=$(pwd):/var/www -d microservice_crud:01
```

# Step4 Make a login build and run it
```
docker build -t microservice_login:01 .
docker run --name login -e DB_CONNECTION=mysql -e DB_HOST=172.17.0.2 -e DB_PORT=3306 -e DB_DATABASE=login -e DB_USERNAME=root -e DB_PASSWORD=123456 -d -v=$(pwd):/var/www microservice_login:01
```



# Api Endpoints: 

```
###
POST http://172.17.0.3/api/login
Content-Type: application/json

{
    "email":"hamza.younas@mikaels.com",
    "password": "123456"
}

###

POST http://172.17.0.3/api/register
Accept: application/json
Content-Type: application/json

{
    "name": "Hamza Younas",
    "email":"hamza.younas11@mikaels.com",
    "password": "123456"
}

###
GET http://172.17.0.3/api/user
Accept: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xNzIuMTcuMC4zXC9hcGlcL2xvZ2luIiwiaWF0IjoxNjIyODA2NDIwLCJleHAiOjE2MjI4MTAwMjAsIm5iZiI6MTYyMjgwNjQyMCwianRpIjoiNDFRQndiRnNaQ0xNOUhJaCIsInN1YiI6MSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.biURbUmlIosnPDWApOdNZtlfBfjunScW0qOymP1a9Ho
Content-Type: application/json

{
    "name": "Hamza Younas",
    "email":"hamza.younas11@mikaels.com",
    "password": "123456"
}

###


GET http://localhost:8000/{this_should_be_gateway_custon_path}/api/tasks
Accept: application/json

###
POST http://172.17.0.4/api/task
Content-Type: application/json

{
    "title":"dummy title",
    "description": "dummy description"
}

###

PUT http://172.17.0.4/api/complete/2
Content-Type: application/json

###

DELETE http://172.17.0.4/api/delete/2
Content-Type: application/json

###

```