<?php
require 'config.php';

$id = $_GET['id'] ?? 0;

peticionAPI('DELETE', "/$id");

header('Location: index.php');
exit;
?>