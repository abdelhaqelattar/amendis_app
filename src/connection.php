<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "gestion_factures";

$conn = new mysqli($servername, $username, $password, $db_name,3307);
if($conn->connect_error){
    die("connection failed: " . $conn->connect_error);
}

