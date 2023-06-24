<?php
require_once 'log/user_info.php';
require_once 'baglanti.php';
$sil_email= $_SESSION['mail'];
$sil_username= $_SESSION['kadi'];
$ad = $_SESSION['ad']." ".$_SESSION['soyad'];

$userinfo = new UserInfo();
$ip = $userinfo->get_ip();
$get_os = $userinfo->get_os();
$get_browser = $userinfo->get_browser();
$get_device = $userinfo->get_device();

if (isset($_GET['evrak_id'])) {
    $silsorgu="SELECT * FROM evrak WHERE evrak_id = ?";
    $sillog=$db->prepare($silsorgu);
    $sillog->execute(array($_GET['evrak_id']));
    $satirsil=$sillog->fetch(PDO::FETCH_ASSOC);
    //  var_dump($satirsil['evrak_adi']);
    //  exit();

    $logekle =$db->prepare("INSERT INTO logevrak(logevrak_ip,logevrak_username,logevrak_email,logevrak_islem,logevrak_evrak_adi,logevrak_adsoyad) values( 
        :i,
        :ka,
        :em,
        :is,
        :ev,
        :ad
        )
        ");
        
        $logekle->execute([                
            ':i' => $ip,
            ':ka' => $sil_username,
            ':em' =>$sil_email,
            ':is' => "Evrak Silindi",
            ':ev' => $satirsil['evrak_adi'],
            ':ad' => $ad
        ]);


    $sqlsil="DELETE FROM evrak WHERE evrak.evrak_id=?";
    $sorgu=$db->prepare($sqlsil);
    $sorgu->execute([$_GET['evrak_id']]);

    header('Location:index.php');
}

?>
