<?php

function cursor() {
    $dbh = new PDO('mysql:dbname=cvo_1;host=mysql;port=3306', 'root', 'root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM users LIMIT 1000000';
    $stmt = $dbh->query($sql);
    $data = array();
    while($data = $stmt->fetch()){
        yield $data;
    }

}
function get() {
    $result = [];
    $dbh = new PDO('mysql:dbname=cvo_1;host=mysql;port=3306', 'root', 'root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM users LIMIT 1000000';
    $stmt = $dbh->query($sql);
    $data = array();
    while($data = $stmt->fetch()){
        $result[] = $data;
    }
    return $result;

}

function getAll() {
    $dbh = new PDO('mysql:dbname=cvo_1;host=mysql;port=3306', 'root', 'root');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM users LIMIT 1000000';
    $stmt = $dbh->query($sql);
    $data = $stmt->fetchAll();
    return $data;

}
$rows = cursor();
foreach($rows as $row) {
    echo $row['user_id'];
}