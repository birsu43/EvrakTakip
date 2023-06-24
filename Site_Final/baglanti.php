<?php
require_once 'log/user_info.php';
$userinfo = new UserInfo();
$ip = $userinfo->get_ip();
$get_os = $userinfo->get_os();
$get_browser = $userinfo->get_browser();
$get_device = $userinfo->get_device();

session_start();


if(isset($_GET['kullanıcımevcut'])){
    echo '<script>alert("Kullanıcı Mevcut")</script>';
}

if(isset($_GET['sifreuyusmuyor'])){
    echo '<script>alert("Şifreler Uyuşmuyor")</script>';
}
if(isset($_GET['sifreyanlis'])){
    echo '<script>alert("Şifre Yanlış")</script>';
}

try {
    global $db;
	$db = new PDO("pgsql:host=localhost; dbname=postgres","postgres","B@5061873029");
} catch (PDOException $e) {
    echo $e->getMessage();
	echo "$e.Bağlanmadı";
}


//GİRİŞ YAPMA BAŞLANGIÇ

if (isset($_POST['giris'])) {
    $email= $_POST['email'];
    $password= $_POST['password'];
    $password=md5($password);
    $username;
    $usertipi;
    //$password= md5($password);
    if (!$email) {
        echo "Kullanıcı Adı Giriniz";
    } elseif (!$password) {
        echo "Şifre Giriniz";
    } else {
        echo($password);
        echo($ip);
        
        $kullanici_sor=$db->prepare('SELECT * FROM giris WHERE user_email=:mail and user_password=:sifre' );
            $sonuc =  $kullanici_sor->execute(array(':mail' => $email, ':sifre'=>$password));
            $sonuc = $kullanici_sor->fetchAll();

            //LOG KAYDI BAŞLANGIÇ
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $mail= $_POST['email'];
        $sifre= $_POST['password']; 
        $sifre=md5($sifre);   

        $girisyap =$db->prepare("SELECT * FROM giris WHERE user_email=:m and user_password=:p");
        $girisyap->execute([':m'=>$mail,':p'=>$sifre]);
        if ($girisyap->rowCount()) {
            $row = $girisyap->fetch(PDO::FETCH_OBJ);
            $_SESSION['oturum'] = true;
            $_SESSION['kulid'] = $row->user_id;
            $_SESSION['mail'] = $row->user_email;
            $_SESSION['kadi'] = $row->user_username;
            $_SESSION['ad'] = $row->user_ad;
            $_SESSION['soyad'] = $row->user_soyad;

            $logekle =$db->prepare("INSERT INTO log(ip,kullanici_adi,kullanici_email,durum,cihaz,isletim_sistemi,tarayici) values( 
            :i,
            :ka,
            :em,
            :d,
            :c,
            :is,
            :t)
            ");
            
            $logekle->execute([                
                ':i' => $ip,
                ':ka' => $row->user_username,
                ':em' =>$row->user_email,
                ':d' => "Giriş Yaptı",
                ':c' => $get_device,
                ':is' => $get_os,
                ':t' => $get_browser
            ]);
        }  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //LOG KAYDI BİTİŞ

            
        echo $say= count($sonuc);
        if ($say==1) {
            $_SESSION['user'] = $sonuc[0]['user_username'];
            $_SESSION['email']=$email;
            $_SESSION['user_yetki']=$sonuc[0]['user_tipi'];

            echo '<pre>'.print_r($sonuc,true).'</pre>';
            //exit();
            if ($sonuc[0]['user_tipi']==1) {

                Header('Location:index.php?admingiris=1');
                exit();
                //echo "Başarıyla giriş yaptınız, yönlendiriliyorsunuz.";
            }
            else{
                  Header('Location:index.php?usergiris=1');
            }
      
            // echo "Başarıyla Giriş yaptınız, Yönlendiriliyorsunuz.";
            // Header('Location:index.php');
            // exit();
            
        }else {
            Header('Location:login.php?sifreyanlis=1');
        }
    }
}

//GİRİŞ YAPMA BİTİŞ

//KAYIT GİRİŞ

 if (isset($_POST['kayit']))
{
   $username= strip_tags($_POST['username']);
   $email= strip_tags($_POST['email']);     
   $password= strip_tags($_POST['password']);
   $password=md5($password);
   $password_again= strip_tags($_POST['sifretekrar']);
   $password_again=md5($password_again);
   
      if ($username!="" and $email!="" and $password!="" and $password_again!="")
      {    
      	if ($password==$password_again)
         {
      	$c=$db->prepare('SELECT * FROM giris WHERE user_username=:uname and user_email=:mail and user_password=:sifre');
        //->rowCount();
        $c ->execute(array(':uname'=>$username,':mail'=>$email,':sifre'=>$password));
        $rs = $c->fetchAll();
        
      	if (count($rs) == 0) 
      	{
            $sql='INSERT into giris(user_username,user_email,user_password) VALUES(?,?,?)';
            $stmt= $db->prepare($sql);
            $stmt->execute([$username,$email,$password]); 
            $id = $db->lastInsertId();

            if($db->prepare("UPDATE giris set user_password='".$password."'where user_email='".$email."'"))
      		{
      			Header("Location:login.php?girisbasarili=1");
                 exit();
      		}
      	}
        else{
            Header("Location:register.php?kullanıcımevcut=1");
            exit;
        }

      }
          else
         {
      	      Header("Location:register.php?sifreuyusmuyor=1");
		         exit;
         }
   }
      }
//Kayıt Bitiş


?>
