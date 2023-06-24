<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mt-3 mg-light">
                <div class="card-body">
                    <?php

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
                            echo "<img src='$dosyakayityeri'>";
                            $_SESSION['pdfac']=$dosyakayityeri;
                           
                            Header('Location:pdf_acma.php?pdfac='.$dosyaadi);
                            exit();
                        }else {
                            echo "Dosya Yüklenirken Hata Oluştu";
                        }
                    }
                    ?>
                    <pre>
                        <?php print_r($dosyaal); ?>
                    </pre>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>