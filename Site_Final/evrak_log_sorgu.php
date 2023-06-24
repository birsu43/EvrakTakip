<?php

require_once 'baglanti.php';

$sorgu=$db->prepare('SELECT * FROM logevrak order by logevrak_tarih desc');
$sorgu->execute();
$logsorgu=$sorgu->fetchAll(PDO::FETCH_OBJ);
?>