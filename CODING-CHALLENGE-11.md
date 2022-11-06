# RESTful Webservices in Symfony

## Coding Challenge 11 - API Documentation

### Tasks

Let's document our API using the Nelmio ApiDocBundle.

### Solution

- require Nelmio's ApiDocBundle: `composer req nelmio/api-doc-bundle`
- adjust the bundle's configuration:

```yaml
nelmio_api_doc:
    documentation:
        info:
            title: RESTful Webservices in Symfony
            description: "Workshop: RESTful Webservices in Symfony!"
            version: 1.0.0
    areas:
        path_patterns:
            - ^/api(?!/doc$) # Accepts routes under /api except /api/doc
            - ^/workshops
            - ^/attendees
```

- add some annotation to your controllers, check https://github.com/zircote/swagger-php/tree/master/Examples for examples
- to be able to see the api documentation website, you need to install Twig and the Asset component `composer require twig asset`
- and adjust the routing configuration for the `nelmio/api-doc-bundle` in `config/routes/nelmio_api_doc.yaml`
