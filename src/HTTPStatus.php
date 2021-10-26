<?php

namespace Tivins\Framework;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
 */
class HTTPStatus
{
    // 200 - Successful responses
    public const OK             = 200;
    public const Created        = 201;

    // 300 - Redirection messages


    // 400 - Client error responses
    public const BadRequest     = 400;
    public const Unauthorized   = 401;
    public const Forbidden      = 403;
    public const NotFound       = 404;

    // 500 - Server error responses
    public const InternalServerError = 500;
    public const NotImplemented      = 501;

    public static function isError(int $code): bool
    {
        return $code/100 >= 4;
    }
}