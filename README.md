# Ideasoft - RESTful API

The purpose of this project, creating a RESTful API service for orders where adding / deleting / listing operations can be performed.

### How to run project with Docker

After cloning the project, you should open a terminal in the project folder and run the following commands one by one.

To run Docker:

```
./vendor/bin/sail up --build
```

To migrate database tables with seeds:

```
./vendor/bin/sail artisan migrate:fresh --seed --seeder=AdminSeeder
```

## About API

### api/login

You must log in to access other functions of the service using Bearer Token. You should use the token value you receive from here to access other functions.

Request Type: POST
Body fields with x-www-form-urlcoded format:

    "username":"hakan.syturk@gmail.com",
    "password":"12345"




### api/logout

It is used to terminate the user's session.

Request Type: POST
Bearer token required (You can get it using login (from response body)).
Body fields with x-www-form-urlcoded format:

    "username":"hakan.syturk@gmail.com",
    "password":"12345"



## api/getProducts

It is used to list all products.

Request Type: GET
Bearer token required (You can get it using login (from response body)).

## api/getCustomers

It is used to list all customers.

Request Type: GET
Bearer token required (You can get it using login (from response body)).

## api/getOrders

It is used to list all orders.

Request Type: GET
Bearer token required (You can get it using login (from response body)).

## api/getDiscount/{orderId}

Request Type: GET
Bearer token required (You can get it using login (from response body)).

Returns discount values for the order number entered in the orderId field.

## api/createOrder

It is used to create an order based on the entered customerId, productId and quantity values.

Request Type: POST
Bearer token required (You can get it using login (from response body)).
Body fields with x-www-form-urlcoded format:

    "customerId": "1",
    "productId": "2",
    "quantity": "10"

## api/deleteOrder/{orderId}

It is used to delete the order whose orderId is entered.

Request Type: DELETE
Bearer token required (You can get it using login (from response body)).

