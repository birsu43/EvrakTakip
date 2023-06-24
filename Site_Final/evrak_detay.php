<?php

require_once 'baglanti.php';

$sql="SELECT * FROM evrak WHERE evrak_id = ?";
$sorgu=$db->prepare($sql);
$sorgu->execute(array($_GET['evrak_id']));
$satir=$sorgu->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><strong>ID</strong></td>
                            <td><strong>EVRAK NO</strong></td>
                            <td><strong>EVRAK TÜRÜ</strong></td>
                            <td><strong>EVRAK ADI</strong></td>
                            <td><strong>EVRAK TARİHİ</strong></td>
                            <td><strong>GETİREN KİŞİ</strong></td>
                            <td><strong>ALAN KİŞİ</strong></td>
                            <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                        </tr>

                        <tr>
                            <td><?=$satir["evrak_id"] ?></td>
                            <td><?=$satir["evrak_no"] ?></td>
                            <td><?=$satir["evrak_turu"] ?></td>
                            <td><?=$satir["evrak_adi"] ?></td>
                            <td><?=$satir["evrak_gelistarih"] ?></td>
                            <td><?=$satir["evrak_getirenkisi"] ?></td>
                            <td><?=$satir["evrak_alankisi"] ?></td>
                            <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                        </tr>
                    </tbody>
                </table>

                <div>
                <script src="ckeditor/ckeditor.js"></script>
                <textarea name="metin" class="ckeditor" id="ckeditor1"><?=$satir["evrak_metin"] ?></textarea>
                </div>

            </div>
        </div>
    </div>

</body>
</html>