<?php  require_once ('baglanti.php');
//require_once ("log_ekle.php");
//session_start();
//var_dump($_SESSION);


if(isset($_GET['codekullanıcıyok'])){
    echo '<script type="text/javascript">';
    echo ' alert("Böyle Bir Kullanıcı Yok")';  //not showing an alert box.
    echo '</script>';
}

if(isset($_GET['codegeldi'])){
    echo '<script type="text/javascript">';
    echo ' alert("Kod Gönderildi")';  //not showing an alert box.
    echo '</script>';
}

if(isset($_GET['codehata'])){
    echo '<script type="text/javascript">';
    echo ' alert("Hata Var")';  //not showing an alert box.
    echo '</script>';
}

if(isset($_GET['codeemailyok'])){
    echo '<script type="text/javascript">';
    echo ' alert("E-mail Boş")';  //not showing an alert box.
    echo '</script>';
}

require 'bir.html';
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/Adsiz.png" type="image/x-icon">

    <title>Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        
        img.bosluk {
        margin-bottom: 35px;
        }
       
        #toggle{
            position:absolute;
            
            right:0px;
            top:64%;
            width:12%;
            display:flex;
            justify-content:center;
            align-items:center;
            height: 7%;
            /* border-top-right-radius:.25rem;
            border-bottom-right-radius:.25rem */
        }
        #toggle.hide{
            background-size: cover;

        }
    </style>

</head>



<div class="middle-box text-center loginscreen animated fadeInDown">
<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <img alt='logo'src="uploads/Adsiz.png" >

                <h5 class="logo-name">  </h5>

            </div>
           
            
           
            <form class="m-t" role="form" action="baglanti.php" method="POST">
                <div class="form-group">
                    
                    <input name="email" type="email" class="form-control" placeholder="E-Posta" required="">
                </div>
                <div class="form-group">
                   
                   <input name="password" id="password" type="password" class="form-control" placeholder="Şifre" required="">
                   <div class="fa fa-eye text-white bg-primary" id="toggle" onclick="showHidePass();"></div>
               </div>
                <button name="giris" type="submit" class="btn btn-primary block full-width m-b">Giriş</button>

                <a href="forgot_password.php"><small>Şifremi Unuttum?</small></a>
                <p class="text-muted text-center"><small>Hesabınız yok mu?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.php">Hesap oluşturun</a>
                
            </form>
            
        </div>
    </div>
</div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
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
</body>

</html>
