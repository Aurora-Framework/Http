<?php

namespace Aurora\Http;

class Cookie implements CookieInterface
{
   public $name;
   public $value;
   public $domain;
   public $path;
   public $expire;
   public $secure;
   public $httpOnly;

   public function __construct($domain = null, $path = "/", $expire = 0, $secure = false, $httpOnly = true)
   {
      $this->domain = (string) $domain;
      $this->path = (string) $path;
      $this->expire = (int) $expire;
      $this->secure = (bool) $secure;
      $this->httpOnly = (bool) $httpOnly;
   }

   public function setName($name = "")
   {
      $this->name = (string) $name;

      return $this;
   }

   public function setValue($value = null)
   {
      if ($this->raw) {
         $this->value = $value;
      } else {
         $this->value = serialize($$value);
      }

      return $this;
   }

   public function getValue()
   {
      if ($this->raw) {
         return $this->value;
      } else {
         return unserialize($this->value);
      }
   }

   /**
    * Returns the cookie name.
    *
    * @return string
    */
   public function getName()
   {
      return $this->name;
   }

   /**
    * Sets the cookie max age in seconds.
    *
    * @param  integer $seconds
    * @return void
    */
   public function setMaxAge($seconds)
   {
      $this->maxAge = (int) $seconds;

      return $this;
   }

   /**
    * Sets the cookie domain.
    *
    * @param  string $domain
    * @return void
    */
   public function setDomain($domain)
   {
      $this->domain = (string) $domain;

      return $this;
   }

   /**
    * Sets the cookie path.
    *
    * @param  string $path
    * @return void
    */
   public function setPath($path)
   {
      $this->path = (string) $path;

      return $this;
   }

   /**
    * Sets the cookie secure flag.
    *
    * @param  boolean $secure
    * @return void
    */
   public function setSecure($secure)
   {
      $this->secure = (bool) $secure;

      return $this;
   }

   /**
    * Sets the cookie httpOnly flag.
    *
    * @param  boolean $httpOnly
    * @return void
    */
   public function setHttpOnly($httpOnly)
   {
      $this->httpOnly = (bool) $httpOnly;

      return $this;
   }
}
