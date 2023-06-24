<?php
require_once 'baglanti.php';
require_once 'log_sorgu.php';
function tarihformat($tarih, $format)
{
    //Format 1: 2019-01-01 türünü 01/01/2019 türüne dönüştürür.
    if ($format == 1) {
        return implode('/', array_reverse(explode('-', $tarih)));
    } //Format 2: 01/04/2019 türünü 2019-04-01 türüne dönüştürür. (DatePicker 'dan geleni Veritabanına Yazmak İçin)
    else if ($format == 2) {
        return implode('-', array_reverse(explode('/', $tarih)));
    } else if ($format == 3) {
        return date("Y-m-d", strtotime($tarih));
    } else if ($format == 4) {
        return date("d/m/Y", strtotime($tarih));
    } else if ($format == 5) {
        return implode('.', array_reverse(explode('-', $tarih)));
    } else if ($format == 0) {
        return date("Y-m-d h:i", strtotime($tarih));        // $tarih = now
    } else if ($format == 6) {
        return date("d/m/Y H:i", strtotime($tarih));
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

    <title>Log Tablosu</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    

    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <style>
        .deneme{
            text-align: center;
        }
    </style>
</head>

<body>

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
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
                                    <!-- <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> -->
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
                                IN+
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

                            <li>
                                <a href="evrak_girme.php?user_id=<?=$kulid?>"><i class="fa fa-edit"></i> <span class="nav-label">Evrak Yazma</span></a>
                            </li>
                            <?php if ($_SESSION['user_yetki'] == 1) {
                               echo '
                                <li class="active">
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
        </div>
        <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="cikis.php?cikis=1">
                        <i class="fa fa-sign-out"></i> Çıkış Yap
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Tables</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Tables</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data Tables</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Giriş Çıkış Log Kayıtları</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                            <th>ID <i class="fa fa-sort"></i></th>
                            <th>Tarih<i class="fa fa-sort"></i></th>
                            <th>Kullanıcı Adı <i class="fa fa-sort"></i></th>
                            <th>IP <i class="fa fa-sort"></i></th>
                            <th>E-mail<i class="fa fa-sort"></i></th>
                            <th>Cihaz <i class="fa fa-sort"></i></th>
                            <th>İşletim Sistemi <i class="fa fa-sort"></i></th>
                            <th>Tarayıcı <i class="fa fa-sort"></i></th>
                            <th>İşlem <i class="fa fa-sort"></i></th>
                            </tr>
                    </thead>
                    <tbody>
                            <?php
                            foreach($logsorgu as $logbilgi){?>
                            <tr>
                                <td class="deneme"><?=$logbilgi->id?></td>
                                <td class="deneme"><?=tarihformat($logbilgi->tarih,6)?></td>
                                <td class="deneme"><?=$logbilgi->kullanici_adi?></td>
                                <td class="deneme"><?=$logbilgi->ip?></td>
                                <td class="deneme"><?=$logbilgi->kullanici_email?></td>
                                <td class="deneme"><?=$logbilgi->cihaz?></td>
                                <td class="deneme"><?=$logbilgi->isletim_sistemi?></td>
                                <td class="deneme"><?=$logbilgi->tarayici?></td>
                                <td class="deneme"><?=$logbilgi->durum?></td>              
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                        </div>

                    </div>
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

    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>

</body>

</html>
