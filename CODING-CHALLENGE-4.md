# RESTful Webservices in Symfony

## Coding Challenge 4 - HATEOAS

### Tasks

- introduce HATEOAS links for your read and list representations of workshops and attendees
- use the JSON-HAL format

### Solution

- add a `links` property to the `PaginatedCollection` class (annotate the getter with `#[SerializedName('_links')]`)
- add `UrlGeneratorInterface` as dependency of `PaginatedCollectionFactory`
- introduce a `addLink(string $rel, string $href)` method in the `PaginatedCollection` class
- add links to the created `PaginatedCollection` (self, next, prev, first, last)
- adjust the AttendeeNormalizer and WorkshopNormalizer and add
- `$data['_links']['self']['href']` (remember to check for is_array($data))
- `$data['_links']['collection']['href']` (remember to check for is_array($data))
