<?php
use Ic\ProjectAbsensi\CodePresenter;
require __DIR__."/CodePresenter.php";

$nim = "11.11.1111";
$code = "abcde";
$cp = new CodePresenter($nim, $code);
echo $cp->execute(); // return response body.