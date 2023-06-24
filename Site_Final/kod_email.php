<?php
require_once 'baglanti.php';

if ($_GET['user_code']) {
    $gelenkod=$_GET['user_code'];
}
require 'bir.html';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/Adsiz.png" type="image/x-icon">

    <title>Şifremi Unuttum</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="passwordBox animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Şifremi Unuttum</h2>

                    <p>
                    E-posta adresinizi girin, şifreniz sıfırlanacak ve size e-posta ile gönderilecektir.
                       
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form"  method="post">
                                <div class="form-group">
                                    <input name="kod" type="text" class="form-control" placeholder="Email Adresi" required="" value="<?= $gelenkod?>">
                              

                            <form class="m-t" role="form"  method="post" action="sifre_yenileme.php">
                                <button type="submit" class="btn btn-primary block full-width m-b">Şifre Değiştirme Sayfasına Git</button>
                            </form>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
       
    </div>

</body>

</html>
