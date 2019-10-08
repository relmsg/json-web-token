# Json Web Token
This library implements some standards and is used by others Relations Messenger libraries and services like `relmsg/php-sdk` or API server.

## Installation
You will need Composer to install. Run this command:

`composer require relmsg/json-web-token`

## Implementation
This library implements only **the necessary minimum** for the correct operation of the service platform.

### Implemented
* JSON Web Token ([RFC 7519](https://tools.ietf.org/html/rfc7519))
* JSON Web Signature ([RFC 7515](https://tools.ietf.org/html/rfc7515))
* JSON Web Key ([RFC 7517](https://tools.ietf.org/html/rfc7517))
* JSON Web Algorithm ([RFC 7518](https://tools.ietf.org/html/rfc7518))

### Will not implemented
* Nested JSON Web Token
* Multiple signatures for JWS and JWE
* JWS JSON Serialization ([RFC 7515](https://tools.ietf.org/html/rfc7515), section 7.2)
* JWE JSON Serialization ([RFC 7516](https://tools.ietf.org/html/rfc7516), section 7.2)

### Will not be fixed
* You cannot use same claims in header and payload at the same time.