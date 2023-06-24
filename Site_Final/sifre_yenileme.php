<?php
require_once 'baglanti.php';
$yenile_email=$_SESSION['yenile_email'];
$yenile_kod=$_SESSION['kod'];
if (isset($_POST['yenile'])) {
    $email=strip_tags($_POST['email']);
    $sifre=strip_tags($_POST['password']);
    $sifretekrar=strip_tags($_POST['sifretekrar']);
    $sifre=md5($sifre);
    $sifretekrar=md5($sifretekrar);
    $kod=strip_tags($_POST['kod']);

    if ($email!="" and $sifre!="" and $sifretekrar!="" and $kod!="") {
        if ($sifretekrar == $sifre) {
            $control = $db->prepare("SELECT * FROM giris WHERE user_code=? and user_email=?");
            $control->execute(array($kod,$email));
            $sonuc=$control->rowCount();
            if ($sonuc!=0) {
                $sorgu = $db->prepare("UPDATE giris set user_password = ? , user_code = ? WHERE user_email = ?");
                $calistir = $sorgu -> execute(array($sifre,"",$email));
                if ($calistir) {
                    header("Location:login.php?sifredegisti=1");
                }
                else {
                    echo "Şifre Değişmedi";
                }
            }
            else {
                echo "Kod Yanlış";
            }
        }
        else {
            echo "Yeni Şifreler Uymuyor";
        }
    }
    else {
        echo "Tüm Alanları Doldurun";
    }

} 
require 'bir.html';   

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Şifre Yenile</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .bosluk {
        margin-bottom: 10px;
        }
 
        #toggle{
            position:absolute;
           
            right:15px;
            top:26%;
            width:10%;
            display:flex;
            justify-content:center;
            align-items:center;
            height: 12.5%;
            /* border-top-right-radius:.25rem;
            border-bottom-right-radius:.25rem */
        }
        #toggle.hide{
            background-size: cover;

        }
        
        #toggle2{
            position:absolute;
           
            right:15px;
            top:44%;
            width:10%;
            display:flex;
            justify-content:center;
            align-items:center;
            height: 12.5%;
            /* border-top-right-radius:.25rem;
            border-bottom-right-radius:.25rem */
        }
        #toggle.hide2{
            background-size: cover;

        }
        
    </style>

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Şifre Yenile</h2>

                    <p>
                    Size Gelen Kodu Yazın.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form"  method="post">
                                <div class="form-group">
                                    <input  name="email" type="email" class="form-control" placeholder="Email address" required="" value="<?= $yenile_email ?>">
                                </div>
                                <div class="form-group">    
                                    <input name="password" id="password" type="password" class="form-control" placeholder="Şifre" required="">
                                   <div class="fa fa-eye text-white bg-primary" id="toggle" onclick="showHidePass();"></div>
                                </div>
                                <div class="form-group">
                                    <input id=password_again name="sifretekrar" type="password" class="form-control" placeholder="Yeni Şifre Tekrar" required="">
                                    <div class="fa fa-eye text-white bg-primary" id="toggle2" onclick="showHidePass2();"></div>
                                </div>
                                <div class="form-group">
                                    <input name="kod" type="text" class="form-control" placeholder="Size Gelen Kod" required="" value="<?= $yenile_kod ?>">
                                </div>

                                <button name="yenile" type="submit" class="btn btn-success block full-width m-b">Şifre Yenile</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
           var password = document.getElementById("password");
        var toggle = document.getElementById("toggle");

        function showHidePass(){
            if (password.type === "password") {
                password.setAttribute('type','text');
                toggle.classList.add('hide');
            }else{
                password.setAttribute('type','password');
                toggle.classList.remove('hide');

            }
        }
    </script>
    <script>
           var password = document.getElementById("password");
           var password_again = document.getElementById("password_again");
        var toggle = document.getElementById("toggle");

        function showHidePass2(){
            if (password_again.type === "password") {
                password_again.setAttribute('type','text');
                toggle.classList.add('hide');
            }else{
                password_again.setAttribute('type','password');
                toggle.classList.remove('hide');

            }
        }
    </script>
     

</body>

</html>