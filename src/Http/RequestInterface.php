<?php

/**
 * Aurora - Framework
 *
 * Aurora is fast, simple, extensible Framework
 *
 * @category   Framework
 * @package    Aurora
 * @author     VeeeneX <veeenex@gmail.com>
 * @copyright  2015 Caroon
 * @license    MIT
 * @version    0.1.2
 * @link       http://caroon.com/Aurora
 *
 */

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
   public function blacklisted($where = "parameters", $backlist);
   public function whitelisted($where = "parameters", $whitelist);
}
