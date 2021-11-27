# RESTful Webservices in Symfony

## Coding Challenge 6 - POST vs. PUT

### Tasks

- implement controllers to create and update attendees and workshops
- both should be possible with JSON and XML

### Solution

- use an `ArgumentValueResolver` to deserialize the request's content
- use the `EntityManager` to save the object into the database
- *CREATE:* use HTTP method `POST`, return an HTTP 201 (Created) status code and
  set the `Location` header with the help of the `UrlGenerator`
- *UPDATE:* use HTTP method `PUT`, return an HTTP 204 (No Content) status code and leave the response body empty
