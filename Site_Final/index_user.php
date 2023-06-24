<?php
require_once 'baglanti.php';
$kulid = $_SESSION['kulid']; 
$ad = $_SESSION['ad']." ".$_SESSION['soyad'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="uploads/Adsiz.png" type="image/x-icon">
   
    <style>
            /* --------BUTON BAŞLANGOÇ------------*/
            .bn632-hover {
        width: 160px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        margin: 20px;
        height: 55px;
        text-align:center;
        border: none;
        background-size: 300% 100%;
        border-radius: 50px;
        moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        -webkit-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;
      }

      .bn632-hover:hover {
        background-position: 100% 0;
        moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        -webkit-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;
      }

      .bn632-hover:focus {
        outline: none;
      }

      .bn632-hover.bn22 {
        background-image: linear-gradient(
          to right,
          #0ba360,
          #3cba92,
          #30dd8a,
          #2bb673
        );
        box-shadow: 0 4px 15px 0 rgba(23, 168, 108, 0.75);
      }
       /* ---------SAYFA BAŞLANGIÇ------------*/
       *,
      :before,
      :after {
        box-sizing: border-box;
        padding: 0;
        margin: 0;


      }
      .hide {
        display: none;
      }
      .page__style {
        background: #fff;
        font-family: OpenSans-Regular, sans-serif;
        position: relative;
        top: 28%;
        right: 0;
        bottom: 10%;
        left: 0;
        height: 100%;
        width: 100%;
        margin: auto auto;
        overflow: hidden;

      }
      .page__style .page__description {
        color: #000;
        font-weight: 300;
        text-align: center;

      }
      .page__style h1 {
        font-weight: 300;
        margin-top: 200px;
        margin-bottom: 30px;
      }


      .projects {
        background: #ffff;
      }

       /* ---------BACKGROUND BAŞLANGIÇ------------*/
       .ball {
        position: absolute;
        border-radius: 100%;
        opacity: 0.7;
      }


    </style>

  </head>
  <section>
  <body>

    <div class="page__style projects">
      <div class="page__description">
        
       
        
        
          <h1>Evrak Takip Sistemi</h1>
          <?php if ($_SESSION['user_yetki'] == 0) {
          echo '
          <a href="giden_evrak.php?evrak_getirenkisi='.$ad.'"><button class="bn632-hover bn22">Giden Evraklar</button></a>';
          } ?>
          <?php if ($_SESSION['user_yetki'] == 1) {
          echo '
          <a href="evrak.php"><button class="bn632-hover bn22">Bütün Evraklar</button></a>';
          } ?>
          <?php if ($_SESSION['user_yetki'] == 1) {
          echo '
          <a href="log_tablo.php"><button class="bn632-hover bn22">Giriş-Çıkış Log</button></a>';
          } ?>
          <?php if ($_SESSION['user_yetki'] == 1) {
          echo '
          <a href="evrak_log_tablo.php"><button class="bn632-hover bn22">Evrak Log</button></a>';
          } ?>
           <?php if ($_SESSION['user_yetki'] == 0) {
          echo '
          <a href="gelen_evrak.php?evrak_alankisi='.$ad.'"><button class="bn632-hover bn22">Gelen Evraklar</button></a>';
          } ?>
           
          <a href="evrak_girme.php?user_id=<?=$kulid?>"><button class="bn632-hover bn22">Evrak Yazma</button></a>
       
       
      </div>
    </div>
    <script src="bir.js"></script>
  </body>
</section>
</html>