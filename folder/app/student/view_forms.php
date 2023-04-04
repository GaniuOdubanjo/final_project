<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'STUDENT'){
        header("Location: /logout.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>  <!--includes once the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>   <!--includes once the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        CMS
                        <span class="text-primary">Forms</span>
                    </h1>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">student Id</th>
                                <th scope="col">symptoms</th>
                                <th scope="col">Date Carried Out</th>
                                <th scope="col">Test Result</th>
                                <th scope="col">Images</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT * from form f  WHERE f.Student_student_id = "'.$user['user_id'] .'"  ');   // query to get the user information 
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['Student_student_id'].'</td>';
                                        echo '<td>'.$row['symptoms'].'</td>';
                                        echo '<td>'.$row['date_carried_out'].'</td>';
                                        echo '<td>'.$row['result_of_test'].'</td>';
                                        echo '<td><img style="width: 30px" src="/common/image.php?image_id='.$row['image_id'].'" /></td>';
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