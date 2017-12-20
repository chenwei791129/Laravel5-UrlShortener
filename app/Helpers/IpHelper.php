<?php

function getClientIp()
{
    $client_ip = [];
    if(isset($_SERVER['HTTP_CLIENT_IP'])) $client_ip['HTTP_CLIENT_IP'] = $_SERVER['HTTP_CLIENT_IP'];
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $client_ip['HTTP_X_FORWARDED_FOR'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    if(isset($_SERVER['HTTP_X_FORWARDED'])) $client_ip['HTTP_X_FORWARDED'] = $_SERVER['HTTP_X_FORWARDED'];
    if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) $client_ip['HTTP_X_CLUSTER_CLIENT_IP'] = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if(isset($_SERVER['HTTP_FORWARDED_FOR'])) $client_ip['HTTP_FORWARDED_FOR'] = $_SERVER['HTTP_FORWARDED_FOR'];
    if(isset($_SERVER['HTTP_FORWARDED'])) $client_ip['HTTP_FORWARDED'] = $_SERVER['HTTP_FORWARDED'];
    if(isset($_SERVER['REMOTE_ADDR'])) $client_ip['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR']; //(真實 IP 或是 Proxy IP)
    if(isset($_SERVER['HTTP_VIA'])) $client_ip['HTTP_VIA'] = $_SERVER['HTTP_VIA']; //(參考經過的 Proxy) 
    return $client_ip;
}