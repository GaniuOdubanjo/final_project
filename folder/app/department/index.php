<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    // query the database to get  the total number of staff
    $query='SELECT count(*) as result from user u left join staff s on u.user_id = s.staff_id WHERE u.role = "STAFF" AND s.Department_department_Id="'.$_GET['department_id'] .'" ';  // query the database to check if the passed data exist
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll()[0];  // fetch the result
    $totalStaff =  $result['result'];
     // query the database to get  the total number of students
    $query='SELECT count(*) as result from user as u left join student as s on u.user_id = s.student_id left join course as c on s.Course_course_Id = c.course_id  WHERE u.role = "STUDENT" AND c.Department_department_Id="'.$_GET['department_id'] .'" ';  // query the database to check if the passed data exist
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll()[0];      // fetch the result
    $totalStudent =  $result['result'];
     // query the database to get  the total number of course
    $query='SELECT count(*) as result from  course as c left join department as d on c.Department_department_Id = d.department_Id WHERE d.department_Id = "'.$_GET['department_id'] .'" ';  // query the database to check if the passed data exist
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll()[0];            // fetch the result
    $totalCourse =  $result['result'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>   <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>      <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        CMS
                        <span class="text-primary">Department</span>
                    </h1>
                    <div class="jumbotron">
                        <div class="row w-100">
                            <div class="col-md-3">
                                <div class="card border-info mx-sm-1 p-3">
                                    <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-building" aria-hidden="true"></span></div>
                                    <div class="text-info text-center mt-3"><h4>Students</h4></div>
                                    <div class="text-info text-center mt-2"><h1><?php echo $totalStudent; ?></h1></div> <!--display the total number of student on the card-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-success mx-sm-1 p-3">
                                    <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-school" aria-hidden="true"></span></div>
                                    <div class="text-success text-center mt-3"><h4>Course</h4></div>
                                    <div class="text-success text-center mt-2"><h1><?php echo $totalCourse; ?></h1></div> <!--display the total course on the card-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-danger mx-sm-1 p-3">
                                    <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-user" aria-hidden="true"></span></div>
                                    <div class="text-danger text-center mt-3"><h4>Staff</h4></div>
                                    <div class="text-danger text-center mt-2"><h1><?php echo $totalStaff; ?></h1></div> <!--display total staff on the card-->
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php 
                            if($user['role'] == 'ADMIN'){  
                                echo '<div class="row">';
                                echo ' <div class="col-sm-2"><a href="/app/department/add_course.php?department_id='.$_GET['department_id'].'" class="btn btn-success">Add Course</a></div>';
                                echo ' <div class="col-sm-2"><a href="/app/department/add_staff.php?department_id='.$_GET['department_id'].'" class="btn btn-primary">Add Staff</a></div>';
                                echo '</div>';
                                echo '<hr>';
                            }
                        ?>
                        <h3 class="mb-0">Courses</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT c.* from  course as c left join department as d on c.Department_department_Id = d.department_Id WHERE d.department_Id = "'.$_GET['department_id'] .'" ');
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['course_Id'].'</td>';
                                        echo '<td>'.$row['name'].'</td>';
                                        echo '<td><a class="btn btn-primary text-white" href="/app/course/index.php?course_id='.$row['course_Id'].'">Open</a></td>';
                                        echo '</tr>';
                                     };
                                     
                                    ?>
                               
                            </tr>
                        </table>

                        <h3 class="mb-0">Staffs</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT * from user u left join staff s on u.user_id = s.staff_id WHERE u.role = "STAFF" AND s.Department_department_Id="'.$_GET['department_id'] .'" ');
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['user_id'].'</td>';
                                        echo '<td>'.$row['firstName'].'</td>';
                                        echo '<td>'.$row['lastName'].'</td>';
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