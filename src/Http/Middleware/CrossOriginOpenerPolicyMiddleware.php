<?php

namespace Macareux\SecurityHeaderExtended\Http\Middleware;

use Concrete\Core\Http\Middleware\DelegateInterface;
use Concrete\Core\Http\Middleware\MiddlewareInterface;
use Concrete\Core\Utility\Service\Validation\Strings;
use Symfony\Component\HttpFoundation\Request;

class CrossOriginOpenerPolicyMiddleware implements MiddlewareInterface
{
    /**
     * @var Strings
     */
    private $stringValidator;

    private $config;

    public function __construct(Strings $stringValidator, string $config)
    {
        $this->stringValidator = $stringValidator;
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

        if ($response->headers->has('Cross-Origin-Opener-Policy') === false) {
            if ($this->stringValidator->notempty($this->config)) {
                $response->headers->set('Cross-Origin-Opener-Policy', $this->config);
            }
        }

        return $response;
    }
}
