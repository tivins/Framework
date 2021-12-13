<?php

namespace Tivins\Framework;

enum HTTPMethod: string
{
    case GET    = 'GET';
    case POST   = 'POST';
    case DELETE = 'DELETE';
    case PUT    = 'PUT';

    public function toString(): string {
        return $this->value;
    }
}