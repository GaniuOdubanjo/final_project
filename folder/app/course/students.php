<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>    <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>       <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        CMS
                        <span class="text-primary">Student</span>
                    </h1>
                        <hr>
                        <?php    
                            echo '<div class="row">';
                            if($user['role'] == 'ADMIN'){
                                echo ' <div class="col-sm-2"><a href="/app/course/add_student.php?course_id='.$_GET['course_id'].'" class="btn btn-primary">Add Student</a></div>'; //direct to add_student page
                            }
                            echo '</div>';
                            echo '<hr>';
                        ?>

                        <h3 class="mb-0">
                            Students
                        </h3>
                        <table class="table">    <!--display table-->
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Firsname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Email</th>
                                <th scope="col">Gender</th>
                                <th scope="col">DOB</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT * from  student as s left join user as u on s.student_id = u.user_id WHERE s.Course_course_Id = "'.$_GET['course_id'] .'"  ');
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['user_id'].'</td>';
                                        echo '<td>'.$row['firstName'].'</td>';
                                        echo '<td>'.$row['lastName'].'</td>';
                                        echo '<td>'.$row['email'].'</td>';
                                        echo '<td>'.$row['gender'].'</td>';
                                        echo '<td>'.$row['date_of_Birth'].'</td>';
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