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

interface ResponseInterface
{
   public function setStatusCode($statusCode, $statusText = null);
   public function getStatusCode();
   public function addHeader($name, $value);
   public function setHeader($name, $value);
   public function getHeaders();
   public function addCookie(CookieInterface $Cookie);
   public function deleteCookie(CookieInterface $Cookie);
   public function setContent($content);
   public function getContent();
   public function redirect($url);
   public function send();
}
