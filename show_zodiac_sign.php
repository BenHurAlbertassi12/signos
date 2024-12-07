<?php include('layouts/header.php'); ?>
<div class="container mt-5">
  <?php
    $data_nascimento = $_POST['data_nascimento'];
    $data_formatada = DateTime::createFromFormat('Y-m-d', $data_nascimento);
    $data_mes_dia = $data_formatada->format('d/m');
    $signos = simplexml_load_file("signos.xml");

    $signo_encontrado = null;

    foreach ($signos->signo as $signo) {
      $inicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio)->format('z');
      $fim = DateTime::createFromFormat('d/m', (string)$signo->dataFim)->format('z');
      $atual = DateTime::createFromFormat('d/m', $data_mes_dia)->format('z');

      if (($inicio <= $atual && $atual <= $fim) || ($inicio > $fim && ($atual >= $inicio || $atual <= $fim))) {
        $signo_encontrado = $signo;
        break;
      }
    }
    
    if ($signo_encontrado) {
      echo "<h1>Seu signo é: " . $signo_encontrado->signoNome . "</h1>";
      echo "<p>" . $signo_encontrado->descricao . "</p>";
    } else {
      echo "<p>Não foi possível determinar seu signo.</p>";
    }
  ?>
  <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
