<?php

session_start(); //Iniciar a sessão

//Incluir o arquivo com a conexão com o banco de dados
require_once("./connection.php");

ob_start(); //Limpar o buffer.

//Receber o ID pela url.
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <a href="index.php">Listar</a><br>
    <a href="update.php?id=<?php echo $id; ?>">Editar</a>
    <a href="delete.php?id=<?php echo $id; ?>">Apagar</a>

    <h2>Visualizar Usuário</h2>

    <?php

    //verificar se exista a mensagem de erro/sucesso.
    if (isset($_SESSION['msg'])) {

        //imprimir a mensagem de erro/sucesso.
        echo $_SESSION['msg'];

        //destruir a mensagem de erro/sucesso.
        unset($_SESSION['msg']);

    }

    //Criar a QUERY visualizar usuário.
    $sql = "SELECT id, name, email FROM users WHERE id = :id";

    //Preparar a QUERY.
    $stmt = $conn->prepare($sql);

    //Substituir os links da QUERY pelos valores.
    $stmt->bindParam('id', $id, PDO::PARAM_INT);

    //Executar a QUERY.
    $stmt->execute();

    //Ler os dados do usuário.
    $row_user = $stmt->fetch(PDO::FETCH_ASSOC);

    //verificar se encontrou o registro no banco de dados.
    if ($row_user ?? false) {

        //extrair o array para imprimir os valores através do elemento do array.
        extract($row_user);

        //imprimir informações do registro.
        echo "ID: $id<br>";
        echo "Nome: $name<br>";
        echo "Email: $email<br>";

    } else {

        //criar a mensagem de erro e salvar na variável global.
        $_SESSION['msg'] = "<p>Usuário não encontrado!</p>";

        //redirecionar o usuário para a página listar.
        header("Location: index.php");

    }

    ?>
    
</body>

</html>
