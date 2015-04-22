# ReRouter

## Description
ReRoute is a router allowing you to tie different actions to corresponding URL's, it's built over and complements the fantastic FastRoute - a blazing fast router.
What differs ReRoute from others is the clean structure of your route definitions as well as some other features (see below).


Setting up ReRoute is a piece of cake, see docs below as well as the example application.

*Really early alpha - unstable, unsecure, just as the one you'd like to use, have fun!*


## Features

#### Route groups
+ Share settings across routes
+ Prefix patterns of routes in group

#### Route patterns
+ Readable route pattern arguments: `/user/{userId:numeric}/profile` or `/user/{username:alpha}`
+ `alpha` instead of `[a-zA-Z]+`.
+ `numeric` instead of `[0-9]+`.
+ `alphanumeric` instead of `[a-zA-Z0-9]+`.
+ `any` instead of `[a-zA-Z0-9$-_.+!*\'(),]+`.
+ Create and register your own pattern.

#### Named routes
+ Routes can be named, then matched.
+ URL can be built from a named route.

#### Middleware
+ Add optional middleware to any route or route group or the whole application.
+ Define as many types of middleware as you want and run it anywhere in your app by calling the middleware.

#### Filters


## Using ReRouter
See example.php

## Installation
