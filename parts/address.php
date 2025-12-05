<?php
function getAreaFromPostalCode($postalCode) {
    $addressNum = intval(substr($postalCode, 0, 2));
    $area = 'その他';

    if ($addressNum == 0 || ($addressNum >= 4 && $addressNum <= 9)) {
        $area = '北海道';
    } elseif (($addressNum >= 1 && $addressNum <= 3) || ($addressNum >=96 && $addressNum <= 99)) {
        $area = '東北';
    } elseif ($addressNum >= 10 && $addressNum <= 37) {
        $area = '関東';
    } elseif (($addressNum >= 38 && $addressNum <= 50) || ($addressNum >= 91 && $addressNum <= 95)) {
        $area = '中部';
    } elseif ($addressNum >= 51 && $addressNum <= 67) {
        $area = '近畿';
    } elseif ($addressNum >= 68 && $addressNum <= 75) {
        $area = '中国';
    } elseif ($addressNum >= 76 && $addressNum <= 79) {
        $area = '四国';
    } elseif ($addressNum >= 80 && $addressNum <= 90) {
        $area = '九州・沖縄';
    }
    return $area;
}
?>