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

interface CookieInterface
{
   public function getName();
   public function setValue($value);
   public function setMaxAge($seconds);
   public function setDomain($domain);
   public function setPath($path);
   public function setSecure($secure);
   public function setHttpOnly($httpOnly);
   public function getHeaderString();
}
