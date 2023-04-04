<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    // the query below gets the course by left joining the user table, course table and student table using their id
    $query='SELECT c.* from student s left join user u on s.student_id=u.user_id left join course c on s.Course_course_Id = c.course_Id  WHERE u.user_id = "'.$user['user_id'].'"  ';  // query the database to check if the passed data exist
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
    $course = $stmt->fetchAll()[0];

    if($_POST){           //if the button is clicked, it will save the data passed into database.
        $file=(file_get_contents($_FILES["image"]["tmp_name"])); //gets the content saves it in the variable $file
        $image= getimageSize($_FILES['image']['tmp_name']);   // gets the image size saves it in the $image
        $stmt = $pdo->prepare("INSERT INTO `image`(`imageData`, `imageType`)  
        VALUES (:image, :type)");                                    //insert the two columns imageData  and imageType inside the image table 
         $stmt->bindParam(':image', $file, PDO::PARAM_LOB);
         $stmt->bindParam(':type', $image['mime'], PDO::PARAM_STR);
         $stmt->execute();                                //process the data
         $image_id = $pdo -> lastInsertId();              // lastInsertId function gets the last inserted id which is the primary key of the image table
         
            $stmt = $pdo->prepare('INSERT INTO form(`symptoms`,`date_carried_out`,`result_of_test`,`Student_student_id`,`image_id`, `staff_id`,`module_id`)  
            VALUES (?, ?, ?, ?, ?, ?,?)');   // preparing the query(inserting the passed value)
            
            $values = [                     //get the user inputs using the $_POST and save it in the database
                $_POST['symptoms'],
                $_POST['date_carried_out'],
                $_POST['result_of_test'],
                $user['user_id'],
                $image_id,
                $_POST['staff_id'],
                $_POST['module']
            ];
            $stmt->execute($values);    //process the data
            header("Location: /app/student/index.php");            //direct the user to homepage
        
     }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>  <!--includes once the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>   <!--includes once the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        Send
                        <span class="text-primary">Form</span>
                    </h1>
                    <form action="" method="POST" enctype="multipart/form-data">        <!--form -->
                        <div class="form-group">
                            <label for="name">Symptoms</label>        <!--label for symptoms-->
                            <input type="text" maxlength="45" size="45" class="form-control" name="symptoms" id="name" required>
                        </div>

                        <div class="form-group">
                            <label >Test Result</label>                      <!--label for test result-->
                            <input type="text" maxlength="45" size="45" class="form-control" name="result_of_test" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Date carried out</label>     <!--label for Date carried out-->
                            <input type="date" class="form-control" name="date_carried_out"  placeholder="Date carried out" required>
                        </div>
                       
                        <div class="form-group">
                            <label for="name">Upload Proof</label>     <!--label upload proof-->
                            <input type="file" name="image" id="file" accept=".png,.gif,.jpg" class="form-control" required>
                        </div>
                        <div class="form-group">
                                 <label for="name">Lecturer name</label> <!--label for lecturer name-->
                                <select name="staff_id" class="form-control" required>
                                    <?php 
                                    $query='select * from module m left join user u on m.Staff_staff_id = u.user_id where m.Course_course_Id = "'.$course['course_Id'] .'" ';  // query the database to get the lecturer teaching the module 
                                    
                                        $stmt =$pdo->prepare($query);
                                        $stmt->execute();
                                        while ($value = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="'. $value["Staff_staff_id"]. '">'.$value["firstName"] .'</option>'; // display staff  names
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="form-group">
                                 <label for="name">Module name</label>           <!--label for module name-->
                                <select name="module" class="form-control" required>
                                    <?php 
                                    $query='select * from module m  where m.Course_course_Id = "'.$course['course_Id'] .'" ';  //query the database to get the module belonging to a course
                                    
                                        $stmt =$pdo->prepare($query);
                                        $stmt->execute();
                                        while ($value = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='". $value["module_id"]. "'>".$value["module_Name"] .'</option>'; // display list of modules names
                                        }
                                        ?>
                                </select>
                            </div>
                        <br>
                        <button type="submit" class="btn btn-primary" value="create-course">Submit Form</button>   <!--button-->
                    </form>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>  <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
