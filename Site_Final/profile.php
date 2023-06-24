<?php
require_once 'baglanti.php';
require_once 'evrak_listele.php';
require_once 'evrak_silme.php';

if (empty($_SESSION['email'])) {
    header("location:login.php");
    exit;
}
if(isset($_GET['admingiris'])){
    echo '<script type="text/javascript">';
    echo ' alert("Hoşgeldin Admin")';  //not showing an alert box.
    echo '</script>';
}
if(isset($_GET['usergiris'])){
    echo '<script type="text/javascript">';
    echo ' alert("Hoşgeldin Kullanıcı")';  //not showing an alert box.
    echo '</script>';
}

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
if (isset($_POST['ogulcan'])) {
    $sqlguncelle="UPDATE giris SET user_username = ?, user_ad = ?, user_soyad =?, user_telefon =?, user_kurum =?, user_adsoyad=? WHERE giris.user_id=?"; 
    $adsoyad = $_POST['ad']." ".$_POST['soyad'];
    $dizi=[
        $_POST['kuladi'],
        $_POST['ad'],
        $_POST['soyad'],
        $_POST['telefon'],
        $_POST['kurum'],
        $adsoyad,
        $_POST['user_id']
    ];
    $sorgu=$db->prepare($sqlguncelle);
    $sorgu->execute($dizi);
    header("Location:index.php");
    exit();
}

$sql="SELECT * FROM giris WHERE user_id = ?";
$sorgu=$db->prepare($sql);
$sorgu->execute(array($_GET['user_id']));
$satir=$sorgu->fetch(PDO::FETCH_ASSOC);


$kulid = $_SESSION['kulid']; 
$ad = $_SESSION['ad']." ".$_SESSION['soyad'];
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Profile</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle" src="img/profile_small.jpg"/>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold"><?php
                                         if (isset($_SESSION['user'])) {
        
                                            echo $_SESSION['user'];
                                         }  
                                         ?></span>
                                    <?php
                                        if (isset($_SESSION['email'])) {
                                           echo $_SESSION['email'];
                                        } 
                                        ?>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a class="dropdown-item" href="profile.php?user_id=<?=$kulid?>">Profil</a></li>
                                 
                                </ul>
                        </div>
                        <div class="logo-element">
                            
                        </div>
                    </li>
                    <li>
                            <a href="index.php"><i class="fa fa-list"></i> <span class="nav-label">Evrak Listeleme</span></a>
                            </li>
                            <?php if ($_SESSION['user_yetki'] == 1) {
                               echo '
                                <li>
                               <a href="evrak.php"><i class="fa fa-list"></i> <span class="nav-label">Bütün Evraklar</span></a>
                                </li>';
                            } ?>
                            <?php if ($_SESSION['user_yetki'] == 0) {
                            echo '
                                <li>
                                <a href="giden_evrak.php?evrak_getirenkisi='.$ad.'"><i class="fa fa-exchange"></i> <span class="nav-label">Giden Evraklarım</span></a>
                                </li>';
                            } ?>

                            <?php if ($_SESSION['user_yetki'] == 0) {
                               echo '
                               <li>
                               <a href="gelen_evrak.php?evrak_alankisi='.$ad.'"><i class="fa fa-exchange"></i> <span class="nav-label">Gelen Evraklarım</span></a>
                                </li>';
                            } ?>

                            <li>
                                <a href="evrak_girme.php?user_id=<?=$kulid?>"><i class="fa fa-edit"></i> <span class="nav-label">Evrak Yazma</span></a>
                            </li>
                            <?php if ($_SESSION['user_yetki'] == 1) {
                               echo '
                                <li>
                               <a href="log_tablo.php"><i class="fa fa-laptop"></i> <span class="nav-label">Giriş-Çıkış Log</span></a>
                                </li>';
                            } ?>
                            <?php if ($_SESSION['user_yetki'] == 1) {
                               echo '
                                <li>
                               <a href="evrak_log_tablo.php"><i class="fa fa-laptop"></i> <span class="nav-label">Evrak Log</span></a>
                                </li>';
                            } ?>
                </ul>
    
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Ne Aramak İstersiniz ?" class="form-control"
                                    name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="login.php">
                                <i class="fa fa-sign-out"></i> Çıkış Yap
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Profil</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Ana Sayfa</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Profil</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Kullanıcı Bilgileri </h5>
                            <div class="ibox-tools">
                             
                              
                               
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form class="m-t" role="form"  method="post">
                            <input type="hidden" method="get" name="user_id" value="<?=$satir['user_id']?>">
                                <div class="form-group">
                            <div  class="form-group  row"><label class="col-sm-2 col-form-label">Kullanıcı Adı:</label>

                                <div class="col-sm-10"><input name="kuladi" type="text" class="form-control" value="<?=$satir['user_username']?>" method="post"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div  class="form-group  row"><label class="col-sm-2 col-form-label">Ad:</label>

                                    <div class="col-sm-10"><input name="ad" type="text" class="form-control" value="<?=$satir['user_ad']?>" method="post"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Soyad:</label>
                                    <div class="col-sm-10"><input name="soyad" type="text" class="form-control" value="<?=$satir['user_soyad']?>"method="post"> <span class="form-text m-b-none"></span>
                                    </div>
                                </div>
                                <!-- <div class="hr-line-dashed"></div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label" value="<?=$satir['user_password']?>" method="post">Şİfre:</label>

                                    <div class="col-sm-10"><input name="sifre" type="password" class="form-control" name="password"></div>
                                </div> -->
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Çalıştığı Kurum</label>

                                    <div class="col-sm-10"><input name="kurum" type="text" placeholder="" class="form-control" value="<?=$satir['user_kurum']?>" method="post"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Telefon Numarası:</label>

                                    <div class="col-sm-10"><input name="telefon" type="text" class="form-control" value="<?=$satir['user_telefon']?>" method="post"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                               
                                    <!-- <div class="form-group  row"><label class="col-sm-2 col-form-label">E-mail</label>

                                        <div class="col-sm-10"><input name="email" type="text" class="form-control" value="<?=$satir['user_email']?>" method="post"></div>
                                    </div> -->
                               
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button href="profile.php?ogulcan=1" name="ogulcan" class="btn btn-primary btn-sm" type="submit" method="POST">Bilgileri Güncelle</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Peity -->
    <script src="js/demo/peity-demo.js"></script>

</body>

</html>