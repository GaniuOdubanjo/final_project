<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){          //checks if the user is an admin
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
                        <span class="text-primary">Department</span>
                    </h1>
                    <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Courses</th>
                                <th scope="col">Students</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT *, (select count(*) from course where Department_department_Id = d.department_Id ) as course, (SELECT count(*) as result from user as u left join student as s on u.user_id = s.student_id left join course as c on s.Course_course_Id = c.course_id  WHERE u.role = "STUDENT" AND c.Department_department_Id = d.department_Id ) as students from department d');
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['department_Id'].'</td>';
                                        echo '<td>'.$row['name'].'</td>';
                                        echo '<td>'.$row['course'].'</td>';
                                        echo '<td>'.$row['students'].'</td>';
                                        echo '<td><a class="btn btn-primary text-white" href="/app/department/index.php?department_id='.$row['department_Id'].'">Open</a></td>';  //direct user to index.php page with the deparment id 
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
