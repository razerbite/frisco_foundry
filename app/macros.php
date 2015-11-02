<?php

/**
 * Extend Str class to add number to alpha
 *
 * @return string
 * @author Gat
 **/
Str::macro('numToAlpha', function ($n) {
  $r = '';
  for ($i = 1; $n >= 0 && $i < 10; $i++) {
      $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
      $n -= pow(26, $i);
  }
  return $r;
});
