<?php
echo "\r\nSESSION\r\n";
print_r($_SESSION);
echo "\r\nGET\r\n";
print_r($_GET);
echo "\r\nPOST\r\n";
print_r($_POST);
echo "\r\nPHP://INPUT\r\n";
print_r(file_get_contents('php://input'));
echo "\r\nJSON_DECODE PHP://INPUT\r\n";
print_r(json_decode(file_get_contents('php://input')));
?>
