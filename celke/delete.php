<?php

session_start(); //Iniciar a sessão.

//Incluir o arquivo com a conexão com o banco de dados
require_once("./connection.php");

ob_start(); //Limpar o buffer.

//Implementar o ID.
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if ($id) {

    try {
        //Criar a QUERY deletar usuário.
        $sql = "DELETE FROM users WHERE id = :id";

        //Preparar a QUERY.
        $stmt = $conn->prepare($sql);

        //substituir os links da QUERY pelos valores.
        $stmt->bindParam("id", $id, PDO::PARAM_INT);

        //Executar a QUERY
        $stmt->execute();


        //Verificar o número de linhas afetadas.
        $affectedRows = $stmt->rowCount();
        //Verifica se executou o SQL.

        //Verificar se algum registro foi afetado no banco de dados.
        if ($affectedRows > 0) {
            //criar a mensagem de sucesso e salvar na variável global.
            $_SESSION['msg'] = "<p style = 'color: #086'>Usuário apagado com sucesso!</p>";

            //redirecionar o usuário para a página listar.
            header("Location: index.php");

            //Parar o processamento da página
            return;
        }
    } catch (Exception $e) {

    }

}

//criar a mensagem de erro e salvar na variável global.
$_SESSION['msg'] = "<p style = 'color: #f00'>Usuário não encontrado!</p>";

//redirecionar o usuário para a página listar.
header("Location: index.php");

?>
