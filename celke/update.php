<?php

session_start(); //Iniciar a sessão.

//Incluir o arquivo com a conexão com o banco de dados.
require_once("./connection.php");

//Implementar o ID.
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
    <a href="view.php?id=<?php echo $id; ?>">visualizar</a>

    <h2>Editar Usuário</h2>

    <?php

    //Criar a QUERY visualizar usuário.
    $sql = "SELECT id, name, email FROM users WHERE id = :id";

    //Preparar a QUERY.
    $stmt = $conn->prepare($sql);

    //Substituindo os links da QUERY pelos valores.
    $stmt->bindParam("id", $id, PDO::PARAM_INT);

    //Executar a QUERY.
    $stmt->execute();

    //Ler os dados do registro.
    $row_user = $stmt->fetch(PDO::FETCH_ASSOC);

    //Verificar se não encontrou o registro no banco de dados.
    if (!$row_user) {

        //criar a mensagem de erro e salvar na variável global.
        $_SESSION['msg'] = "<p style = 'color: #f00'>Usuário não encontrado!</p>";

        //redirecionar o usuário para a página listar.
        header("Location: index.php");

        //Parar o processamento da página.
        return;

    }

    //extrair o array para imprimir os valores através do elemento do array.
    extract($row_user);

    //Receber os dados do formulário.
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Verificar se o token CSRF é válido.
    if (isset($data['csrf_token']) && hash_equals($_SESSION['csrf_tokens']['form_update_user'], $data['csrf_token'])) {

        //Tratar exceções e erros.
        try {

            //Criar a QUERY editar usuário.
            $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";

            //Preparar a QUERY.
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":name", $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(":id", $data['id'], PDO::PARAM_INT);

            if ($stmt->execute()) {

                //criar a mensagem de erro e salvar na variável global.
                $_SESSION['msg'] = "<p style = color: #086>Usuário editado com sucesso!</p>";

                //redirecionar o usuário para a página listar.
                header("Location: index.php");

                //Parar o processamento da página.
                return;

            } else {
                echo "<p style = color: #f00>Ops! Algo deu errado, usuário não editado.</p>";
            }

        } catch (Exception $e) {

            echo "<p style = color: #f00>Usuário não editado!</p>";
        }
    }

    ?>

    <form method="POST" action="">

        <?php
        //função random_bytes gera uma sequência de 32 números aleatórios.
        //a função bin2hex converte os bytes binários gerados pela random_bytes em uma representação hexadecimal.
        $token = bin2hex(random_bytes(32));

        //salvar o token csrf na sessão.
        $_SESSION['csrf_tokens']['form_update_user'] = $token;
        ?>
        <input type="hidden" name="csrf_token" value=<?php echo $token; ?>>

        <input type="hidden" name="id" value=<?php echo $id; ?>>

        <label>Nome:</label>
        <input type="text" name="name" placeholder="Nome Completo" value="<?php echo $data['name'] ?? $name; ?>"
            required><br><br>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Melhor email" value="<?php echo $data['email'] ?? $email; ?>"
            required><br><br>

        <input type="submit" value="Salvar"><br><br>

    </form>
</body>

</html>
