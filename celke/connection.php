
<?php 

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "celke";
$port = 3306;


try{

    $conn = new PDO("mysql:host=$host; port=$port; dbname=" . $dbname, $user, $pass);
    
    // echo "Conexão com o banco de dados realizada com sucesso!";

}catch(PDOException $e){

   die("Erro 001: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador.");

}




?>