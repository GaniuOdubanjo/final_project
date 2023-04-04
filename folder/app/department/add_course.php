<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){
        header("Location: /logout.php");
    }

    if($_POST){           //if the  button is clicked, it will save the data passed into database.
        $query='SELECT count(*) as result from course WHERE course.name="'.$_POST['name'].'" AND course.Department_department_Id = "'.$_GET['department_id'].'" ';  // query the database to check if the passed name exist, if it does it tells the user and if not its add the course
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
        $result = $stmt->fetchAll()[0];
        $totalUDepartmentWithname =  $result['result'];
        if($totalUDepartmentWithname < 1){
            $stmt = $pdo->prepare('INSERT INTO course(`name`,`Department_department_Id`)  
            VALUES (?, ?)');   // preparing the query(inserting the passed value)
            
            $values = [                     //get the user inputs using the $_POST and save it in the database
                $_POST['name'],
                $_GET['department_id']
            ];
            $stmt->execute($values);    //process the data
            header("Location: /app/department/index.php?department_id=".$_GET['department_id']);
        } else {
            $canCreate = false;
        }
        
     }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?> <!--includes the common_head  page which is stored in the common folder-->
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
                        <span class="text-primary">Course</span>
                    </h1>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="name">Course name</label>
                            <input type="text" class="form-control" name="name" id="name" course="Department" required>
                        </div>
                        <br>
                        <?php if(isset($canCreate) && $canCreate == false) echo ' <p class="lead mb-1 text-danger">Invalid course name. There is already a course with this name</p>' ?>
                        <button type="submit" class="btn btn-primary" value="create-course">Add Course</button>
                    </form>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?> <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
