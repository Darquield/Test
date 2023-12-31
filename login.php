<?php
session_start();

// Função para conectar ao banco de dados (substitua pelas suas informações)
function conectarAoBanco() {
    $servername = "localhost"; // Nome do servidor MySQL
    $username = "root"; // Nome de usuário do banco de dados
    $password = "root"; // Senha do banco de dados
    $database = "wagnerpap"; // Nome do banco de dados

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    return $conn;
}

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Conectar ao banco de dados
    $conn = conectarAoBanco();

    // Consulta SQL para verificar as credenciais
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = mysqli_fetch_assoc($result);
        $senha_db = $row['senha'];
        if (password_verify($senha, $senha_db)){
            
            $_SESSION["user_id"] = $row['id'];
            $_SESSION["usuario_logado"] = true;
            $_SESSION["admin"] = $row['admin'];

            header("Location: index1.php"); // Redirecionar para a página principal após o login
            exit();
        }else{
            echo "erro";
            
        }
        

    } else {
        // Login falhou
        $_SESSION["login_erro"] = "Email ou senha incorretos";
        header("Location: login.php"); // Redirecionar de volta para a página de login
        exit();
    }
}

// Se você chegou até aqui, significa que a página de login foi acessada normalmente
?>
