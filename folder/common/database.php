<?php
        //if the submit button is clicked, it will save the data passed into database.
    $server = 'db';
    $username = 'root';
    $password = 'csym019';
    $schema = 'project';    //The name of the database
   try{
     $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
    [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
   } catch(\Exception $error){
    echo $error_msg = $error -> getMessage();
   } 
?>