<?php
require_once 'baglanti.php'; 
require_once 'log/user_info.php';
$ekle_email= $_SESSION['mail'];
$ekle_username= $_SESSION['kadi'];
$ad = $_SESSION['ad']." ".$_SESSION['soyad'];

if(isset($_GET['verigirdi'])){
    echo '<script type="text/javascript">';
    echo ' alert("Veri Girildi")';  //not showing an alert box.
    echo '</script>';
} 

$sql="SELECT * FROM giris WHERE user_id = ?";
$sorgu=$db->prepare($sql);
$sorgu->execute(array($_GET['user_id']));
$satir=$sorgu->fetch(PDO::FETCH_ASSOC);
            
if (isset($_GET['ekle'])) {

    $eklesorgu="SELECT * FROM evrak WHERE evrak_id = ?";
    $eklelog=$db->prepare($eklesorgu);
    $eklelog->execute(array($_GET['evrak_id']));
    $satirekle=$eklelog->fetch(PDO::FETCH_ASSOC);
    // var_dump($satirekle);
    // exit();

    $logekle =$db->prepare("INSERT INTO logevrak(logevrak_ip,logevrak_username,logevrak_email,logevrak_islem,logevrak_evrak_adi,logevrak_adsoyad) values( 
        :i,
        :ka,
        :em,
        :is,
        :ev,
        :ad)
        ");
        
        $logekle->execute([                
            ':i' => $ip,
            ':ka' => $ekle_username,
            ':em' =>$ekle_email,
            ':is' => "Evrak Eklendi",
            ':ev' => $_POST['adi'],
            ':ad' => $ad
        ]);

	try
	{

        $dosyaal=$_FILES["myFile"];
        $dosyaadi=$dosyaal["name"];
        $dosyatipi=$dosyaal["type"];
        $dosyaboyut=$dosyaal["size"];
        $dosyayeri=$dosyaal["tmp_name"];
        $dosyakayityeri="uploads/".$dosyaadi;
        if (is_uploaded_file($_FILES["myFile"]["tmp_name"])) {
            $tasi = move_uploaded_file($_FILES["myFile"]["tmp_name"],$dosyakayityeri);
            if ($tasi) {
                echo "{$dosyaadi} adlı dosya başarıyla yüklendi";
                echo "Dosya Yüklendi<br>";
                echo "Dosya Adı: $dosyaadi <br>";
                echo "Dosya Türü: $dosyatipi <br>";
                echo "Dosya Boyutu $dosyaboyut <br>";
                $_SESSION['pdfac']=$dosyakayityeri;
                $_SESSION['pdfadi']=$dosyaadi;
               
            }else {
                echo "Dosya Yüklenirken Hata Oluştu";
            }
        }

	$sql='INSERT into evrak(evrak_turu,evrak_adi,evrak_getirenkisi,evrak_alankisi,evrak_metin,evrak_pdf) VALUES(?,?,?,?,?,?)';
	$stmt= $db->prepare($sql);
    $stmt->execute([$_POST['turu'],$_POST['adi'], $_POST['veren'],$_POST['alan'],$_POST['metin'],$_SESSION['pdfadi']]);
    $rs = $db->lastInsertId();


    Header("Location:index.php?verigirdi=1");
	}
	catch(Exception $e)
	{
		var_dump($e->getMessage());

	}
}

$kulid = $_SESSION['kulid']; 
$ad = $_SESSION['ad']." ".$_SESSION['soyad'];
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/Adsiz.png" type="image/x-icon">

    <title>Evrak Yazma</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">
    <link href="css/animate.css" rel="stlesheet">
    <link href="css/style.css" rel="stylesheet">

  <style>
  
  </style>
</head>

<body class="navbar-dark">

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side " role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <img alt="image" class="rounded-circle" src="img/profile_small.jpg" />
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
                                    <li><a class="dropdown-item" href="profile.php?user_id=<?=$kulid?>">Profile</a></li>
                                 
                                </ul>
                            </div>
                            <div class="logo-element">
                                
                            </div>
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-list"></i> <span class="nav-label">Ana Sayfa</span></a>
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

                            <li class="active">
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
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!-- <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form> -->
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="cikis.php?cikis=1">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
              
         
    </div>
    
    
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Evrak Ekleme</h2>

                    <p>
                    Evrak Bilgilerini Girin
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                        <form class="m-t" role="form"  method="post" action="<?= htmlspecialchars('evrak_girme.php?ekle=1');?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input  name="turu" type="text" class="form-control" placeholder="Evrak Türü" required="">
                                </div>
                                <div class="form-group">    
                                    <input name="adi" type="text" class="form-control" placeholder="Evrak Adı" required="">
                                </div>
                                <div class="form-group">
                                    <input name="veren" type="text" class="form-control" placeholder="Evrak Getiren Kişi" required="" value="<?=$satir['user_ad']," ", $satir['user_soyad']?>">
                                </div>
                                <div class="form-group">
                                    <input name="alan" type="text" class="form-control" placeholder="Evrak Alan Kişi" required="">
                                </div>

                                <script src="ckeditor/ckeditor.js"></script>
                                <textarea name="metin" class="ckeditor" id="ckeditor1"></textarea>

                                <div class="form-group">
                                    <input name="evrak_pdf" type="hidden" class="form-control" placeholder="Evrak PDF" required="">
                                </div>

                                <div class="custom-file">
                                <input id="logo" name="myFile" type="file" class="form-control-file">
                                <label for="logo" class="custom-file-label">Dosya Yükleyiniz</label>
                                <br>
                                <button name="ekle" type="submit" class="btn btn-danger block full-width m-b">Evrak Ekle</button>
                                </div>

                            </form>
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

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>

    <!-- SUMMERNOTE -->
    <script src="js/plugins/summernote/summernote-bs4.js"></script>
    

    <script>
        $(document).ready(function(){

            $('.summernote').summernote();

        });

    </script>
</body>

</html>