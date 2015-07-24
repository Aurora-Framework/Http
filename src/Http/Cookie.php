<?php

namespace Aurora\Http;

class Cookie implements CookieInterface
{
   private $name;
   private $value;
   private $domain;
   private $path;
   private $maxAge;
   private $secure;
   private $httpOnly;

   public function __construct($domain = null, $path = "/", $maxAge = 0, $secure = false, $httpOnly = true)
   {
      $this->domain = (string) $domain;
      $this->path = (string) $path;
      $this->maxAge = $maxAge;
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
      if (is_array($value) || is_object($value)) {
         $this->value = serialize($value);
      } else {
         $this->value = $value;
      }

      return $this;
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

   /**
    * Returns the cookie HTTP header string.
    *
    * @return string
    */
   public function getHeaderString()
   {
      $parts = [
         $this->name . '=' . rawurlencode($this->value),
         $this->getMaxAgeString(),
         $this->getExpiresString(),
         $this->getDomainString(),
         $this->getPathString(),
         $this->getSecureString(),
         $this->getHttpOnlyString(),
      ];

      $filteredParts = array_filter($parts);

      return implode('; ', $filteredParts);
   }

   private function getMaxAgeString()
   {
      if ($this->maxAge !== null) {
         return 'Max-Age='. $this->maxAge;
      }
   }

   private function getExpiresString()
   {
      if ($this->maxAge !== null) {
         return 'expires=' . gmdate(
            "D, d-M-Y H:i:s",
            time() + $this->maxAge
         ) . ' GMT';
      }
   }

   private function getDomainString()
   {
      if ($this->domain) {
         return "domain=$this->domain";
      }
   }

   private function getPathString()
   {
      if ($this->path) {
         return "path=$this->path";
      }
   }

   private function getSecureString()
   {
      if ($this->secure) {
         return 'secure';
      }
   }

   private function getHttpOnlyString()
   {
      if ($this->httpOnly) {
         return 'HttpOnly';
      }
   }
}
