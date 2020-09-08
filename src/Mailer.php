<?php

require_once 'EmailConfiguration.php';

$nome = $_POST['fnome'];
$email = $_POST['femail'];
$mensagem = $_POST['fmensagem'];

$config = new EmailConfiguration($nome, $email, $mensagem);
$config->sendEmail();
?>