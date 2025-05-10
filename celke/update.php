<?php

//Incluir o arquivo com a conexão com o banco de dados
require_once("./connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <a href="index.php">Listar</a>
    <h2>Editar Usuário</h2>

    <?php

    $id = 2;
    $name = "Pedro1";
    $email = "1petrus123@gmail.com";

    //Criar a QUERY editar usuário.
    $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";

    //Preparar a QUERY.
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Usuário editado com sucesso!";
    } else {
        echo "Ops! Algo deu errado, usuário não editado.";
    }

    ?>
</body>

</html>
