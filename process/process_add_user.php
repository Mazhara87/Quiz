<?php


require_once('connexion.php');

// var_dump($_POST);

if(
    isset($_POST['username']) && !empty($_POST['username'])
){
    $data = [
        'username' => $_POST['username'],
    ];
    $sql = "INSERT INTO users (usertname) VALUES (:username)";
    $request= $db->prepare($sql);
    $request->execute($data);
}
header('Location: index.php')
?>