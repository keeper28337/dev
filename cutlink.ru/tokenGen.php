<?php

function tokenGen ($min = 5, $max = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDFEGHIJKLMNOPRSTUVWXYZ0123456789';
    $new_chars = str_split($chars);

    $token = '';
    $rand_end = mt_rand($min, $max);

    for ($i = 0; $i < $rand_end; $i++) {
        $token .= $new_chars[mt_rand(0, sizeof($new_chars) - 1)];
    }

    return $token;
}
