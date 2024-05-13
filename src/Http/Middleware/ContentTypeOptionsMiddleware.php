<?php

namespace Macareux\SecurityHeaderExtended\Http\Middleware;

use Concrete\Core\Http\Middleware\DelegateInterface;
use Concrete\Core\Http\Middleware\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;

class ContentTypeOptionsMiddleware implements MiddlewareInterface
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
    /**
     * Process the request and return a response
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param DelegateInterface $frame
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function process(Request $request, DelegateInterface $frame)
    {
        $response = $frame->next($request);

        if ($response->headers->has('X-Content-Type-Options') === false) {
            if ($this->config === true) {
                $response->headers->set('X-Content-Type-Options', 'nosniff');
            }
        }

        return $response;
    }
}
