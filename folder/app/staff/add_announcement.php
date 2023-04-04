<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'STAFF'){     //if the user is not a staff
        header("Location: /logout.php");      // logout
    }

    if($_POST){           //if the button is clicked, it will save the data passed into database.
            $stmt = $pdo->prepare('INSERT INTO announcement(`message`,`Date`, `staff_id`)  
            VALUES (?, ?, ?)');   // preparing the query(inserting the passed value)
            
            $values = [                     //get the user inputs using the $_POST and save it in the database
                $_POST['message'],
                $_POST['date'],
                $user['user_id']
            ];
            $stmt->execute($values);    //process the data
            header("Location: /home.php");   //direct the user to the homepage
       
     }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?> <!--includes once the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?> <!--includes once the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">      <!--display post annoucement applying the tsyle in the mb-0 class-->
                        Post
                        <span class="text-primary">Anouncement</span>
                    </h1>
                    <form action="" method="POST">       <!-- form with method post -->
                        <div class="form-group">
                            <label for="name">Anouncement</label>     <!---label for announcement-->
                            <textarea class="form-control" name="message" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="name">Date</label>     <!---label for date-->
                            <input type="date" class="form-control" name="date" id="name"required>
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary" value="create-announcement">Post</button>  <!--button-->
                    </form>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>       <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
