<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<title>Monitor ESP32</title>
<style>
body{ background: #111; color: red; font-family: Arial; text-align: center; margin-top: 100px; }
.valor{ font-size: 50px; margin: 20px; }
</style>
</head>
<body>
<h1>Dados da ESP32</h1>
<div class="valor">Velocidade: <span id="kph">0</span></div>
<div class="valor">RPM: <span id="rpm">0</span></div>
<script>
async function atualizarDados() {
fetch('buscar_ultimo.php')
.then(response => response.json())
.then(data => {
document.getElementById('kph').innerText = data.kph;
document.getElementById('rpm').innerText = data.rpm;
})
.catch(error => console.log(error));
}
atualizarDados();
setInterval(atualizarDados, 250);
</script>
</body>
</html>
<?php
include 'connect.php';
include 'buscar_ultimo.php';
include 'salvar_dados.php';
?>