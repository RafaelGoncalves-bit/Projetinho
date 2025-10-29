<?php
$host = "localhost";
$user = "root"; //pode alterar
$pass = ""; //senha do MySQL
$db = "givanildo";

$conn = mysqli_connect(hostname: $host, username: $user, password: $pass, database: $db);

if (!$conn) {
    die("Deu erro seu broxa " . mysqli_connect_error());
}