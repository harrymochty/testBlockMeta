<?php

function block_meta_ips()
{
    $blocked_ips = [
        '31.13.24.0/21',
        '31.13.64.0/18',
        '45.64.40.0/22',
        '66.220.144.0/20',
        '69.63.176.0/20',
        '69.171.224.0/19',
        '74.119.76.0/22',
        '102.132.96.0/19',
        '129.134.0.0/16',
        '157.240.0.0/16',
        '173.252.64.0/18',
        '179.60.192.0/22',
        '185.60.216.0/22',
        '204.15.20.0/22',
        '69.63.176.0/20',
        '69.63.176.0/24',
        '69.63.184.0/21',
        '69.63.176.0/22',
        '69.63.184.0/22',
        '69.171.224.0/19',
        '66.220.144.0/20',
        '66.220.144.0/21',
        '66.220.144.0/22',
        '66.220.144.0/23',
        '66.220.144.0/24',
        '31.13.64.0/18',
        '31.13.64.0/19',
        '31.13.64.0/20',
        '31.13.64.0/21',
        '31.13.64.0/22',
    ];

    $client_ip = $_SERVER['REMOTE_ADDR'];

    foreach ($blocked_ips as $blocked_ip) {
        if (ip_in_range($client_ip, $blocked_ip)) {
            show_error('Access denied', 403);
            exit;
        }
    }
}

function ip_in_range($ip, $range)
{
    if (strpos($range, '/') === false) {
        $range .= '/32';
    }

    list($range, $netmask) = explode('/', $range, 2);
    $range_decimal = ip2long($range);
    $ip_decimal = ip2long($ip);
    $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
    $netmask_decimal = ~$wildcard_decimal;

    return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
}
