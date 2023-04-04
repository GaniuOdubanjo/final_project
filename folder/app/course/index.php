<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
     
    $query='SELECT count(*) as result from user as u left join student as s on u.user_id = s.student_id left join course as c on s.Course_course_Id = c.course_id  WHERE u.role = "STUDENT" AND c.course_id="'.$_GET['course_id'] .'" ';  // Query to get the total number of student 
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll()[0];            // fetch the result
    $totalStudent =  $result['result'];        //variable totalstudent holds the passed value

    $query='SELECT count(*) as result from module as m where  m.Course_course_Id = "'.$_GET['course_id'] .'" ';  // query to get the total number of modules
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll()[0];            // fetch the result
    $totalModule =  $result['result'];          // variable $totalModule holds the passed value

?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>          <!--includes the common_head  page which is stored in the common folder-->
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
                        <span class="text-primary">Course</span>
                    </h1>
                    <div class="jumbotron">
                        <div class="row w-100">
                            <div class="col-md-3">
                                <div class="card border-info mx-sm-1 p-3">
                                    <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-building" aria-hidden="true"></span></div>
                                    <div class="text-info text-center mt-3"><h4>Students</h4></div>
                                    <div class="text-info text-center mt-2"><h1><?php echo $totalStudent; ?></h1></div>   <!--display total number ofstudent on the card-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-info mx-sm-1 p-3">
                                    <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-building" aria-hidden="true"></span></div>
                                    <div class="text-info text-center mt-3"><h4>Modules</h4></div>
                                    <div class="text-info text-center mt-2"><h1><?php echo $totalModule; ?></h1></div>    <!--display total number of Module on the card-->
                                </div>
                            </div>
                        </div>
                    </div>
                        <hr>
                        <?php 
                            echo '<div class="row">';
                            if($user['role'] == 'ADMIN'){
                                echo ' <div class="col-sm-2"><a href="/app/course/add_module.php?course_id='.$_GET['course_id'].'" class="btn btn-success">Add Module</a></div>';  //get the course_id using the $_GET funtion
                                echo ' <div class="col-sm-2"><a href="/app/course/add_student.php?course_id='.$_GET['course_id'].'" class="btn btn-primary">Add Student</a></div>';
                            }
                            echo ' <div class="col-sm-2"><a href="/app/course/students.php?course_id='.$_GET['course_id'].'" class="btn btn-warning">Students</a></div>';
                            echo '</div>';
                            echo '<hr>';
                        ?>
                        <h3 class="mb-0">
                            Module
                        </h3>
                        <table class="table">        <!--table-->
                            <thead>                    <!--table head-->
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Module Name</th>    <!--display Module name on the table-->
                                <th scope="col">Lecturer Firstname</th>    <!--display Lecturer Firstname on the table-->
                                <th scope="col">Lecturer Lastname</th>     <!--display Lecturer Lastname on the table-->
                                <th scope="col">Lecturer Email</th>        <!--display Lecturer email on the table-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    //query to get staff information
                                    $records =$pdo->query('SELECT * from  module as m left join user as u on m.Staff_staff_id = u.user_id WHERE m.Course_course_Id = "'.$_GET['course_id'] .'"  ');
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';                                         //opening tag for table  row
                                        echo '<td scope="row">'.$row['module_id'].'</td>';  //show module id
                                        echo '<td>'.$row['module_Name'].'</td>';            //show module name
                                        echo '<td>'.$row['firstName'].'</td>';              //show firstname
                                        echo '<td>'.$row['lastName'].'</td>';                //show lastname
                                        echo '<td>'.$row['email'].'</td>';                   //show email
                                        echo '</tr>';                                         //closing tag
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