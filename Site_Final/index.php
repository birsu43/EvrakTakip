<?php
require_once 'baglanti.php';
require_once 'evrak_listele.php';
require_once 'evrak_silme.php';



if (empty($_SESSION['email'])) {
    header("location:login.php");
    exit;
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

$kulid = $_SESSION['kulid']; 
$ad = $_SESSION['ad']." ".$_SESSION['soyad'];
//echo '<pre>'.print_r($_SESSION,true).'</pre>';
require 'index_user.php';
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="uploads/Adsiz.png" type="image/x-icon">

    <title>Ana Sayfa</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    



</head>

<body >

        <!-- Kişi PopUp Bitiş -->



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
    <!-- Tablo Script Başlangıç -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 26,
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
    <!-- Tablo Script Bitiş -->
    <!-- Veri Görme Script Başlangıç -->
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
    <!-- Veri Görme Script Bitiş -->
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

</body>

</html>
