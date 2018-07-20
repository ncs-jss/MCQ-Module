# MCQ Module

This is the MCQ Module create by NCS for conducting various quiz type events that are held in the college.

# Getting Started

### Server Requirements
-   PHP >= 5.6.4
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Mbstring PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension

### Installing

Clone this repo or download it on your local system.

Rename the file `.env.example` to `.env`.

```shell
cp .env.example .env
```

Generate the Application key

```php
php artisan key:generate
```

Migrate the database.

```php
php artisan migrate
```

Seed the database

```php
php artisan db:seed
```

Set db credentials and InfoConnect API URL in `.env` and run the project.

### Local Development Server

To run this project on localhost

```php
php artisan serve
```

This project will by default run on this server:

```
http://localhost:8000/
```

For more details
```php
php artisan serve --help
```

## Terminology
### User Type
|Value|Represent|
|--|--|
|0|Student|
|1|Society|
|2|Teacher, HOD and Adminitration|
### Question Type
|Value|Represent|
|--|--|
|0|Single correct (Radio button will be shown to choose option)|
|1|One or more correct (Checkbox will be shown to choose option)|
### Request Status
|Value|Represent|
|--|--|
|0|Pending for approval|
|1|Approved|
|2|completed the event|
### Event Play
|Value|Represent|
|--|--|
|0|Not visited, nor answered|
|1|Visited but not answered|
|2|Visited and answered|


## Controller
|Controller|Use|
|--|--|
|AjaxController|Handeling AJAX request and responding in JSON|
|EventController|Creating, editing and deleting event,its questions and options. Approving user request to join the event|
|EventPlayController|Requesting to join event and playing it|
|InfoConnectApiController|Using InfoConnect API to validate user credentials|
|ProfileController|For student to update details|
|ResultController|To display the result of an event|

## License

This project is licensed under the MIT License - see the  [LICENSE.md](https://github.com/ncs-jss/Proj_mx02/LICENSE.md)  file for details
