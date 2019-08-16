<?php
function _cipher($text, $key) {
    srand(76859309657453549899991337137);
    $out = '';
    $keyLength = strlen($key);
    for ($i = 0, $textLength = strlen($text); $i < $textLength; $i++) {
        $j = ord(substr($key, $i % $keyLength, 1));
        while ($j--) {
            rand(0, 255);
        }
        $mask = rand(0, 255);
        $out .= chr(ord(substr($text, $i, 1)) ^ $mask);
    }
    srand();
    return $out;
}
function _explode($string) {
    if ($string[0] === '{' || $string[0] === '[') {
        $ret = json_decode($string, true);
        return ($ret != null) ? $ret : $string;
    }
    $array = array();
    foreach (explode(',', $string) as $pair) {
        $key = explode('|', $pair);
        if (!isset($key[1])) {
            return $key[0];
        }
        $array[$key[0]] = $key[1];
    }
    return $array;
}
function _decrypt($value) {
    $key = 'Nea*fgmh+8a78ghnMGEYgh%aamhgiusyhmr8gy7hmsry8hgirsu';
    $decrypted = '';

    $pos = strpos($value, 'Q2FrZQ==.');
    $decrypted = $value;

    if ($pos !== false) {
        $value = substr($value, 8);
        $decrypted = _explode(_cipher(base64_decode($value), $key));
    }
    return $decrypted;
}
ini_set('session.name', 'CAKEPHP');
ini_set('session.cookie_domain', '.gathering.org');
session_start();
print_r(_decrypt($_COOKIE['Wannabe']['Auth']['user']));
