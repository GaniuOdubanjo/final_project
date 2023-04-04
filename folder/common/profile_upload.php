<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session 
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if(isset($_FILES['image'])){           //if the button is clicked, it will save the data passed into database. (Stack Overflow, n.d.) from line 5-17
        $file=(file_get_contents($_FILES["image"]["tmp_name"]));   //gets the content saves it in the variable $file
        $image= getimageSize($_FILES['image']['tmp_name']);        // gets the image size saves it in the $image variable
        
        $stmt = $pdo->prepare("INSERT INTO `image`(`imageData`, `imageType`)  
        VALUES (:image, :type)");           //insert the two columns imageData  and imageType inside the image table 
         $stmt->bindParam(':image', $file, PDO::PARAM_LOB);
         $stmt->bindParam(':type', $image['mime'], PDO::PARAM_STR);
         $stmt->execute();                   //process the data
         $image_id = $pdo -> lastInsertId();     // lastInsertId function gets the last inserted id which is the primary key of the image table
         $values = [$image_id, $user['user_id']];    // passes the gotten id  and user id
         $stmt = $pdo->prepare('UPDATE `user` set `image_id`= ? WHERE `user_id` = ?');   // update the image_id after uploading new image in the user table.
         $stmt->execute($values);     //executes it.
         

        $query='SELECT * from user u  WHERE u.user_id = "'.$user['user_id'].'"  ';  // query the database to get the particular user(user_id)
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll()[0];                                  // variable $result holds the fetched value
        $_SESSION['user'] = $result;                                    //updates the session
         header("Location: /common/profile_upload.php");                      
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
        <div class="container-fluid p-0">   <!--container class-->
            <section class="resume-section" id="about">
                <div class="resume-section-content">
             <form action="/common/profile_upload.php" method="POST" enctype="multipart/form-data" >  <!--form-->
                    <div class="form-group">
                        <label for="name">Profile Image</label> <!--label-->
                        <input type="file" name="image" id="file" accept=".png,.gif,.jpg" class="form-control" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" value="create-course">Upload</button>   <!--button-->
                </form> 
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?> <!--includes the footer part of the page which is stored in the common folder-->
    </body>
</html>
