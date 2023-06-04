<?php

include 'connect.php';
include 'tokenGen.php';
require_once __DIR__ . '/phpqrcode/qrlib.php';
//QRcode::png('PHP QR Code :)');

$request = trim($_GET['cut_link']);
$request = mysqli_real_escape_string($conn, $request);

if (array_key_exists('submit',$_GET)) {
    $_GET['file'] ='qr_code/qr.png';
    QRcode::png($_GET['cut_link'], $_GET['file'], 'H', 4);
}

if (strpos($_GET['cut_link'], $_SERVER['SERVER_NAME']) !==false) {
    $bool_link = true;
} else {
    $bool_link = false;
}

if (!empty($_GET['cut_link']) && $bool_link == false) {
    $search_bool  = false;
    $token = '';

    $sel = mysqli_query($conn, "SELECT * FROM `links` WHERE `link` = '".$request."'");

    //проверка на наличие введенной ссылки в БД
    if (empty(mysqli_num_rows($sel))) {
        //если ещё нельзя добавлять, то запускаем цикл, где генерируем токен и одновременно делаем запрос в БД
        while (!$search_bool) {
            $token = tokenGen();
            $sel = mysqli_query($conn, "SELECT * FROM `links` WHERE `token` = '" . $token . "'");
            //если в БД такого токена нет, то можно добавлять ссылку в систему
            if (!mysqli_num_rows($sel)) {
                $search_bool = true;
            }
        }
    } else {
        $sel = mysqli_query($conn, "SELECT * FROM `links` WHERE `link` = '".$request."'");
        $row = mysqli_fetch_assoc($sel);
        $_GET['cut_link'] = $_SERVER['SERVER_NAME'].'/'.$row['token'];
    }

    //sql запрос на добавление ссылки в систему, где в таблице 'links' перечисляем атрибуты, которые будем использовать
    if ($search_bool) {
        $ins = mysqli_query($conn, "INSERT INTO `links` (`link`, `token`) VALUES ('".$request."', '".$token."') ");

        if ($ins) {
            $_GET['cut_link'] = $_SERVER['SERVER_NAME']. '/'. $token;
//            echo 'Ссылка добавлена в систему!';
        } else {
//            echo 'Ссылка не добавлена!';
        }
    } else {
//        echo 'Всё плохо!';
    }
} else {
    $URI = $_SERVER['REQUEST_URI'];
    $token = substr($URI, 1);

    if (iconv_strlen($token)) {
        $sel = mysqli_query($conn, "SELECT * FROM `links` WHERE `token` = '" . $token . "'"); //обращаюсь к таблице links, атрибуту токен

        //если такой токен в таблице есть, то получаем содержимое через mysqli_fetch_assoc, потом с помощью header() перенаправляем на нужный адрес
        if (mysqli_num_rows($sel)) {
            $row = mysqli_fetch_assoc($sel);
            header("Location: " . $row['link']);
        } else {
            if ($bool_link == true) {
                echo "<script>alert('Нельзя использовать ссылку данного сервиса!')</script>";
            } else {
                echo "<script>alert('Введите ссылку!')</script>";
            }
        }
    }
}

tokenGen();