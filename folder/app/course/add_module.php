<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){
        header("Location: /logout.php");
    }

    if($_POST){           //if the button is clicked, it will save the data passed into database.
        $query='SELECT count(*) as result from module WHERE module.module_Name="'.$_POST['name'].'" AND module.Course_course_Id = "'.$_GET['course_id'].'" ';  // query the database to check if the passed data exist
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
        $result = $stmt->fetchAll()[0];
        $totalUDepartmentWithname =  $result['result'];  //variables totalUDepartmentwithname holds the passed value
        if($totalUDepartmentWithname < 1){
            $stmt = $pdo->prepare('INSERT INTO module(`module_Name`,`Staff_staff_id`, `Course_course_Id`)  
            VALUES (?, ?, ?)');   // preparing the query(inserting the passed value)
            
            $values = [            
                $_POST['name'],         //get the user inputs using the $_POST and save it in the database
                $_POST['staff_id'],
                $_GET['course_id']
            ];
            $stmt->execute($values);    //process the data
            header("Location: /app/course/index.php?course_id=".$_GET['course_id']);
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
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>     <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        Create
                        <span class="text-primary">Module</span>
                    </h1>
                    <form action="" method="POST">    <!--form -->
                        <div class="form-group">
                            <label for="name">Module name</label>     <!--label for module name-->
                            <input type="text" class="form-control" name="name" id="name" placeholder="Module name" required>    <!--input-->
                        </div>
                        <div class="form-group">
                            <label for="name">Lecturer name</label>       <!--label for Lecturer name-->
                            <select name="staff_id" class="form-control" required>
                            <?php 
                             $query='SELECT Department_department_Id  from course as c where c.course_Id = "'.$_GET['course_id'] .'" ';  // query the database to get the course_id
                             $stmt=$pdo->prepare($query);
                             $stmt->execute();
                             $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
                             $result = $stmt->fetchAll()[0];
                             $departmentId =  $result['Department_department_Id'];
                                $stmt =$pdo->prepare('SELECT * FROM `staff` as s left join `user` as u on s.staff_id = u.user_id where Department_department_Id = '.$departmentId );  //gets staff name
                                $stmt->execute();     //executes the query
                                while ($value = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='". $value["staff_id"]. "'>".$value["firstName"] .'</option>';   //display staff name
                                }
                                ?>
                            </select>
                        </div>
                        <br>
                        <?php if(isset($canCreate) && $canCreate == false) echo ' <p class="lead mb-1 text-danger">Invalid module name. There is already a course with this name</p>' ?>   <!--display message if course name exist-->
                        <button type="submit" class="btn btn-primary" value="create-course">Add Module</button>     <!--button-->
                    </form>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>  <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
