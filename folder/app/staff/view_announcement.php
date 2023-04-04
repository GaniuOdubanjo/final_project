<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
   
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>   <!--includes once the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?> <!--includes once the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">    <!--display my annoucement applying the tsyle in the mb-0 class-->
                        My
                        <span class="text-primary">Announcement</span>
                    </h1>
                    <h3 class="mb-0">Courses</h3> <!--display Courses applying the tsyle in the mb-0 class-->
                        <table class="table">   <!--display a table with table head-->
                            <thead> 
                                <tr>
                                <th scope="col">Date</th>      <!--display the Date-->
                                <th scope="col">Message</th>     <!--message-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $records = $pdo->query('SELECT * FROM announcement a   WHERE a.staff_id = "'.$user['user_id'].'"  '); // query display all the announcement by the staff

                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';         // table row
                                        echo '<td>'.$row['Date'].'</td>';      // display the data
                                        echo '<td>'.$row['message'].'</td>';       //display the message
                                        echo '</tr>';            //closes table row
                                     };
                                    ?>
                               
                            </tr>      <!--closes table row-->
                        </table>       <!--closes table -->
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>   <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
