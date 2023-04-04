<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'STAFF'){         // if the user is not a staff, it logout
        header("Location: /logout.php");     
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>    <!--includes once the common_head  page which is stored in the common folder-->
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
                        
                        <table class="table">   <!--display a table-->
                            <thead>      <!--display the table heads-->
                                <tr>
                                <th scope="col">#</th>           <!--display user id in the table head-->
                                <th scope="col">Firstname</th>   <!--display firstname in the table head-->
                                <th scope="col">Lastname</th>    <!--display Lastname in the table head-->
                                <th scope="col">Email</th>        <!--display email in the table head-->
                                <th scope="col">symptoms</th>      <!--display firstname in the table head-->
                                <th scope="col">Date Carried Out</th>     <!--display date carried out in the table head-->
                                <th scope="col">Test Result</th>          <!--display test result in the table head-->
                                <th scope="col">Module</th>               <!--display module in the table head-->
                                <th scope="col">Image</th>                <!--display image in the table head-->
                                <th scope="col"></th>                      
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    // the query below select all information from form using the alias,select user firstname, lastname, and email from user table,select all from the module table then left join all of them using the common ids between the tables
                                    $records =$pdo->query('SELECT f.*,u.firstName,u.lastName,u.email,m.* from form f left join student s on f.Student_student_id = s.student_id left join user as u on s.student_id = u.user_id left join module m on f.module_id = m.module_id WHERE f.staff_id = "'.$user['user_id'] .'"  ');
                                    
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';      
                                        echo '<td scope="row">'.$row['user_id'].'</td>';  //displays user id
                                        echo '<td>'.$row['firstName'].'</td>';              //displays firstname of the student
                                        echo '<td>'.$row['lastName'].'</td>';               //displays lastname of the student
                                        echo '<td>'.$row['email'].'</td>';                  //displays email of the student
                                        echo '<td>'.$row['symptoms'].'</td>';                // display symptoms
                                        echo '<td>'.$row['date_carried_out'].'</td>';          //display date carried out
                                        echo '<td>'.$row['result_of_test'].'</td>';            //display result of test
                                        echo '<td>'.$row['module_Name'].'</td>';               // display module name
                                        echo '<td><img src="/common/image.php?image_id='.$row['image_id'].'" width="100" height="100"/></td>';     // display the image uploaded by the student
                                        echo '</tr>';
                                     };
                                    ?>
                            </tr>
                        </table>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>     <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>