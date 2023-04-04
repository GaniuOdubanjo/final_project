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
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?> <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?> <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        CMS
                        <span class="text-primary">Students</span>
                    </h1>
                    <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Firsname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Email</th>
                                <th scope="col">Gender</th>
                                <th scope="col">DOB</th>
                                <th scope="col">Department</th>
                                <th scope="col">Course</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT * from student s left join user u on s.student_id = u.user_id left join course c on s.Course_course_Id = c.course_id where u.role = "STUDENT"');
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['user_id'].'</td>';
                                        echo '<td>'.$row['firstName'].'</td>';
                                        echo '<td>'.$row['lastName'].'</td>';
                                        echo '<td>'.$row['email'].'</td>';
                                        echo '<td>'.$row['gender'].'</td>';
                                        echo '<td>'.$row['date_of_Birth'].'</td>';
                                        echo '<td><a class="btn btn-primary text-white" href="/app/department/index.php?department_id='.$row['Department_department_Id'].'">Open</a></td>';
                                        echo '<td><a class="btn btn-primary text-white" href="/app/course/index.php?course_id='.$row['course_Id'].'">Open</a></td>';
                                        echo '</tr>';
                                     };
                                     
                                    ?>
                               
                            </tr>
                        </table>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>   <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
