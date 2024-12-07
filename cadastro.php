<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "ppi", "ppi2024", "flexfitlife");

    // Verifica conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $CPF = $_POST['cpf'];
    $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';

    // Verifica se a data foi recebida corretamente
    if (empty($data_nascimento)) {
        $data_nascimento = NULL;
    } else {
        // Verifica se a data está no formato correto (YYYY-MM-DD)
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_nascimento)) {
            die("Formato de data inválido. Use o formato YYYY-MM-DD.");
        }
    }

    // Validação de senha
    if (!preg_match("/^(?=.*[A-Z])(?=.*\d).{5,}$/", $senha)) {
        die("A senha deve ter pelo menos 5 caracteres, 1 número e 1 letra maiúscula.");
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Lida com o upload da foto
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];

    // Verifica se o diretório uploads existe, caso contrário cria
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);  // Cria o diretório com permissões adequadas
    }

    $foto_destino = "uploads/" . $foto;

    if (move_uploaded_file($foto_tmp, $foto_destino)) {
        // Insere os dados no banco de dados
        $sql = "INSERT INTO cadastro_usuario (nome, email, senha, cpf, data_nascimento) 
                VALUES ('$nome', '$email', '$senha_hash', '$CPF', '$data_nascimento')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Cadastro realizado com sucesso!";
            header("Location: login.html");  // Redireciona para a página de login
            exit(); // Importante para interromper a execução do código após o redirecionamento
        } else {
            echo "Erro ao cadastrar no banco de dados: " . $conn->error;
        }
    } else {
        echo "Erro ao fazer upload da foto.";
    }

    $conn->close();
}

?>
