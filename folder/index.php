<?php 
include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');  //connection to the database
session_start();
$isValidLogin = true;
if($_POST){ 
    $email=$_POST['email'];
    $password=$_POST['password'];
    $query='SELECT * from user WHERE user.email="'.$email.'" AND user.password="'.$password .'" LIMIT 1';  // checks if the username and password is correct, if it is correct it direct the user to their respective index page based on their role 
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    if($stmt->rowCount() > 0){      ///check if the row count is greater than zero
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user=$stmt->fetchAll()[0]; // fetch all starting with the first index
        $_SESSION['user'] = $user;
        switch ($user['role']) {       //based on the user that logs in, it direct them to their respective page.
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
    }else{
        $isValidLogin = false;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>    <!--includes the common_head page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <div class="container-fluid p-0">         <!--container class-->

            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        CMS
                        <span class="text-primary">Project</span>
                    </h1>
                    <form action="index.php" method="post">     <!--form-->
                        <div class="form-group">
                            <label for="email">Email address</label>    <!--label for email-->
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>  <!--input-->
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>     <!--label for password-->
                            <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>    <!--input-->
                        </div>
                        <br>
                        <?php if($isValidLogin == false) echo ' <p class="lead mb-1 text-danger">Invalid email or password</p>' ?>   <!-- display an error message it the login is not correct-->
                        <button name="test" type="submit" class="btn btn-primary" value="login-form">Login</button>    <!--button-->
                        <br>
                        <a href="/contact.php">Contact Us</a>     <!--direct user to contact us page-->
                    </form>
                </div>
            </section>
            
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>    <!--includes the footer part of the page which is stored in the common folder(common-footer.php)-->
    </body>
</html>
