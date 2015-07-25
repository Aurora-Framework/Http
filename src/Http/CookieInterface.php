<?php

namespace Aurora\Http;

interface CookieInterface
{
   public function getName();
   public function setValue($value);
   public function setMaxAge($seconds);
   public function setDomain($domain);
   public function setPath($path);
   public function setSecure($secure);
   public function setHttpOnly($httpOnly);
}
