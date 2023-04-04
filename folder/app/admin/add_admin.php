<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session(which has the session_start function) 
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');   //connection to the database(file stored in the common)
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){   // checks if the user is not an admin, if it is not then it logout 
        header("Location: /logout.php");
    }
    if($_POST){           //if the submit button is clicked, it will save the data passed into database.
        $query='SELECT count(*) as result from user WHERE user.email="'.$_POST['email'].'" ';  // first, it check if the email supplied exist in the database, if it does it tells the user, so the user need to provide another email before it can add the user. 
        $stmt=$pdo->prepare($query);              //preparing the query
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll()[0];          // fetch the result
        $totalUserWithEmail =  $result['result'];    //$totalUserwithEmail  variable holds the returned value after checking if there is an existing user with the email.
        if($totalUserWithEmail < 1){      //if the returned value is less than one which means there is no such email than it insert it registers the new admin
            $stmt = $pdo->prepare('INSERT INTO user(firstName,lastName,date_of_Birth,email,`role`,`gender`,`mobile_number`,`password`)  
            VALUES (?,?,?,?,?,?,?,?)');   // preparing the query(inserting the passed value)
            
            $values = [                     //get the user inputs using the $_POST and save it in the database
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['dob'],
                $_POST['email'],
                $_POST['role'],
                $_POST['gender'],
                $_POST['mobilenumber'],
                $_POST['password']
            ];
            $stmt->execute($values);    // exceutes it
            header("Location: /home.php");    //direct user to homepage, after adding the new user.
        } else {
            $canCreate = false;      
        }
        
     }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>     <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>    <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        New
                        <span class="text-primary">User</span>
                    </h1>
                    <form action="" method="post">
                    <input name='role' value='ADMIN' type='hidden' />  <!--set the value to ADMIN and the type to hidden which is automatically added anytime the form is filled-->
                        <?php include ($_SERVER['DOCUMENT_ROOT'].'/common/user-form.php') ?>   <!--includes the user-form.php which is stored in the common folder(common-footer)-->
                        <?php if(isset($canCreate) && $canCreate == false) echo ' <p class="lead mb-1 text-danger">Invalid email. There is already someone with email address</p>' ?>      <!--display an error message if the email exist in the database-->
                        <br>
                        <button type="submit" class="btn btn-primary" value="create-user-form">Add User</button>   <!--button-->
                    </form>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?> <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
