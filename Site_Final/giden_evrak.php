<?php
require_once 'baglanti.php';
require_once 'evrak_listele.php';
require_once 'evrak_silme.php';
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
$referer = $_SERVER['HTTP_REFERER']; 

if ($referer == "") 
{ 
echo "Önce Giriş Yapmalısınız"; 
} 

else 
{ }


$sorgu=$db->prepare('SELECT * FROM evrak where evrak_getirenkisi = ?');
$sorgu->execute(array($_GET['evrak_getirenkisi']));
$personellist=$sorgu->fetchAll(PDO::FETCH_OBJ);

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

//echo '<pre>'.print_r($_SESSION,true).'</pre>';

$kulid = $_SESSION['kulid']; 
$ad = $_SESSION['ad']." ".$_SESSION['soyad'];
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/Adsiz.png" type="image/x-icon">

    <title>Giden Evraklar</title>

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
                                <li class="active">
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
            
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Bütün Evraklar</h5>
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
                            <th>Evrak No <i class="fa fa-sort"></i></th>
                            <th>Evrak Türü <i class="fa fa-sort"></i></th>
                            <th>Evrak Adı <i class="fa fa-sort"></i></th>
                            <th>Evrak Tarihi <i class="fa fa-sort"></i></th>
                            <th>Gönderen Kişi <i class="fa fa-sort"></i></th>
                            <th>Alan Kişi <i class="fa fa-sort"></i></th>
                            <th>Evrak PDF <i class="fa fa-sort"></i></th>
                            <th>İşlemler </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($personellist as $person){?>
                            <tr>
                                <td class="deneme"><?=$person->evrak_id?></td>
                                <td class="deneme"><?=$person->evrak_no?></td>
                                <td class="deneme"><?=$person->evrak_turu?></td>
                                <td class="deneme"><?=$person->evrak_adi?></td>
                                <td class="deneme"><?=tarihformat($person->evrak_gelistarih,6)?></td>

                                <td class="deneme"><?=$person->evrak_getirenkisi?>
                                <br>
                                <button type="button" class="btn  edit" data-toggle="modal" data-target="#myModalKisi"
                                data-veren="<?php echo $person->evrak_getirenkisi ?>">
                                <img src="uploads/view.svg" alt="view" width="20" height="15">
                                </button>
                                </td>

                                <td class="deneme"><?=$person->evrak_alankisi?>
                                <br>
                                <button type="button" class="btn  edit" data-toggle="modal" data-target="#myModalKisi"
                                data-alan="<?php echo $person->evrak_alankisi ?>">
                                <img src="uploads/view.svg" alt="view" width="20" height="15">
                                </button>
                                </td>

                               <?php
                               $pdfadi=$person->evrak_pdf;
                               
                               if ($person->evrak_pdf!="") {
                                echo '<td class="deneme">                                
                                '.$person->evrak_pdf.'<br>
                                <a href="pdf_acma.php?pdfac='.$person->evrak_pdf.'" class="edit" title="Edit" data-toggle="tooltip"><img src="uploads/view.svg" alt="view" width="20" height="15"></a>
                                </td>';
                               }else {
                                echo '<td class="deneme">PDF Yüklenmemiş</td>';
                               }?>
                                <td class="deneme">                                
                             
                             <button type="button" class="btn edit" data-toggle="modal" data-target="#myModal5"
                             data-id="<?php echo $person->evrak_id ?>">
                             <img src="uploads/view.svg" alt="view" width="20" height="15">
                             </button> 

                             <div class="col-sm-4">                                 
                             <button data-target="#modalguncelle" data-id="<?php echo $person->evrak_id ?>" class="btn guncelle" data-toggle="modal">
                             <img src="uploads/edit_mavi.svg" alt="view" width="20" height="15"></a>
                             </div>

                             <a href="?evrak_id=<?=$person->evrak_id?>" onclick="return confirm('Silmek İstediğinize Emin Misiniz ?')" class="delete" title="Delete" data-toggle="tooltip"><img src="uploads/sil_kirmizi.svg" alt="view" width="20" height="15"></a>
                             </td>                                             
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
                <!-- Evrak Gösterme PopUp Başlangıç -->
<div id="wrapper"> 
    <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Evrak Detayları</h4>
                        <small class="font-bold"></small>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ibox-content">
                
                                    <h2 class="font-bold"></h2>
                
                                    <p>
                                    Evrak Bilgilerini Girin
                                    </p>
                
                                    <div class="row">
                
                                        <div class="col-lg-12">
                                            <form class="m-t" role="form"  method="post">
                                            <input type="hidden" id="popup_id" name="evrak_id" value="">
                                                <div class="form-group">
                                                    <input id="popup_turu"  name="evrak_turu" type="text" class="form-control" method="POST" placeholder="Evrak Türü" required value="">
                                                </div>
                                                <div class="form-group">    
                                                    <input id="popup_adi" name="evrak_adi" type="text" class="form-control" method="POST" placeholder="Evrak Adı" required value="">
                                                </div>
                                                <div class="form-group">
                                                    <input id="popup_getirenkisi" name="evrak_getirenkisi" type="text" class="form-control" method="POST" placeholder="Evrak Getiren Kişi" required value="">
                                                </div>
                                                <div class="form-group">
                                                    <input id="popup_alankisi" name="evrak_alankisi" type="text" class="form-control" method="POST" placeholder="Evrak Alan Kişi" required value="">
                                                </div>
                                                <div>
                                               
                                                <textarea class="ckeditor" name="popup_metin" id="popup_metin"></textarea>
                                                </div>

                
                                                <button id="popguncelle" name="popupguncelle" type="submit" class="btn btn-danger block full-width m-b">Evrak Güncelle</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>                                 
    </div>   
    </div>
</div>
        <!-- Evrak Gösterme PopUp Bitiş -->
        <!-- Kişi PopUp Başlangıç -->
<div id="wrapper"> 
    <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="modal inmodal fade" id="myModalKisi" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Kişi Bilgileri</h4>
                        <small class="font-bold"></small>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ibox-content">
                
                                    <h2 class="font-bold"></h2>
                
                                    <div class="row">
                
                                        <div class="col-lg-12">
                                            <form class="m-t" role="form"  method="post">
                                            <input type="hidden" id="kisi_popup_id" name="kisi_id" value="">
                                                <div class="form-group">
                                                    <input id="kisi_popup_ad"  name="kisi_ad" type="text" class="form-control" method="POST" placeholder="Evrak Türü" required value="">
                                                </div>
                                                <div class="form-group">    
                                                    <input id="kisi_popup_soyad" name="kisi_soyad" type="text" class="form-control" method="POST" placeholder="Evrak Adı" required value="">
                                                </div>
                                                <div class="form-group">
                                                    <input id="kisi_popup_telefon" name="kisi_telefon" type="text" class="form-control" method="POST" placeholder="Evrak Getiren Kişi" required value="">
                                                </div>
                                                <div class="form-group">
                                                    <input id="kisi_popup_email" name="kisi_email" type="text" class="form-control" method="POST" placeholder="Evrak Getiren Kişi" required value="">
                                                </div>
                                                <div class="form-group">
                                                    <input id="kisi_popup_kurum" name="kisi_kurum" type="text" class="form-control" method="POST" placeholder="Evrak Alan Kişi" required value="">
                                                </div>
                                              
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                                 
    </div>   
    </div>
</div>
        <!-- Kişi PopUp Bitiş -->
        <!-- Güncelleme PopUp Başlangıç-->
<div id="wrapper"> 
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="modal inmodal fade" id="modalguncelle" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Evrak Güncelleme</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ibox-content">
                               
                                        <h2 class="font-bold"></h2>
                               
                                        <p>
                                        Evrak Bilgilerini Girin
                                        </p>
                               
                                        <div class="row">
                               
                                            <div class="col-lg-12">
                                                <form class="m-t" role="form"  method="post">
                                                <input type="hidden" id="guncelle_id" name="evrak_id" value="">
                                                    <div class="form-group">
                                                        <input id="guncelle_turu"  name="evrak_turu" type="text" class="form-control" method="POST" placeholder="Evrak Türü" required value="">
                                                    </div>
                                                    <div class="form-group">    
                                                        <input id="guncelle_adi" name="evrak_adi" type="text" class="form-control" method="POST" placeholder="Evrak Adı" required value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="guncelle_getirenkisi" name="evrak_getirenkisi" type="text" class="form-control" method="POST" placeholder="Evrak Getiren Kişi" required value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="guncelle_alankisi" name="evrak_alankisi" type="text" class="form-control" method="POST" placeholder="Evrak Alan Kişi" required value="">
                                                    </div>
                                                    <div>

                                                    <textarea class="ckeditor" name="guncelle_metin" id="guncelle_metin"></textarea>
                                                    </div>

                               
                                                    <button data-button-id="<?php echo $person->evrak_id ?>" type="button" class="btn btn-primary block full-width m-b">Evrak Güncelle</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                                 
        </div>   
    </div>
</div>
        <!-- Güncelleme PopUp Bitiş-->

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    
    <script src="ckeditor/ckeditor.js"></script>

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

    <script>
        $(document).ready(function(){
            $('body').on('click',"[data-id]",function(event){
                let rowId = $(this).data('id');

            $.ajax({
            url:"ajaxacevapver.php",
            method:"POST",
            data:{id:rowId,'buttonID':true},
            dataType:"JSON",
            success:function(data){   
     
            $('#popup_id').val(data.evrak_id);
            $('#popup_turu').val(data.evrak_turu);
            $('#popup_adi').val(data.evrak_adi);
            $('#popup_getirenkisi').val(data.evrak_getirenkisi);
            $('#popup_alankisi').val(data.evrak_alankisi);

            var editor = CKEDITOR.instances["popup_metin"];
            editor.setData(data.evrak_metin);
                }
            });
        });
        });
    </script>
    <!-- Alan Kişi Görme Script Başlangıç -->
    <script>
        $(document).ready(function(){
            $('body').on('click',"[data-alan]",function(event){
                let rowAlan = $(this).data('alan');

            $.ajax({
            url:"ajaxacevapver.php",
            method:"POST",
            data:{alan:rowAlan,'buttonKisi':true},
            dataType:"JSON",
            success:function(data){   
     
            $('#kisi_popup_ad').val(data.user_ad);
            $('#kisi_popup_soyad').val(data.user_soyad);
            $('#kisi_popup_telefon').val(data.user_telefon);
            $('#kisi_popup_email').val(data.user_email);
            $('#kisi_popup_kurum').val(data.user_kurum);
                    }
                });
            });
        });
    </script>
    <!-- Alan Kişi Görme Script Bitiş -->
    <!-- Veren Kişi Görme Script Başlangıç -->
    <script>
        $(document).ready(function(){
            $('body').on('click',"[data-veren]",function(event){
                let rowveren = $(this).data('veren');

            $.ajax({
            url:"ajaxacevapver.php",
            method:"POST",
            data:{veren:rowveren,'buttonVeren':true},
            dataType:"JSON",
            success:function(data){   
     
            $('#kisi_popup_ad').val(data.user_ad);
            $('#kisi_popup_soyad').val(data.user_soyad);
            $('#kisi_popup_telefon').val(data.user_telefon);
            $('#kisi_popup_email').val(data.user_email);
            $('#kisi_popup_kurum').val(data.user_kurum);
                    }
                });
            });
        });
    </script>
    <!-- Veren Kişi Görme Script Bitiş -->
    <!-- Veri Güncelleme Script Başlangıç -->
    <script>
        $(document).ready(function(){
            $('body').on('click',"[data-button-id]",function(event){ 
                const  guncelle_id=  $('#guncelle_id').val();
                var  guncelle_turu=  $('#guncelle_turu').val();
                var  guncelle_adi=  $('#guncelle_adi').val();
                var  guncelle_getirenkisi=  $('#guncelle_getirenkisi').val();
                var  guncelle_alankisi=  $('#guncelle_alankisi').val();
                var  guncelle_metin=  $('#guncelle_metin').val();
            $.ajax({
                url:"edit.php",
                method:"POST",
                data:{
                id:guncelle_id,
                'button-ID':true,
                guncelle_turu:guncelle_turu,
                guncelle_adi:guncelle_adi,
                guncelle_getirenkisi:guncelle_getirenkisi,
                guncelle_alankisi:guncelle_alankisi,
                guncelle_metin:guncelle_metin
                },
                dataType:"JSON",
                success:function(rs){
                    if(rs=='basari'){
                        alert('Kayıt Başarılı');
                        window.location.reload();
                    }
                }
            })
        });

            $('body').on('click',"[data-id]",function(event){
                let rowId = $(this).data('id');

            $.ajax({
            url:"edit.php",
            method:"POST",
            data:{id:rowId,'buttonGunVeri':true},
            dataType:"JSON",
            success:function(data){   
     
            $('#guncelle_id').val(data.evrak_id);
            $('#guncelle_turu').val(data.evrak_turu);
            $('#guncelle_adi').val(data.evrak_adi);
            $('#guncelle_getirenkisi').val(data.evrak_getirenkisi);
            $('#guncelle_alankisi').val(data.evrak_alankisi);

            var editor = CKEDITOR.instances["guncelle_metin"];
            editor.setData(data.evrak_metin);
                        }
                    });
                });
            });
    </script>
    <!-- Veri Güncelleme Script Bitiş -->
    

</body>

</html>
