<?php
$code = 1;$error = true;$name_input = array();

if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
$EMAIL = 'stailerbabyliss.ru@bk.ru'; //  Ваш e-mail на который будут приходить заявки
$FROM = 'stailerbabyliss.ru@bk.ru';  //  e-mail отправителя (иногда требуется указать разрешенный настройками e-mail)
$REPLY = 'noreplay@mail.ru';   //  e-mail для ответа
$PRIORITY = false;       //  пометить как важное

if(isset($_POST["name"])){

  $name = $_POST["name"];
  $tel = preg_replace('/[^0-9]/', '', trim($_POST["phone"]));

  date_default_timezone_set('Europe/Moscow');
  $time = date("H:i d.m.Y");

  if (getenv('HTTP_CLIENT_IP')) {$ip = getenv('HTTP_CLIENT_IP');}
  elseif (getenv('HTTP_X_FORWARDED_FOR')) {$ip = getenv('HTTP_X_FORWARDED_FOR');}
  elseif (getenv('HTTP_X_FORWARDED')) {$ip = getenv('HTTP_X_FORWARDED');}
  elseif (getenv('HTTP_FORWARDED_FOR')) {$ip = getenv('HTTP_FORWARDED_FOR');}
  elseif (getenv('HTTP_FORWARDED')) {$ip = getenv('HTTP_FORWARDED');}
  else {$ip = $_SERVER['REMOTE_ADDR'];}

  if($name == '' or strlen($name) < 2 or strlen($name) > 50){$name_input[] = 'name'; $error = false;}
  if($tel == '' or strlen($tel) < 5 or strlen($tel) > 50){$name_input[] = 'phone'; $error = false;}

  if($error){

    $subject = 'Новая заявка'; //Тема письма
    $message .= '<div><b>Время заявки:</b> '.stripinput($time).'</div>';
    $message .= '<div><b>IP:</b> '.stripinput($ip).'</div>';
    $message .= '<div><b>Имя:</b> '.stripinput($name).'</div>';
    $message .= '<div><b>Телефон:</b> '.stripinput($tel).'</div>';

    sendmail($subject, render($message),$EMAIL,$FROM,$REPLY);

    $code = 0;
  }
}
}
$data_str = array('code' => $code, 'input' => $name_input);
echo json_encode($data_str);

function stripinput($_sText) {
	if (ini_get('magic_quotes_gpc')) $_sText = stripslashes($_sText);
	$search = array("\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
	$replace = array("&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
	$_sText = str_replace($search, $replace, $_sText);
	return $_sText;
}
function sendmail($_sSubject, $_sMessage, $_sEmail, $_sFrom, $_sReply, $_bPriority=false){
	$subject = "=?utf-8?b?" . base64_encode($_sSubject) . "?=";
	$headers  = "From: $_sFrom\r\n";
	$headers .= "Reply-To: $_sReply\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
    if($_bPriority){
        $headers .= "X-Priority: 1 (Highest)\n";
        $headers .= "X-MSMail-Priority: High\n";
        $headers .= "Importance: High\n";
    }
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	return mail($_sEmail, $subject, $_sMessage, $headers);
}
function render($_sBody){
    return '<html>
<head>
<style type="text/css">
body {margin:10px;background:#ffffff;color:#000000;font-size:10pt;font-family:Tahoma}
div {font-size:10pt;font-family:Tahoma}
.header {padding-bottom:20px}
a {color: #003399!important;text-decoration:underline;}
</style>
</head>
<body>
<div class="body">
'.$_sBody.'
</div>
</body>
</html>';
}
?>