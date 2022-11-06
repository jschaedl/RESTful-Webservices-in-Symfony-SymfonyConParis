# Workshop RESTful Webservices in Symfony

Trainer: [Jan Schädlich](http://janschaedlich.de)

> Nowadays RESTful APIs are powering the web and are used in almost every web application.
> In this workshop you will learn the fundamental principles of REST and how you can implement a RESTful application using Symfony.
>
> We will start with the basics of REST and will cover some more advanced topics like Serialization, Content-Negotiation, Security afterwards.
> Besides all the theory you can deepen your learnings on every topic while doing the provided coding challenges.
>
> In addition to an IDE (or text editor) you need a current version of PHP, Composer and the Symfony CLI.

The code provided within this repository is not production-ready. It was created for studying and learning purposes.

(c) Jan Schädlich All rights reserved.

## Installation

    # checkout the project
    $ git clone git@github.com:jschaedl/RESTful-Webservices-in-Symfony-....git

    # initialize dev environment
    $ make dev-init
    
    # start webserver
    $ symfony serve -d

## Tools

- Symfony Binary: https://symfony.com/download
- Postman App: https://www.getpostman.com/downloads

## Coding Challenge

For a 2-day conference, workshops and participants must be recorded.
Each workshop last one day.
All workshops have a participation limit of 25 people.
Each attendee can only take part in one workshop per day.

We are going to build an API that can be used to organize workshops.
Our API should offer the following basic features:

- List all workshops
- Read a single workshop
- Create a workshop
- Update a workshop
- Delete a workshop
- List all attendees
- Read a single attendee
- Create an attendee
- Update an attendee
- Delete an attendee
- Add an attendee to a workshop
- Remove an attendee from a workshop
- The listing of workshops and attendees should support pagination
- The API should support JSON and XML

We also want to limit access to our API as follows:

- Listing of all workshops is allowed for everyone
- Reading a single workshop is only allowed for logged-in users with the `ROLE_USER` role
- Creating and updating a workshop is only allowed for logged-in users with the `ROLE_USER` role
- Deleting a workshop is only allowed for logged-in users with the `ROLE_ADMIN` role
- Listing of all attendees is allowed for everyone
- Reading a single attendee is only allowed for logged-in users with the `ROLE_USER` role
- Creating and updating a attendee is only allowed for logged-in users with the `ROLE_USER` role
- Deleting an attendee is only allowed for logged-in users with the `ROLE_ADMIN` role
- Adding/removing an attendee to/from a workshop is only allowed for logged-in users with the `ROLE_USER` role

## Endpoints

### Workshop

| HTTP Method | Endpoint                                              |
|-------------|-------------------------------------------------------|
| GET         | /workshops                                            |
| POST        | /workshops                                            |
| GET         | /workshops/{workshopId}                               |
| PUT         | /workshops/{workshopId}                               |
| DELETE      | /workshops/{workshopId}                               |
| POST        | /workshops/{workshopId}/attendees/{attendeeId}/add    |
| POST        | /workshops/{workshopId}/attendees/{attendeeId}/remove |

### Attendee

| HTTP Method | Endpoint                |
|-------------|-------------------------|
| GET         | /attendees              |
| POST        | /attendees              |
| GET         | /attendees/{attendeeId} |
| PUT         | /attendees/{attendeeId} |
| DELETE      | /attendees/{attendeeId} |

## Testing

We will add functional tests using a snapshot testing approach to make sure that our endpoints are working correctly.

    # run the test suite
    $ make tests
