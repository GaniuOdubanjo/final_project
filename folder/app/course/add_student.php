<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){
        header("Location: /logout.php");
    }

    if($_POST){           //if the submit button is clicked, it will save the data passed into database.
        $query='SELECT count(*) as result from user WHERE user.email="'.$_POST['email'].'" ';  // query the database to check if the passed data exist
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
        $result = $stmt->fetchAll()[0];
        $totalUserWithEmail =  $result['result'];
        if($totalUserWithEmail < 1){
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
            $stmt->execute($values);    
            $user_id = $pdo -> lastInsertId();  // lastInsertId function get the last insert id 
            $stmt = $pdo->prepare('INSERT INTO student(Course_course_Id, student_id)  
            VALUES (?, ?)');   // preparing the query(inserting the passed value)
            
            $values = [
                $_GET['course_id'], $user_id        
            ];
            $stmt->execute($values);    
            header("Location: /app/course/index.php?course_id=".$_GET['course_id']);
        } else {
            $canCreate = false;
        }
        
     }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>   <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>    <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        Create
                        <span class="text-primary">Student</span>
                    </h1>
                    <form action="" method="POST">
                        <input name="role" value="STUDENT" type="hidden" />
                        <?php include ($_SERVER['DOCUMENT_ROOT'].'/common/user-form.php') ?>  <!--includes the user-form.php which is stored in the common folder(common-footer)-->
                        <br>
                        <?php if(isset($canCreate) && $canCreate == false) echo ' <p class="lead mb-1 text-danger">Invalid email. There is already a user with this email address</p>' ?>  <!--display error message to the user-->
                        <button type="submit" class="btn btn-primary" value="create-staff">Add Student</button>
                    </form>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>  <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
