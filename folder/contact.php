<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
   
    if($_POST){           //if the submit button is clicked, it will save the data passed into database.
            $stmt = $pdo->prepare('INSERT INTO contactus(`name`,`email`, `message`)  
            VALUES (?, ?, ?)');   // preparing the query(inserting the passed value)
            
            $values = [                     //get the user inputs using the $_POST and save it in the database
                $_POST['name'],
                $_POST['email'],
                $_POST['message']
            ];
            $stmt->execute($values);    //process the data
            
            $isSent = true;
       
     }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>   <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>  <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        Contact
                        <span class="text-primary">Us</span>
                    </h1>
                    <form action="" method="POST">       <!--form-->
                    <div class="form-group">
                            <label for="name">Name</label>         <!--label-->
                            <input class="form-control" name="name" required/>    <!--input-->
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input class="form-control" type="email" name="email" required/>
                        </div>
                        <div class="form-group">
                            <label for="name">Message</label>
                            <textarea class="form-control" name="message" required></textarea>
                        </div>
                        <br>
                        <?php if(isset($isSent) && $isSent == true){
                            echo ' <h4 class="text-success">Message sent</h4>';
                        } ?>
                       
                    </br>
                        <button type="submit" class="btn btn-primary" value="create-contact">Submit</button>   <!--button-->
                        <br>
                        <a href="/">Login Page</a>
                    </br>
                    </form>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>  <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
