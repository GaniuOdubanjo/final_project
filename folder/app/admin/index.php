<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session(which has the session_start function)  
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database(file stored in the common)
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){
        header("Location: /logout.php");
    }
    $query='SELECT count(*) as result from user WHERE user.role = "STUDENT" ';  // query the database to check for the number of student
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll()[0];    // fetch the result
    $totalStudent =  $result['result'];  //variable totalDepartment holds the value 


    $query='SELECT count(*) as result from department ';  // query the database to check for the number of department
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll()[0]; // fetch the result
    $totalDepartment =  $result['result'];  // variable totalDepartment holds the value 

    $query='SELECT count(*) as result from course ';  // query the database to check for the number of course
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
    $result = $stmt->fetchAll()[0];
    $totalCourse =  $result['result'];    //variable totalcourse holds the value passed

   
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>  
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        ADMIN
                        <span class="text-primary">Home</span>
                    </h1>
                    <div class="jumbotron">
                        <div class="row w-100">
                            <div class="col-md-3">
                                <div class="card border-info mx-sm-1 p-3">
                                    <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-building" aria-hidden="true"></span></div>
                                    <div class="text-info text-center mt-3"><h4>Departments</h4></div>
                                    <div class="text-info text-center mt-2"><h1><a class="" href="departments.php"><?php echo $totalDepartment; ?></a></h1></div> <!--display total department-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-success mx-sm-1 p-3">
                                    <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-school" aria-hidden="true"></span></div>
                                    <div class="text-success text-center mt-3"><h4>Course</h4></div>
                                    <div class="text-success text-center mt-2"><h1><a class="" href="courses.php"><?php echo $totalCourse; ?></a></h1></div> <!--display total course-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-danger mx-sm-1 p-3">
                                    <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-user" aria-hidden="true"></span></div>
                                    <div class="text-danger text-center mt-3"><h4>Student</h4></div>
                                    <div class="text-danger text-center mt-2"><h1><a class="" href="students.php"><?php echo $totalStudent; ?></a></h1></div>  <!--display total student-->
                                </div>
                            </div>
                        </div>
                        <table class="table">           <!--add table -->
                            <thead>                     <!--add table head-->
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Firstname</th>      <!--display firstname on the table-->
                                <th scope="col">Lastname</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT * from user WHERE user.role = "ADMIN" '); // gets all the admin stored in the database
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['user_id'].'</td>';
                                        echo '<td>'.$row['firstName'].'</td>';
                                        echo '<td>'.$row['lastName'].'</td>';
                                        echo '<td>'.$row['gender'].'</td>';
                                        echo '<td>'.$row['email'].'</td>';
                                        echo '</tr>';
                                     };
                                     
                                    ?>
                               
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>  <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
