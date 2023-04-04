<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){
        header("Location: /logout.php");
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
                        CMS
                        <span class="text-primary">Course</span>
                    </h1>
                    <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>    
                                <th scope="col">Name</th>    <!--display the name on the table -->
                                <th scope="col">Course</th>    <!--display the Course on the table -->
                                <th scope="col">Department</th>   <!--display the department on the table -->
                
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT * from course c');       // select only columns in the course table
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['course_Id'].'</td>';    //display course id
                                        echo '<td>'.$row['name'].'</td>';                      //display course name
                                        echo '<td><a class="btn btn-primary text-white" href="/app/course/index.php?course_id='.$row['course_Id'].'">Open</a></td>';  // direct the user to /app/course/index.php with the course id
                                        echo '<td><a class="btn btn-primary text-white" href="/app/department/index.php?department_id='.$row['Department_department_Id'].'">Open</a></td>';  // direct the user to /app/department/index.php with the department id
                                        echo '</tr>';
                                     };
                                     
                                    ?>
                               
                            </tr>
                        </table>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>  <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
