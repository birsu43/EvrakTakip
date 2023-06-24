<?php

require_once 'baglanti.php';

$sorgu=$db->prepare('SELECT * FROM log order by tarih desc');
$sorgu->execute();
$logsorgu=$sorgu->fetchAll(PDO::FETCH_OBJ);
?>