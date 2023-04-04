<?php
     include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
     $user = $_SESSION['user'];
     switch ($user['role']) {                       //direct the user based on their role
          case "STUDENT":
              header('Location: app/student/index.php');
              break;
          case "ADMIN":
              header('Location: app/admin/index.php');
              break;
          case "STAFF":
              header('Location: app/staff/index.php');
              break;
     }

?>