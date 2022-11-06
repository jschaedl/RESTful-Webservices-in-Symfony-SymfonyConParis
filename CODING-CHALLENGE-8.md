# RESTful Webservices in Symfony

## Coding Challenge 8 - Error Handling

### Tasks

- centralize the error handling

### Solution

- throw a `ValidationFailedException` on validation errors
- introduce an `ExceptionListener` to catch the `ValidationFailedException`
- in the `ExceptionListener` create an error representation of the caught exception and fill the response content with it
