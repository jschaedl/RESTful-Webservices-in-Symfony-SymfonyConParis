# RESTful Webservices in Symfony

## Coding Challenge 5 - Content Negotiation

### Tasks

- set the correct format option (JSON or XML) of the current Request
- read the `Accept` request header and negotiate the content-type using Will Durand's negotiation library

### Solution

- require the willdurand/negotiation library: `composer require willdurand/negotiation`
- create a `ContentNegotiator` class, use the `RequestStack` and implement a method to retrieve
  the negotiated request format (`json` should be the default request format)
- create a `RequestFormatListener`, subscribe on the `kernel.request` event (priority: 8) and
  use the `ContentNegotiator` to set the request's request format
- adjust all your Controllers, Normalizers and Data Transfer Objects to provide your representation of
  your resources in the format accepted by the client

#### Hints

You can get the best fitting format by using:

```
$negotiator = new Negotiator();
$acceptHeader = $negotiator->getBest($request->getAcceptableContentTypes(), self::ACCEPTED_CONTENT_TYPES);
```
