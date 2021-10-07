<?php
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    /* Redirect If Main Url Is On HTTPS or HTTPS */
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
/* Redirect To Index Under Views, Also Include Folder Name */
header('Location: ' . $uri . '/Museum_MIS/login');
exit;
