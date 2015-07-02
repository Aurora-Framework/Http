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

class CookieBuilder
{
   private $defaultDomain;
   private $defaultPath = '/';
   private $defaultSecure = true;
   private $defaultHttpOnly = true;

   public function setDefaultDomain($domain)
   {
      $this->defaultDomain = (string) $domain;
   }

   public function setDefaultPath($path)
   {
      $this->defaultPath = (string) $path;
   }

   public function setDefaultSecure($secure)
   {
      $this->defaultSecure = (bool) $secure;
   }

   public function setDefaultHttpOnly($httpOnly)
   {
      $this->defaultHttpOnly = (bool) $httpOnly;
   }

   public function build($name, $value)
   {
      $Cookie = new Cookie($name, $value);
      $Cookie->setPath($this->defaultPath);
      $Cookie->setSecure($this->defaultSecure);
      $Cookie->setHttpOnly($this->defaultHttpOnly);

      if ($this->defaultDomain !== null) {
         $Cookie->setDomain($this->defaultDomain);
      }

      return $Cookie;
   }
}
