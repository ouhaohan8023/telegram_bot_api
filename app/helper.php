<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2019/5/30
 * Time: 17:14
 */

/**
 * Get an item from an array using "dot" notation.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function array_get($array, $key, $default = null)
{
  if (is_null($key)) return $array;

  if (isset($array[$key])) return $array[$key];

  foreach (explode('.', $key) as $segment)
  {
    if ( ! is_array($array) || ! array_key_exists($segment, $array))
    {
      return ($default);
    }

    $array = $array[$segment];
  }

  return $array;
}