<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Método POST está funcionando!";
} else {
    echo "Método HTTP não permitido.";
}
?>
