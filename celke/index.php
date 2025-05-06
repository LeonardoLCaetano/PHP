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

    <?php
    //Receber os dados do formulário.
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Verificar se o token CSRF é válido.
    if (isset($data['csrf_token'])) {

        //Tratar exceções e erros
        try {
            //Criar a QUERY cadastrar usuário.
            $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";

            //Preparar a QUERY.
            $stmt = $conn->prepare($sql);

            //Substituir os links da QUERY pelos valores.
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);

            //Executar a QUERY.
            $stmt->execute();

            //Acessa o IF quando cadastrar o registro no banco de dados.
            if ($stmt->rowCount()) {

                //Recupera o ID do ultimo registro cadastrado.
                $lastId = $conn->lastInsertId();

                //Exclui os dados da variável $data
                unset($data); 

                echo "Usuário cadastrado com sucesso! ID do registro: $lastId";
            } else {
                echo "Usuário não cadastrado.";
            }
        } catch (Exception $e) {
            echo "Usuário não cadastrado 2.";
        }
    }

    ?>
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="123456">

        <label>Nome:</label>
        <input type="text" name="name" placeholder="Nome Completo" value = "<?php echo $data['name'] ?? ''; ?>" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Melhor email" value = "<?php echo $data['email'] ?? ''; ?>" required><br><br>

        <input type="submit" value="Cadastrar"><br><br>

    </form>



</body>

</html>