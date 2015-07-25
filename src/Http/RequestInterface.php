<?php

namespace Aurora\Http;

interface RequestInterface
{
   public static function fromGlobals();
   public function getFile($key, $default = null);
   public function getCookie($key, $default = null);
   public function getCookies();
   public function getParameters();
   public function getParameter($where = Request::PARAMETERS, $key, $default = null);
   public function getFiles();
   public function getUri();
   public function getPath();
   public function getMethod();
   public function getHttpAccept();
   public function getReferer();
   public function getUserAgent();
   public function getIpAddress();
   public function isSecure();
   public function isAjax();
   public function isMethod($method = null);
   public function getQueryString();
   public function getBody();
   public function getParsedBody($key = null, $default = null);
   public function username();
   public function password();
   public function get($key, $default = null);
   public function blacklisted($where = Request::PARAMETERS, $backlist);
   public function whitelisted($where = Request::PARAMETERS, $whitelist);
}
