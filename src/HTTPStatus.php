<?php

namespace Tivins\Framework;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
 */
class HTTPStatus
{
    // 200 - Successful responses
    public const OK                          = 200;
    public const Created                     = 201;
    public const Accepted                    = 202;
    public const NonAuthoritativeInformation = 203;
    public const NoContent                   = 204;
    public const ResetContent                = 205;
    public const PartialContent              = 206;

    // 300 - Redirection messages
    public const MultipleChoices             = 300;
    public const MovedPermanently            = 301;
    public const Found                       = 302;
    public const SeeOther                    = 303;
    public const NotModified                 = 304;

    // 400 - Client error responses
    public const BadRequest                  = 400;
    public const Unauthorized                = 401;
    public const PaymentRequired             = 402;
    public const Forbidden                   = 403;
    public const NotFound                    = 404;
    public const MethodNotAllowed            = 405;
    public const NotAcceptable               = 406;
    public const Conflict                    = 409;

    // 500 - Server error responses
    public const InternalServerError         = 500;
    public const NotImplemented              = 501;
    public const ServiceUnavailable          = 503;

    public static function isError(int $code): bool
    {
        return $code/100 >= 4;
    }
}
/*
   100 Continue
   305 Use Proxy
   307 Temporary Redirect
   410 Gone
   411 Length Required
   412 Precondition Failed
   413 Request Entity Too Large
   414 Request-URI Too Long
   415 Unsupported Media Type
   416 Requested Range Not Satisfiable
   417 Expectation Failed
*/