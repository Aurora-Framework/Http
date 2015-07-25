<?php

namespace Aurora\Http;

class Response implements ResponseInterface
{
   private $version = '1.1';
   private $statusCode = 200;
   private $statusText = 'OK';
   private $headers = [];
   private $cookies = [];
   private $content;

   private $statusTexts = [
      100 => 'Continue',
      101 => 'Switching Protocols',
      102 => 'Processing',
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      203 => 'Non-Authoritative Information',
      204 => 'No Content',
      205 => 'Reset Content',
      206 => 'Partial Content',
      207 => 'Multi-Status',
      208 => 'Already Reported',
      226 => 'IM Used',
      300 => 'Multiple Choices',
      301 => 'Moved Permanently',
      302 => 'Found',
      303 => 'See Other',
      304 => 'Not Modified',
      305 => 'Use Proxy',
      306 => 'Reserved',
      307 => 'Temporary Redirect',
      308 => 'Permanent Redirect',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      406 => 'Not Acceptable',
      407 => 'Proxy Authentication Required',
      408 => 'Request Timeout',
      409 => 'Conflict',
      410 => 'Gone',
      411 => 'Length Required',
      412 => 'Precondition Failed',
      413 => 'Request Entity Too Large',
      414 => 'Request-URI Too Long',
      415 => 'Unsupported Media Type',
      416 => 'Requested Range Not Satisfiable',
      417 => 'Expectation Failed',
      418 => 'I\'m a teapot',
      422 => 'Unprocessable Entity',
      423 => 'Locked',
      424 => 'Failed Dependency',
      425 => 'Reserved for WebDAV advanced collections expired proposal',
      426 => 'Upgrade Required',
      428 => 'Precondition Required',
      429 => 'Too Many Requests',
      431 => 'Request Header Fields Too Large',
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      502 => 'Bad Gateway',
      503 => 'Service Unavailable',
      504 => 'Gateway Timeout',
      505 => 'HTTP Version Not Supported',
      506 => 'Variant Also Negotiates',
      507 => 'Insufficient Storage',
      508 => 'Loop Detected',
      510 => 'Not Extended',
      511 => 'Network Authentication Required',
   ];

   public function setStatusCode($statusCode, $statusText = null)
   {
      if ($statusText === null
         && isset($this->statusTexts[(int) $statusCode])
      ) {
         $statusText = $this->statusTexts[(int) $statusCode];
      }

      $this->statusCode = (int) $statusCode;
      $this->statusText = (string) $statusText;

      return $this;
   }

   public function getStatusCode()
   {
      return $this->statusCode;
   }

   public function getStatusMessage($statusCode = null)
   {
      if ($statusCode !== null) {
         return $this->statusTexts[(int) $statusCode];
      }

      return $this->statusTexts[$this->statusCode];
   }

   public function addHeader($name, $value)
   {
      $this->headers[$name][] = (string) $value;

      return $this;
   }

   public function setHeader($name, $value)
   {
      $this->headers[$name] = [
         (string) $value,
      ];

      return $this;
   }

   public function getHeaders()
   {
      $headers = array_merge(
         $this->getRequestLineHeaders(),
         $this->getStandardHeaders()
      );

      return $headers;
   }

   public function addCookie(CookieInterface $Cookie)
   {
      $this->cookies[$Cookie->getName()] = $Cookie;
   }

   public function deleteCookie(CookieInterface $Cookie)
   {
      $Cookie->setValue('');
      $Cookie->setMaxAge(-1);
      $this->cookies[$Cookie->getName()] = $Cookie;

      return $this;
   }

   public function setContent($content)
   {
      $this->content = (string) $content;

      return $this;
   }

   public function getContent()
   {
      return $this->content;
   }

   public function redirect($url, $statusCode = 301, $continue = false)
   {
      $this->setHeader('Location', $url);
      $this->setStatusCode($statusCode);

      if (!$continue) $this->send();

      return $this;
   }

   private function getRequestLineHeaders()
   {
      $headers = [];

      $requestLine = sprintf(
         'HTTP/%s %s %s',
         $this->version,
         $this->statusCode,
         $this->statusText
      );

      $headers[] = trim($requestLine);

      return $headers;
   }

   private function getStandardHeaders()
   {
      $headers = [];

      foreach ($this->headers as $name => $values) {
         foreach ($values as $value) {
            $headers[] = "${name}: ${value}";
         }
      }

      return $headers;
   }


   public function send()
   {
      foreach ($this->cookies as $Cookie) {
         setcookie(
            $Cookie->name,
            $Cookie->getValue(),
            $Cookie->expire,
            $Cookie->path,
            $Cookie->domain,
            $Cookie->secure,
            $Cookie->httpOnly
         );
      }
      foreach ($this->getHeaders() as $header) {
         header($header, false);
      }

      echo $this->getContent();
   }
}
