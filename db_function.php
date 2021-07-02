<?php
function pdo() {
    $pdo = new PDO('mysql:host=' . HOST . ';dbname=' .DBNAME,DBUSER,DBPASS);
    $pdo->exec('set names utf8');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
