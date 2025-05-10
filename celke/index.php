<?php

session_start(); //Iniciar a sessão

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
    <a href="create.php">Cadastrar</a>
    <h2>Listar usuários</h2>
    <?php

    //verificar se exista a mensagem de erro/sucesso.
    if (isset($_SESSION['msg'])) {

        //imprimir a mensagem de erro/sucesso.
        echo $_SESSION['msg'];

        //destruir a mensagem de erro/sucesso.
        unset($_SESSION['msg']);

    }

    //criar a QUERY listar usuários.
    $sql = "SELECT id, name, email FROM users";

    //preparar a QUERY.
    $stmt = $conn->prepare($sql);

    //executar a QUERY.
    $stmt->execute();

    //laço de repetição para ler os registros.
    while ($row_user = $stmt->fetch(PDO::FETCH_ASSOC)) {

        //extrair o array para imprimir os valores através do elemento do array
        extract($row_user);

        //imprimir informações do registro
        echo "ID: $id<br>";
        echo "Nome: $name<br>";
        echo "Email: $email<br>";

        echo "<a href = 'view.php?id=$id'>Visualizar</a><br>";
        echo "<a href = 'update.php?id=$id'>Editar</a><br>";

        echo "<hr>";
    }
    ?>
</body>

</html>
