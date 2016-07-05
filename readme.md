# bookshop
bookshop REST API example

## Requirements
* PHP 5.5+

## installation

```
$ git clone https://github.com/JaroslavKrenar/bookshop.git
$ php composer.phar install
```

## Configuration

You can configure database connection in ```config/database.php``` and create tables with the following command:

```
$ php artisan migrate
```

## Usage

```
$ php -S localhost:8000 server.php
```

## Test suite

The test suite is run via phpunit. 

To run the unit tests: `phpunit`

## API

Please specify `"accept"` header field to decide what type of content should be response.

Supported headers:

`"application/json"` - JSON request and response

### GET /api/v1/search

##### Parameters

| Name  | Type | Description |
| ------------- | ------------- | -------------|
| isbn  | string | ISBN |
| author | string | Author name |
| title | string  | Book title |
| release_date | string  | Release data. You can use ```"|"``` to find between dates, e.g. ```2015-01-01|2016-01-01```  |
| minimum_rating | float  | Search by minimum rating |

#### Example

```
$ http://localhost:8000/api/v1/search?release_date=2005-07-04
```
##### Response

```
Status: 200 OK

{
  "count": 1,
  "books": [
    {
      "ID": 2,
      "isbn": "9784115709669",
      "author": "Velda Keeling Jr.",
      "title": "Hatter. 'Nor I,' said the Mock Turtle Soup is.",
      "rating": "9.99",
      "release_date": "2005-07-04",
      "created_at": "2016-07-04 10:01:59",
      "updated_at": "2016-07-04 10:01:59"
    }
  ]
}
```

### POST /api/v1/add-book

##### Parameters

| Name  | Type | Description |
| ------------- | ------------- | -------------|
| isbn  | string | ISBN |
| author | string | Author name |
| title | string  | Book title |
| rating | float  | Book rating  |
| release_date | string  | Release data in format ```Y-m-d``` |

#### Example

Request
```
$ http://localhost:8000/api/v1/add-book

{
  'isbn' => "9780833052643"
  'author' => "Pascale Lesch"
  'title' => "WILL do next! If they had to fall a long way. So."
  'rating' => 3.44
  'release_date' => "2016-01-23"
}
```
##### Response

```
Status: 200 OK

{
  "id": 1000
}
```
##### Error response

```
Status: 500 Internal Server Error

{
  "message": "Invalid input data",
  "code": 500,
  "type": "ValidationException",
  "data": {
    "isbn": [
      "The isbn field is required."
    ],
    "author": [
      "The author field is required."
    ],
    "title": [
      "The title field is required."
    ],
    "rating": [
      "The rating field is required."
    ],
    "release_date": [
      "The release date field is required."
    ]
  }
}
```
