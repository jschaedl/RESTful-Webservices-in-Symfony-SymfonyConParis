# RESTful Webservices in Symfony

## Coding Challenge 10 - JSON WEB TOKEN

### Tasks

Let's set up the Authentication/Authorization for our API based on JSON Web Token

1. Implement a Token provider

- configure the security system for basic auth
- add a TokenController to retrieve a token

2. Implement an Authenticator

- implement a JwtGuardAuthenticator

3. Secure your Controllers to meet the requirements described in README.md

- use the `#[IsGranted]` attribute
- or alternatively add `access_control` entries

### Solution

#### Preparation

- require Symfony's SecurityBundle: `composer req security`
- require LexikJWTAuthenticationBundle: `composer req lexik/jwt-authentication-bundle`
- run `php bin/console lexik:jwt:generate-keypair`

#### GuardAuthenticator

- adjust firewall configuration (firewall for token: `http_basic`, firewall for api: `custom_authenticators`)
- implement a `TokenController`, secure it with http_basic and return a JWT token
- implement a `JwtTokenAuthenticator` extending the `AbstractAuthenticator`
- configure the `JwtTokenAuthenticator` on the api firewall (`custom_authenticators` option)
- add `#[IsGranted]` attributes to your controller actions
- add an Authorization header to your Postman endpoints

#### Make things shiny

- use the serializer to create a nice error response in the `JwtTokenAuthenticator::start()` method
- implement the `JwtTokenAuthenticator::onAuthenticationFailure()` and use the serializer to return an
  HTTP 401 Unauthorized Response with a nice error message
