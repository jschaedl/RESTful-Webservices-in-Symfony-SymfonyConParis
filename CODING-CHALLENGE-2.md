# RESTful Webservices in Symfony

## Coding Challenge 2 - Serialization

### Tasks

- use Symfony's Serializer to transform the workshop and attendee entities into a JSON representation
- use `make tests` to check if the api endpoints still work as expected
- make sure that all JSON property names are formatted in _snake_case_
- add an attendee to one of the workshops and use the PostMan collection to test the endpoints

### Solution

- require the Symfony Serializer component: `composer req serializer`
- inject the Serializer into your controllers
- serialize your entities
- create a custom `Normalizer` (implement `ContextAwareNormalizerInterface`) for your Workshop and Attendee entities
- remove the `toArray` method in your entities
- fix the `CircularReferenceException`

#### Problem 1: No snake_case property names anymore

```yaml
# config/packages/framework.yaml

framework:
    # ...
    serializer:
        name_converter: 'serializer.name_converter.camel_case_to_snake_case'
```

#### Problem 2: Fixing the `CircularReferenceException`

Adding an attendee to a workshop and accessing this attendee, or the respective workshop results in a `CircularReferenceException`.

```php
// AttendeeNormalizer

$defaultContext = [
    AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn ($object, $format, $context) => $object->getFirstname().' '.$object->getLastname(),
];
```

```php
// WorkshopNormalizer

$customContext = [
    AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn ($object, $format, $context) =>  $object->getTitle(),
];
```
