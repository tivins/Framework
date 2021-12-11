<?php

namespace Tivins\Framework;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
 */
enum HTTPStatus: int
{
    // 200 - Successful responses
    case OK = 200;
    case Created = 201;
    case Accepted = 202;
    case NonAuthoritativeInformation = 203;
    case NoContent = 204;
    case ResetContent = 205;
    case PartialContent = 206;

    // 300 - Redirection messages
    case MultipleChoices = 300;
    case MovedPermanently = 301;
    case Found = 302;
    case SeeOther = 303;
    case NotModified = 304;

    // 400 - Client error responses
    case BadRequest = 400;
    case Unauthorized = 401;
    case PaymentRequired = 402;
    case Forbidden = 403;
    case NotFound = 404;
    case MethodNotAllowed = 405;
    case NotAcceptable = 406;
    case Conflict = 409;

    // 500 - Server error responses
    case InternalServerError = 500;
    case NotImplemented = 501;
    case ServiceUnavailable = 503;

    public function toInteger(): int
    {
        return $this->value;
    }

    public function isError(): bool
    {
        return $this->toInteger() / 100 >= 4;
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