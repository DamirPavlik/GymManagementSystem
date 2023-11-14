<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "gym_membership";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Neuspesna konekcija: " . mysqli_connect_error());
}