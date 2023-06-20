<?php

if (!isset($_SERVER ['PHP_AUTH_USER'])) {
    header ("WWW-Authenticate: Basic realm=\"PrivateArea\"");
    header ("HTTP/1.0 401 Unauthorized");
    print "You are not authorized.";
    exit;
} else {
    if (($_SERVER['PHP_AUTH_USER'] == 'billie' && ($_SERVER['PHP_AUTH_PW'] == '1234'))) {
        print "Successfully authenticated";
    } else {
        header ("HTTP/1.0 401 Unauthorized");
        print "You are not authorized.";
    }
}