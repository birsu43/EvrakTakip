<?php

 $dosyaal=$_FILES["myFile"];
 $dosyaadi=$dosyaal["name"];
 $dosyatipi=$dosyaal["type"];
 $dosyaboyut=$dosyaal["size"];
 $dosyayeri=$dosyaal["tmp_name"];
 $dosyakayityeri="uploads/".$dosyaa if (is_uploaded_file($_FILES["myFile"]["tmp_name"])) {
     $tasi = move_uploaded_file($_FILES["myFile"]["tmp_name"],$dosyakayityeri);
     if ($tasi) {
         echo "{$dosyaadi} adlı dosya başarıyla yüklendi";
         echo "Dosya Yüklendi<br>";
         echo "Dosya Adı: $dosyaadi <br>";
         echo "Dosya Türü: $dosyatipi <br>";
         echo "Dosya Boyutu $dosyaboyut <br>";
         echo "<img src='$dosyakayityeri'>";
     }else {
         echo "Dosya Yüklenirken Hata Oluştu";
     }
 }

 
 ?>
 