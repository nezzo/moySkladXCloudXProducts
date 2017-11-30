<?php
//отправляем со стороны клиента данные

$a = 'HelloS';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/3.php');

curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POST,'POST');
curl_setopt($ch,CURLOPT_POSTFIELDS, 'text='.$a);
curl_setopt($ch,CURLOPT_HTTPHEADER,array(
'Content-Type: application/x-www-form-urlencoded',
));
$res = curl_exec($ch);

var_dump($res);
curl_close($ch);