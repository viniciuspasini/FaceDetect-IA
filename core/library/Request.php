<?php

namespace core\library;

class Request
{
    public function __construct(
        public readonly array $server,
        public readonly array $get,
        public readonly array $post,
        public readonly array $session,
        public readonly array $cookies,
        public readonly array $headers,
        public readonly array $files,
    )
    {
    }

    public static function create(): static
    {
        return new static($_SERVER, $_GET, $_POST, $_SESSION, $_COOKIE, getallheaders(), $_FILES);
    }
}