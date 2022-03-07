# Concrete CMS Package: Macareux Security Header Extended

Add security header to mitigate some types of attacks.
If you consider to mitigate `CVE-2021-22954` without editing server configuration, you can use this add-on.

## Supported Headers

* `Cross-Origin-Resource-Policy` (CORP) 

## Headers supported by core

* `X-Frame-Options`
* `Strict-Transport-Security` (HSTS) (v9+)
* `Content Security Policy` (CSP) (v9+)

## Todo

* `X-XSS-Protection`
* `X-Content-Type-Options`
* `Access-Control-Allow-Origin`
* `Cross-Origin-Opener-Policy` (COOP)
* `Cross-Origin-Embedder-Policy` (COEP)
