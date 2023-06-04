<?php

$conn = mysqli_connect('localhost', 'root', '', 'cut_link');

//проверка на успешность подключения
if (!$conn) die("Ошибка подключения к БД: \n" . mysqli_connect_error());