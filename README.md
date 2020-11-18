Address Book 
=============

![Build Status](https://github.com/samapraku/symfony-address-book/workflows/.github/workflows/php.yml/badge.svg)
[![Symfony 3.4](https://img.shields.io/badge/Symfony%203.4-Symfony-blue)](https://symfony.com/doc/current/index.html)
[![Twig](https://img.shields.io/badge/Twig%20v2-Twig-green)](https://twig.symfony.com/)
[![Doctrine](https://img.shields.io/badge/Doctrine-Doctrine-lightgrey)](https://www.doctrine-project.org/index.html)

This project is an Address book application written with Symfony Framework (3.4). 

# [📖 Docs]

- [[📖 Docs]](#-docs)
  - [Quick Start](#quick-start)
- [Dependencies](#dependencie)
- [Api Documentation](#api-documentation)  
- [Screenshots](#screenshots)

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
- By default, the web server listens on port 8000 on the loopback device. 
 You can change the socket by passing an IP address and a port as a command-line argument:
```bash
php bin/console server:start 192.168.0.1:8080

```

# Dependencies
- Symfony 3.4 Framework
- Twig Templating Engine
- Doctrine
- PHPUnit

# Api Docucmentation
----

**List Addresses**
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
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
**Get Address**
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
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
**Add Address**
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
      dataType: "json",
      type : "POST",
      data : jsonData,
      success : function(r) {
        console.log(r);
      }
    });
  ```
# Screenshots
![Image](screenshots/1.jpg?raw=true "1")
