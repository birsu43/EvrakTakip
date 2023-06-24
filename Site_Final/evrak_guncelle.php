<?php
require_once 'baglanti.php'; 
require_once 'log/user_info.php';
$guncelle_email= $_SESSION['mail'];
$guncelle_username= $_SESSION['kadi'];
$ad = $_SESSION['ad']." ".$_SESSION['soyad'];

if (isset($_POST['guncelle'])) {

    try {$dosyaal=$_FILES["myFile"];
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
                $_SESSION['pdfac2']=$dosyakayityeri;
                $_SESSION['pdfadi2']=$dosyaadi;
               
            }else {
                echo "Dosya Yüklenirken Hata Oluştu";
            }
        }

    $sqlguncelle="UPDATE evrak SET evrak_turu = ?, evrak_adi = ?, evrak_getirenkisi = ?, evrak_alankisi = ?, evrak_metin =?, evrak_pdf=? WHERE evrak.evrak_id=?";
    $dizi=[
        $_POST['turu'],
        $_POST['adi'],
        $_POST['veren'],
        $_POST['alan'],
        $_POST['metin'],
        $_SESSION['pdfadi2']
       

    ];

    $sorgu=$db->prepare($sqlguncelle);
    $sorgu->execute($dizi);

   

    header("Location:index.php");
    } catch (\Throwable $th) {
        //throw $th;
    }

    $guncellesorgu="SELECT * FROM evrak WHERE evrak_id = ?";
    $guncellelog=$db->prepare($guncellesorgu);
    $guncellelog->execute(array($_GET['evrak_id']));
    $satirguncelle=$guncellelog->fetch(PDO::FETCH_ASSOC);
    // var_dump($satirguncelle);
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
            ':ka' => $guncelle_username,
            ':em' =>$guncelle_email,
            ':is' => "Evrak Güncellendi",
            ':ev' => $satir['evrak_adi'],
            ':ad' => $ad
        ]);

}

$sql="SELECT * FROM evrak WHERE evrak_id = ?";
$sorgu=$db->prepare($sql);
$sorgu->execute(array($_GET['evrak_id']));
$satir=$sorgu->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Evrak Güncelle</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Evrak Güncelleme</h2>

                    <p>
                    Evrak Bilgilerini Girin
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form"  method="post">
                                <input type="hidden" name="evrak_id" value="<?=$satir['evrak_id']?>">
                                <div class="form-group">
                                    <input  name="turu" type="text" class="form-control" placeholder="Evrak Türü" required="" method="POST" value="<?=$satir['evrak_turu']?>">
                                </div>
                                <div class="form-group">    
                                    <input name="adi" type="text" class="form-control" placeholder="Evrak Adı" required="" method="POST" value="<?=$satir['evrak_adi']?>">
                                </div>
                                <div class="form-group">
                                    <input name="veren" type="text" class="form-control" placeholder="Evrak Getiren Kişi" required="" method="POST" value="<?=$satir['evrak_getirenkisi']?>">
                                </div>
                                <div class="form-group">
                                    <input name="alan" type="text" class="form-control" placeholder="Evrak Alan Kişi" required="" method="POST" value="<?=$satir['evrak_alankisi']?>">
                                </div>

                                <div>
                                    <script src="ckeditor/ckeditor.js"></script>
                                    <textarea name="metin" class="ckeditor" id="ckeditor1"><?=$satir["evrak_metin"] ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <input name="evrak_pdf" type="hidden" class="form-control" placeholder="Evrak PDF" required="">
                                </div>

                                <div class="form-group">
                                    <input type="file" class="form-control-file" name="myFile">
                                </div>

                                <button name="guncelle"  type="submit" class="btn btn-danger block full-width m-b">Evrak Güncelle</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>