<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    
    // }
    $query='SELECT count(*) as result from module m WHERE m.Staff_staff_id= "'.$user['user_id'] .'" ';  // query the database to get the number of module
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll()[0];  // fetch the result
    $totalModule =  $result['result'];    //variable $totalModule holds the passed data

    $query='SELECT count(*) as result from form f WHERE f.staff_id = "'.$user['user_id'] .'" ';  // query the database to get the number of forms
    $stmt=$pdo->prepare($query);
    $stmt->execute();       //executes the query
    $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
    $result = $stmt->fetchAll()[0];
    $totalforms =  $result['result'];     // variable $totalforms holds 

    $query='SELECT * from user u left join staff s on u.user_id = s.staff_id left join department d on s.Department_department_Id = d.department_Id  WHERE u.user_id = "'.$user['user_id'] .'" ';  // query the database to get the user information using their ids to left join them.
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
    $info = $stmt->fetchAll()[0];    // the variable info stores the passed data


?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?> <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>  <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">   <!-- div element having a container class-->
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">        <!--title of the page-->
                        Staff
                        <span class="text-primary">Home</span>
                    </h1>
                    <div class="jumbotron">           
                        <div class="row w-100">
                            <div class="col-md-3">
                                <div class="card border-info mx-sm-1 p-3">    <!--display a card where information are displayed -->
                                    <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-building" aria-hidden="true"></span></div>
                                    <div class="text-info text-center mt-3"><h4>Modules</h4></div>
                                    <div class="text-info text-center mt-2"><h1><?php echo $totalModule; ?></h1></div>   <!--display total modules-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-success mx-sm-1 p-3">   <!--display a card where information are displayed -->
                                    <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-school" aria-hidden="true"></span></div>
                                    <div class="text-success text-center mt-3"><h4>Forms</h4></div>
                                    <div class="text-success text-center mt-2"><h1><?php echo $totalforms; ?></h1></div> <!--display total forms-->
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="container py-5">     <!--pad the conatainer -->
                            <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                <div class="card-body text-center"> <!--a bordered box with some padding around its content-->
                                    <?php if(isset($user['image_id'])){
                                                echo '<img class="rounded-circle img-fluid" src="/common/image.php?image_id='. $user["image_id"].'" alt="..." style="width: 150px;" />'; // displays user image in a circle
                                            } else {
                                                echo '<img class="rounded-circle img-fluid" src="/assets/img/profile.jpg" alt="..." style="width: 150px;"/>';  
                                            } ?>
                                    <h5 class="my-3"><?php echo $user['firstName'].' '.$user['lastName'] ?></h5>  <!--display user firstname and lastname-->
                                    <p class="text-muted mb-4"><?php echo $info['name'] ?></p> <!--display the course name-->
                                </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">      <!--using the row class-->
                                    <div class="col-sm-3">
                                        <p class="mb-0">Full Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['firstName'].' '.$user['lastName'] ?></p> <!--display the user firstname and lastname-->
                                    </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['email']?></p>  <!--display the user email-->
                                    </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['mobile_Number']?></p>   <!--display the user mobile number-->
                                    </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Staff ID</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $user['user_id']?></p>    <!--display the user id -->
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
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?> <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>