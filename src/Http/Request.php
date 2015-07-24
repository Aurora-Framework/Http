<?php

namespace Aurora\Http;

class Request implements RequestInterface
{
   protected $parameters;
   protected $server;
   protected $files;
   protected $cookies;
   protected $body;
   protected $parsedBody;
   protected $get;
   protected $post;

   const GET = "get";
   const POST = "post";
   const PARAMETERS = "parameters";

   const PUT = "post";
   const OPTIONS = "post";
   const DELETE = "post";
   const PATCH = "post";

   public function __construct(
      array $get,
      array $post,
      array $cookies,
      array $files,
      array $server
   ) {
      $this->parameters = array_merge($get, $post);
      $this->cookies = $cookies;
      $this->files = $files;
      $this->server = $server;
      $this->get = $get;
      $this->post = $post;
   }

   public static function fromGlobals()
   {
      return new self($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
   }

   public function getFile($key, $default = null)
   {
      return (isset($this->files[$key])) ? $this->files[$key] : $default;
   }

   public function getCookie($key, $default = null)
   {
      return (isset($this->cookies[$key])) ? $this->cookies[$key] : $default;
   }

   public function getCookies()
   {
      return $this->cookies;
   }

   public function getParameters()
   {
      return $this->parameters;
   }

   public function getParameter($where = Request::PARAMETERS, $key, $default = null)
   {
      $tmp = $this->$where;
      return (isset($tmp[$key])) ? $tmp[$key] : $default;
   }

   public function getFiles()
   {
      return $this->files;
   }

   public function getUri()
   {
      return $this->server('REQUEST_URI');
   }

   public function getPath()
   {
      return strtok($this->server('REQUEST_URI'), '?');
   }

   public function getMethod()
   {
      return $this->server('REQUEST_METHOD');
   }

   public function getHttpAccept()
   {
      return $this->server('HTTP_ACCEPT');
   }

   public function getReferer()
   {
      return $this->server('HTTP_REFERER');
   }

   public function getUserAgent()
   {
      return $this->server('HTTP_USER_AGENT');
   }

   public function getIpAddress()
   {
      return $this->server('REMOTE_ADDR');
   }

   public function isSecure()
   {
      return (isset($this->server["HTTPS"]) && $this->server["HTTPS"] !== "off") ? false : true;
   }

   public function isAjax()
   {
      return (isset($this->server["HTTP_X_REQUESTED_WITH"]) && $this->server["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") ? true : false;
   }

   public function isMethod($method = "POST")
   {
      return ($this->server('REQUEST_METHOD') === $method);
   }

   public function isPost()
   {
      return $this->server('REQUEST_METHOD') === "POST";
   }

   public function isGet()
   {
      return $this->server('REQUEST_METHOD') === "GET";
   }

   public function getQueryString()
   {
      return $this->server('QUERY_STRING');
   }

   public function getBody()
   {
      if ($this->body === null) {
         $this->body = file_get_contents('php://input');
      }

      return $this->body;
   }

  public function getParsedBody($key = null, $default = null)
  {
      if (!isset($this->parsedBody) && $this->isPost()) {
        $parsedBody = array();
        switch($this->server('CONTENT-TYPE')) {
            case 'application/x-www-form-urlencoded':
               parse_str($this->getBody(), $parsedBody);
            break;
            case 'text/json':
            case 'application/json':
            case 'application/x-json':
               $parsedBody = json_decode($this->getBody(), true);
            break;
         }
         $this->parsedBody = $parsedBody;
      }

      return ($key === null) ? $this->parsedBody : (isset($this->parsedBody[$key]) ? $this->parsedBody[$key] : $default);
   }

   public function username()
   {
      return $this->server('PHP_AUTH_USER');
   }

   public function password()
   {
      return $this->server('PHP_AUTH_PW');
   }

   public function get($key, $default = null)
   {
      return (isset($this->get[$key])) ? $this->get[$key] : $default;
   }

   public function post($key, $default = null)
   {
      return (isset($this->post[$key])) ? $this->post[$key] : $default;
   }

   public function put($key, $default = null)
   {
      return (isset($this->post[$key])) ? $this->post[$key] : $default;
   }

   public function patch($key, $default = null)
   {
      return (isset($this->post[$key])) ? $this->post[$key] : $default;
   }

   public function delete($key, $default = null)
   {
      return (isset($this->post[$key])) ? $this->post[$key] : $default;
   }

   public function options($key, $default = null)
   {
      return (isset($this->post[$key])) ? $this->post[$key] : $default;
   }

   public function server($key, $default = null)
   {
      return (isset($this->server[$key])) ? $this->server[$key] : $default;
   }

   public function blacklisted($where = Request::PARAMETERS, $backlist)
   {
      return array_intersect_key($this->$where, array_flip((array) $blacklist));
   }

   public function whitelisted($where = Request::PARAMETERS, $whitelist)
   {
      return array_diff($this->$where, (array) $whitelist);
   }

}
