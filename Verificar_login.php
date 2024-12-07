<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "ppi", "ppi2024", "flexfitlife");

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém os dados do formulário
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$senha = trim($_POST['senha']);

// Valida o formato do e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("E-mail inválido.");
}

// Prepara a consulta para evitar SQL Injection
$stmt = $conn->prepare("SELECT * FROM cadastro_usuario WHERE email = ?");
if (!$stmt) {
    die("Erro ao preparar a consulta: " . $conn->error);
}

// Associa o parâmetro
$stmt->bind_param("s", $email);

// Executa a consulta
$stmt->execute();

// Obtém o resultado
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($senha, $row['senha'])) {
        header("Location: Pagina_principal.html");
        exit(); // Garantir que o redirecionamento aconteça
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}

$conn->close();
?>
