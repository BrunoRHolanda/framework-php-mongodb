<?php

namespace App\Kernel\Http;

class Response 
{
    private $body;

    private $statusCode;

    private $headers;
    
    public function __construct($body = null, int $statusCode = 200, array $headers = [])
    {
        $this->body = $body;

        $this->statusCode = $statusCode;

        $this->headers = $headers;
    }

    public function send(array $headers = [])
    {
        $this->handleHeaders(array_merge($this->headers, $headers));

        echo $this->body;
    }

    public static function json ($body, $statusCode = 200): Response
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];

       if ($body === null && $statusCode != 404)
       {
            return new Response(json_encode($body), 404, $headers);
       }
       else
       {
            return new Response(json_encode($body), $statusCode, $headers);
       }
    }

    public static function renderPDF($body) 
    {

    }

    private function handleHeaders(array $headers)
    {
        foreach ($headers as $header => $value)
        {
            header($header . ': ' . $value);
        }

        header(null, false, $this->statusCode);
    }
}