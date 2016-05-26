<?php
require_once "autoload.php";
/* The below code is what I used to test my code I tested the accuracy of this library
the third parameter is an integer and it is a code 
Code 0: If you want to generate drawable folder only
Code 1: for generating mipmap folder only
Code 2; for generating mipmap and drawable folders
Running this code alone generates the folders
For now this library can only work for png
*/

$test = new AndroidDpiHlepr("images", 2);
$test->resizeImage("sample.png");
$test->resizeImage("sample1.png");
$test->resizeImage("sample2.png");
$test->resizeImage("sample3.png");
?>