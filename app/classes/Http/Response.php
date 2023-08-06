<?php

namespace App\Http;

class Response
{
    public function setStatusCode($code)
    {
        http_response_code($code);
    }

    public function send($body)
    {
        echo $body;
    }

    public function json($data)
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->send(json_encode($data));
    }

    public function setHeader($name, $value)
    {
        header("$name: $value");
    }
}
