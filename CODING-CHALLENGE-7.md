# RESTful Webservices in Symfony

## Coding Challenge 7 - Validation

### Tasks

- introduce Symfony's Validator to validate the request content used to create and update workshops and attendees

### Solution

- require the Symfony Validator component: `composer require validator`
- add validation constraints to your model properties (e.g. NotBlank, Email)
- inject the `Validator` Service in your `ValueResolver`s
- for now throw an `UnprocessableEntityHttpException` on validation errors