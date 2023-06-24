<?php
require_once("baglanti.php");
if(isset($_GET['cikis'])){
    $logekle =$db->prepare("INSERT INTO log(ip,kullanici_adi,kullanici_email,durum,cihaz,isletim_sistemi,tarayici) values( 
        :i,
        :ka,
        :em,
        :d,
        :c,
        :is,
        :t)
        ");
        
        $logekle->execute([                
            ':i' => $ip,
            ':ka' => $_SESSION['kadi'],
            ':em' =>$_SESSION['mail'],
            ':d' => "Çıkış Yaptı",
            ':c' => $get_device,
            ':is' => $get_os,
            ':t' => $get_browser
        ]);
    session_destroy();
    echo '<script type="text/javascript">';
    echo ' alert("Çıkış Yapıldı")';  //not showing an alert box.
    echo '</script>';
    header('Location:login.php');

}
require 'bir.html';
?>