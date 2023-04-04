<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    $query='SELECT * from user u left join student s on u.user_id = s.student_id WHERE u.user_id = "'.$user['user_id'].'"  ';  // query the database 
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
    $course = $stmt->fetchAll()[0];
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
                        Course
                        <span class="text-primary">Announcement</span>
                    </h1>
                        <table class="table">   <!--display table-->
                            <thead>
                                <tr>
                                <th scope="col">Date</th>  <!--display the -->
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    //query the database to know staff who made the announcement
                                    $records = $pdo->query('SELECT * FROM announcement a left join module m on a.staff_id = m.Staff_staff_id left join user u on u.user_id = m.Staff_staff_id  WHERE m.Course_course_Id = "'.$course['Course_course_Id'].'"  '); 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['Date'].'</td>'; // display date
                                        echo '<td>'.$row['firstName']. ' '.$row['lastName'].'</td>';    //display
                                        echo '<td>'.$row['email'].'</td>';
                                        echo '<td>'.$row['message'].'</td>';
                                        echo '</tr>';     //closes table row
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
