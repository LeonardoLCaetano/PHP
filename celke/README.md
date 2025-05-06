Comando SQL para criar a base de dados.
```
exemplo:
CREATE DATABASE nome_da_tabela CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
```
CREATE DATABASE celke CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
```
```
Comando SQL para criar a tabela "users".
```
CREATE TABLE IF NOT EXISTS users(
 	id int NOT NULL AUTO_INCREMENT,
    name varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
    email varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (id)
) ENGINE=INNODB, DEFAULT CHARSET=utf8mb4, COLLATE=utf8mb4_unicode_ci;
```
```
Comando SQL para apagar a tabela "users".
```
DROP TABLE IF EXISTS nome_da_tabela;
```
DROP TABLE IF EXISTS users;
```

CONEXÃO COM O BANCO DE DADOS ATRAVÉS DO PDO

try{

    $conn = new PDO("mysql:host=$host; port=$port; dbname=" . $dbname, $user, $pass);
    
    echo "Conexão com o banco de dados realizada com sucesso!";

}catch(PDOException $e){

    echo "Erro: conexão com o banco de dados não realizada. Erro gerado: " . $e->getMessage();
}
```

//-----------------------------------------------//
///USAR LINK DA QUERY E SUBSTITUIR COM BINDPARAM///
//----------------------------------------------//

$name = 'Pedro';
$email = 'pedro123@gmail.com';

//Criar a QUERY cadastrar usuário.
$sql = "INSERT INTO users (name, email) VALUES (:name, :email)";

//Preparar a Query.
$stmt = $conn->prepare($sql);

//Substituir os links da QUERY pelos valores
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);

//Executar a QUERY
$stmt->execute();
´´´

//-----------------------------------------------//
///USAR LINK DA QUERY E SUBSTITUIR COM BINDVALUE///
//----------------------------------------------//

//Criar a QUERY cadastrar usuário.
$sql = "INSERT INTO users (name, email) VALUES (:name, :email)";

// Preparar a Query.
$stmt = $conn->prepare($sql);

// Substituir os links da QUERY pelos valores
$stmt->bindValue(':name', 'Pietra', PDO::PARAM_STR);
$stmt->bindValue(':email', 'pietra123@gmail.com', PDO::PARAM_STR);

// Executar a QUERY
$stmt->execute();


//----------------------------------------------------//
/CADASTRANDO DADOS DO FORMULÁRIO PARA O BANCO DE DADOS/
//----------------------------------------------------//

<body>
´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
    <?php
    //Receber os dados do formulário.
    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Verificar se o token CSRF é válido.
    if (isset($data['csrf_token'])) {
        // var_dump($data);

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
        if($stmt->rowCount()){
            //Recupera o ID do ultimo registro cadastrado.
            $lastId = $conn->lastInsertId();
            echo "Usuário cadastrado com sucesso! ID do registro: $lastId";
        }else{
            echo "Usuário não cadastrado.";
        }
    }
    
    ?>
    ´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="123456">

        <label>Nome:</label>
        <input type="text" name="name" placeholder="Nome Completo" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Melhor email" required><br><br>

        <input type="submit" value="Cadastrar"><br><br>

    </form>
</body>