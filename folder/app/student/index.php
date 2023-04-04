<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the database
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'STUDENT'){
        header("Location: /logout.php");
    }
    // the query was used to get the course name by left joinning using their common columns which is the id in each table. the table are user, student and course table.
    $query='SELECT c.name from user u left join student s on u.user_id = s.student_id left join course c on s.Course_course_Id = c.course_Id  WHERE u.user_id = "'.$user['user_id'].'"  ';  // query the database to check if the passed data exist
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
    $result = $stmt->fetchAll()[0];
    $course =  $result['name'];   //variable course holds the passed value 
     // the query was used to get the department name by left joinning using their common columns which is the id in each table. the table are user, student, department and course table.
    $query='SELECT d.name from user u left join student s on u.user_id = s.student_id left join course c on s.Course_course_Id = c.course_Id left join department d on c.Department_department_Id = d.department_Id  WHERE u.user_id = "'.$user['user_id'].'"  ';  // query the database to check if the passed data exist
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
    $result = $stmt->fetchAll()[0];
    $department =  $result['name'];  //variable department holds the passed value 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>  <!--includes once the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?> <!--includes once the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        Student
                        <span class="text-primary">Home</span>
                    </h1>
                    
                        <div class="container py-5">
                            <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                <div class="card-body text-center">
                                    <?php if(isset($user['image_id'])){
                                                echo '<img class="rounded-circle img-fluid" src="/common/image.php?image_id='. $user["image_id"].'" alt="..." style="width: 150px;" />'; // displays user image in a circle
                                            } else {
                                                echo '<img class="rounded-circle img-fluid" src="/assets/img/profile.jpg" alt="..." style="width: 150px;"/>';
                                            } ?>
                                    <h5 class="my-3"><?php echo $user['firstName'].' '.$user['lastName'] ?></h5> <!--display user firstname and lastname-->
                                    <p class="text-muted mb-1"><?php echo $course ?></p> <!--display the course-->
                                    <p class="text-muted mb-4"><?php echo $department ?></p> <!--display department-->
                                </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Full Name</p>     <!--apply paragraph-->
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['firstName'].' '.$user['lastName'] ?></p>  <!--display the user firstname and lastname-->
                                    </div>
                                    </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['email']?></p>   <!--display the user email-->
                                    </div>
                                    </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['mobile_Number']?></p> <!--display the user mobile number-->
                                    </div>
                                    </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Student ID</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['user_id']?></p>  <!--display the user id-->
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>  <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
