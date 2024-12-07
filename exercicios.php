<?php
// Conectar ao banco de dados
$conn = new mysqli("localhost", "usuario", "senha", "ppi");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Buscar os exercícios no banco de dados
$sql = "SELECT * FROM exercicios";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercícios - Flex Fit Life</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #7f00ff, #e100ff);
            color: #fff;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        nav {
            display: flex;
            gap: 20px;
            background-color: #800080;
            padding: 20px;
            width: 100%;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2em;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #e100ff;
        }
        .content-container {
            background-color: #fff;
            color: #000;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 80%;
            max-width: 1000px;
        }
        .exercicios-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }
        .exercicio {
            background-color: #fff;
            color: #000;
            width: 250px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .exercicio img {
            width: 100%;
            border-radius: 10px;
        }
        button {
            background-color: #800080;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #e100ff;
        }
    </style>
</head>
<body>
    <nav>
        <a href="quem_somos.html">Quem Somos</a>
        <a href="feedback.html">Feedback</a>
        <a href="dicas.html">Dicas</a>
        <a href="perfil.php">Perfil</a>
    </nav>
    <div class="content-container">
        <h2>Exercícios</h2>
        <p>Aqui você encontra uma seleção de exercícios. Clique para ver os detalhes.</p>
        
        <div class="exercicios-container">
            <?php while($exercicio = $result->fetch_assoc()) { ?>
                <div class="exercicio">
                    <img src="exercicios/<?php echo $exercicio['imagem']; ?>" alt="Exercício">
                    <h4><?php echo $exercicio['nome']; ?></h4>
                    <button onclick="window.location.href='detalhes_exercicio.php?id=<?php echo $exercicio['id']; ?>'">Ver Detalhes</button>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
