<?php

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function base_url() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        ? "https://"
        : "http://";

    return $protocol . $_SERVER['HTTP_HOST'];
}