Address Book 
=============

![Build Status](https://github.com/samapraku/symfony-address-book/workflows/.github/workflows/php.yml/badge.svg)
[![Symfony 3.4](https://img.shields.io/badge/Symfony%203.4-Symfony-blue)](https://symfony.com/doc/current/index.html)
[![Twig](https://img.shields.io/badge/Twig%20v2-Twig-green)](https://twig.symfony.com/)
[![Doctrine](https://img.shields.io/badge/Doctrine-Doctrine-lightgrey)](https://www.doctrine-project.org/index.html)

This project is an Address book application written with Symfony Framework (3.4). 

# [📖 Docs]

- [[📖 Docs]](#-docs)
  - [Features](#features)
  - [Quick Start](#quick-start)
  - [Api Documentation](#api-documentation)
    - [List Addresses](#list-addresses)
    - [Get Address](#get-address)
    - [Add Address](#add-address)
    - [Delete Address](#delete-address)
- [Dependencies](#dependencie)    
- [Screenshots](#screenshots)

## Features
  - Add address
  - Update Address
  - Delete Address
  - Upload optional picture
  - API Endpoint

## Quick Start

Get up and running with the following.

### Clone from Github

```bash
git clone https://github.com/samapraku/symfony-address-book.git address_book

# Change to project directory
cd address_book

```

### Install composer packages

```bash
composer install
```

### Run tests
```bash
./bin/phpunit
```

### Start Symfony development server to run application
#This starts the web server at http://localhost:8000
```bash
php bin/console server:run

```

## Dependencies
- Symfony 3.4 Framework
- Twig Templating Engine
- Doctrine
- PHPUnit

## Api Docucmentation
----

### List Addresses
----
  Returns List of json data for all addresses.

* **URL**

  /api/addresses

* **Method:**

  `GET`
  
*  **URL Params**: none


* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```json 
    [{"id":3,"first_name":"John","last_name":"Doe","phone_number":"+44245076408","city":"Doe City","zip":"0000","street_name":"Doe Street","street_number":"24","birthday":{"date":"1990-01-01 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"country":"GB"}]
    ```

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/addresses",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
### Get Address
----
  Returns json data about a single address.

* **URL**

  /api/addresses/:id

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
    ```json
    {"id":3,"first_name":"John","last_name":"Doe","phone_number":"+44245076408","city":"Doe City","zip":"0000","street_name":"Doe Street","street_number":"24","birthday":{"date":"1990-01-01 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"country":"GB"}
    ```
 
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** `{ error : "Address not found" }`


* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/addresses/3",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
### Add Address
----
  Add new address.

* **URL**

  /api/address

* **Method:**

  `POST`
  
*  **URL Params**: none

* **Data Params**

  **Required:**
  
  'request body[json]'
  
  **Fields**  
  `firstName[string]`<br />
  `lastName[string]`<br />
  `streetName[string]`<br />
  `streetNumber[string]`<br />
  `zip[string]`<br />
  `city[string]`<br />
  `phoneNumber[string]`<br />
  `country[string]`<br /><br />
  `emailAddress[string]`<br />
  `birthDay[string("yyyy-mm-dd")]`<br />
  

* **Success Response:**

  * **Code:** 201 <br />
    **Content:** `Address added successfully`
 
* **Error Response:**

  * **Code:** 422  <br />
    **Content:** `Data not valid`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/address",
      type : "POST",
      data : jsonData,
      success : function(r) {
        console.log(r);
      }
    });
  ```
### Delete Address
----
  Delete address

* **URL**

  /api/addresses/:id

* **Method:**

  `DELETE`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `Address deleted successfully`
 
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** `{ error : "Address not found" }`


* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/addresses/3",
      type : "DELETE",
      success : function(r) {
        console.log(r);
      }
    });
  ```
### Update Address
----
  Update existing address.

* **URL**

  /api/address/:id

* **Method:**

  `PUT`
  
*  **URL Params**: none

* **Data Params**

  **Required:**
  
  'request body[json]'
  
  **Fields**  
  `firstName[string]`<br />
  `lastName[string]`<br />
  `streetName[string]`<br />
  `streetNumber[string]`<br />
  `zip[string]`<br />
  `city[string]`<br />
  `phoneNumber[string]`<br />
  `country[string]`<br /><br />
  `emailAddress[string]`<br />
  `birthDay[string("yyyy-mm-dd")]`<br />
  

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `Address added successfully`
 
* **Error Response:**

* **Code:** 404 NOT FOUND  <br />
    **Content:** `Address not found`
    
    OR
    
  * **Code:** 422  <br />
    **Content:** `Data not valid`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/address/3",
      type : "PUT",
      data : jsonData,
      success : function(r) {
        console.log(r);
      }
    });
  ```
  
  
# Screenshots
![Image](screenshots/1.jpg?raw=true "1")
