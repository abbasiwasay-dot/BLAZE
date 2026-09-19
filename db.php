<?php
require("config.php");

$connection=mysqli_connect($host,$username,$password,$db,4306);
if(!$connection){
    die("cant load");
}
?>