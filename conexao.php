<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrofertil_agricola";

// Cria uma nova conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
