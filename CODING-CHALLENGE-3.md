# RESTful Webservices in Symfony

## Coding Challenge 3 - Pagination

### Tasks

- add pagination to your workshop and attendee list actions using a `page` and `size` query parameter

### Solution

- introduce query params `page` and `size` in your ListControllers
- use the Doctrine Paginator to paginate the workshop and attendee lists
- implement a `PaginatedCollection` object and add the properties `items`, `total` and `count`
- implement a `PaginatedCollectionFactory` to encapsulate your pagination logic
