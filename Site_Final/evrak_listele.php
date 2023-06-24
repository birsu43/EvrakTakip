<?php

require_once 'baglanti.php';

$sorgu=$db->prepare('SELECT * FROM evrak');
$sorgu->execute();
$personellist=$sorgu->fetchAll(PDO::FETCH_OBJ);
?>
