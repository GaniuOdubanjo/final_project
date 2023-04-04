<?php
session_start();        // start session  (www.youtube.com, n.d)
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}
?>