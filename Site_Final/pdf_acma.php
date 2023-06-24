<?php
//require_once "result.php";

session_start();
//$file1 = $_SESSION["pdfac"];
//echo __DIR__;
//exit();
//var_dump($_GET['pdfac']);
//set_include_path('uploads/');

//exit();
if(isset($_GET['pdfac'])){
   
    header('Content-type:application/pdf');
    header('Content-Description:inline;filename="'.$_GET['pdfac'].'"');
    header('Content-Transfer-Encoding:binary');
    header('Accept-Ranges:bytes');
   // @readfile($_GET['pdfac']);
   echo file_get_contents('uploads/'.$_GET['pdfac']);
}
//var_dump($file1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>