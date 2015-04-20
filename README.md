# ReRouter
Routing and middleware built on FastRoute

Really early alpha - unstable, unsecure, just as the one you'd like to use, have fun!



## Features

#### Route groups
+ Share common middleware across multiple routes.
+ Prefix the pattern for multiple routes, such as `/admin` or `/api` or anything else.

#### Route patterns
+ Readable route pattern arguments: `/user/{userId:numeric}/profile` or `/user/{username:alpha}`
+ `alpha` instead of `[a-zA-Z]+`.
+ `numeric` instead of `[0-9]+`.
+ `alphanumeric` instead of `[a-zA-Z0-9]+`.
+ `any` instead of `[a-zA-Z0-9$-_.+!*\'(),]+`.
+ Create your own pattern.

#### Named routes
+ Routes can be named, then matched.
+ URL can be built from a named route.

#### Middleware
+ Add optional middleware to any route or route group or the whole application.
+ Define as many types of middleware as you want and run it anywhere in your app by calling the middleware.
