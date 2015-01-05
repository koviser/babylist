<?php
$name = $_POST["name"];
$phone = $_POST["phone"];
$hidde = $_POST["hidde"];

$to = "stailerbabyliss.ru@bk.ru";
$subject = "Новая заявка";
$message = "Форма: $hidde\n\nИмя: $name\nТелефон: $phone";
mail ($to,$subject,$message,"Content-type:text/plain; charset = utf-8") or print "Не могу отправить письмо !!!";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>С вами свяжутся</title>
<meta name="generator">
<style type="text/css">
body
{
   
   background-color: #fff;
   
}
</style>
<script type="text/javascript">
setTimeout('location.replace("index.htm")', 4000);
</script> 
</head>
<body>


<div style="font-family: Arial, sans-serif; text-align: center; font-size: 40px; font-weight: bold; color: #020b11; margin-top: 150px;">Спасибо за вашу заявку! <br>Мы скоро с вами свяжемся</div>
</body>
</html>