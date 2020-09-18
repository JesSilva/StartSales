<?php

function Connect(){

  $sv = "localhost";
  $us = "root";
  $pw = "root";
  $db = "startsales";

  $conn = mysqli_connect($sv, $us, $pw, $db) or die();

  return $conn;
}

 ?>
