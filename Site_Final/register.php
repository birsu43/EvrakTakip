<?php
session_start();
if(isset($_GET['kullanıcımevcut'])){
    echo '<script>alert("Kullanıcı Mevcut")</script>';
}
if(isset($_GET['sifreuyusmuyor'])){
    echo '<script>alert("Şifreler Uyuşmuyor")</script>';
}
require 'bir.html';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kayıt Ol</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   <style>
    .logo {
     float: left;
     width: 100px;
     height: 50px;
     margin: 0px 0px;
}
        #toggle{
            position:absolute;
            
            right:0.8px;
            top:64.1%;
            width:12%;
            display:flex;
            justify-content:center;
            align-items:center;
            height: 5.5%;
            /* border-top-right-radius:.25rem;
            border-bottom-right-radius:.25rem */
        }
        #toggle.hide{
            background-size: cover;

        }
        #toggle2{
            position:absolute;
           
            right:0.8px;
            top:72.6%;
            width:12%;
            display:flex;
            justify-content:center;
            align-items:center;
            height: 5.5%;
            /* border-top-right-radius:.25rem;
            border-bottom-right-radius:.25rem */
        }
        #toggle.hide2{
            background-size: cover;

        }
   </style>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

             
           <img alt='logo'src="uploads/Adsiz.png" >
             

            </div>
           
            <form class="m-t" role="form" action="baglanti.php" method="post">
            <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Kullanıcı Adı" required="">
                </div>
                <div class="form-group">
                    <input name="email" type="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                <input name="password" id="password" type="password" class="form-control" placeholder="Şifre" required="">
                    <div class="fa fa-eye text-white bg-primary" id="toggle" onclick="showHidePass();"></div>
                </div>
                <div class="form-group">
                    <input id=password_again name="sifretekrar" type="password" class="form-control" placeholder="Yeni Şifre Tekrar" required="">
                    <div class="fa fa-eye text-white bg-primary" id="toggle2" onclick="showHidePass2();"></div>
                </div>
                <button name="kayit" type="submit" class="btn btn-primary block full-width m-b">Kayıt Ol</button>

                <p class="text-muted text-center"><small>Zaten hesabınız var mı?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.php">Giriş Yap</a>
            </form>
           
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
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
