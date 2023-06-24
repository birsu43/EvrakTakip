<?php 
require_once "baglanti.php";

if(isset($_POST['buttonID'])){

 $sql="SELECT * FROM evrak WHERE evrak_id = ".$_POST["id"];
$sorgu=$db->prepare($sql);
$sorgu->execute();
$satir=$sorgu->fetch(PDO::FETCH_ASSOC);

// var_dump($satir);
// exit();
 echo json_encode($satir ,256);
}

if(isset($_POST['buttonKisi'])){

    $sql="SELECT * FROM giris WHERE user_adsoyad ='".$_POST["alan"]."'";
    
   $sorgu=$db->prepare($sql);
   $sorgu->execute();
   $satir=$sorgu->fetch(PDO::FETCH_ASSOC);
   
   // var_dump($satir);
   // exit();
    echo json_encode($satir ,256);
   }

if(isset($_POST['buttonVeren'])){
    $sql="SELECT * FROM giris WHERE user_adsoyad ='".$_POST["veren"]."'";
 
    $sorgu=$db->prepare($sql);
    $sorgu->execute();
    $satir=$sorgu->fetch(PDO::FETCH_ASSOC);


    echo json_encode($satir ,256);
}


?>