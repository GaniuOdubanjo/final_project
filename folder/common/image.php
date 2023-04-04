<?php
 include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
if (isset($_GET['image_id'])) {
    $stmt =$pdo->prepare("SELECT imageType,imageData FROM `image` WHERE image_id=" . $_GET['image_id']); //query to get imageType and imageData from image table 
    $stmt->execute();
    $record=$stmt->FETCH(PDO::FETCH_ASSOC);
     header("Content-type: " . $record["imageType"]);
     echo $record["imageData"];     // display the image
}
?>