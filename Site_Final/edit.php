<?php
require_once "baglanti.php";
 
?>

<?php
    if(isset($_POST['buttonGunVeri'])){

        $sql="SELECT * FROM evrak WHERE evrak_id = ".$_POST["id"];
       $sorgu=$db->prepare($sql);
       $sorgu->execute();
       $satir=$sorgu->fetch(PDO::FETCH_ASSOC);
       
       // var_dump($satir);
       // exit();
        echo json_encode($satir ,256);
       }




    if (isset($_POST['button-ID'])) {
        
        $id=$_POST['id'];
        $evrak_adi=$_POST['guncelle_adi'];
        $evrak_turu=$_POST['guncelle_turu'];
        $evrak_getirenkisi= $_POST['guncelle_getirenkisi'];
        $evrak_alankisi=$_POST['guncelle_alankisi'];
        $evrak_metin=$_POST['guncelle_metin'];

    $sql="UPDATE evrak SET evrak_adi='$evrak_adi',evrak_turu='$evrak_turu',evrak_getirenkisi= '$evrak_getirenkisi',evrak_alankisi= '$evrak_alankisi',evrak_metin= '$evrak_metin' WHERE evrak_id='$id'";

    $stmt= $db->prepare($sql);



    $stmt->execute();


    echo json_encode('basari');
    exit();

        if ($stmt) {  

            if ($sorgu==1) {
            //echo "kayıt başarılı";
            Header("Location:index.php?durum=ok&id=$id");
            exit;
    
        }else{
            //echo "kayıt başarılı";
            Header("Location:index.php?durum=ok&id=$id");
            exit;        
        }
    } else {
    
            //echo "kayıt başarısız";
            Header("Location:edit.php?durumno&id=$id");
            exit;
        }  
    }





    
 ?>
