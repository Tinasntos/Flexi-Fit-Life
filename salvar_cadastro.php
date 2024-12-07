<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "usuario", "senha", "ppi");

    // Verifica conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];

    // Move a foto para a pasta de uploads
    move_uploaded_file($foto_tmp, "uploads/" . $foto);

    // Insere os dados no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha, foto) VALUES ('$nome', '$email', '$senha', '$foto')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.html");
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Método HTTP não permitido.";
}
?>
