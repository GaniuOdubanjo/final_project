<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){   //checks if the user is an admin or not
        header("Location: /logout.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>  <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>       <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">        <!--container-->
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">          <!--display-->
                        CMS
                        <span class="text-primary">Contacts</span>
                    </h1>
                    <table class="table">          <!--creates table-->
                            <thead>            <!--creates table head-->
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Message</th>
                                </tr>
                            </thead>                     <!--closes the table head-->
                            <tbody>                       <!--table body-->
                                <tr>
                                    <?php
                                    $records =$pdo->query('SELECT * from contactus c');    // select data strictly in the constactus table alone
 
                                    foreach ($records as $row){  //loops through the data and add it to the appropiate row
                                        echo '<tr>';
                                        echo '<td scope="row">'.$row['contact_id'].'</td>';
                                        echo '<td>'.$row['name'].'</td>';
                                        echo '<td>'.$row['email'].'</td>';
                                        echo '<td>'.$row['message'].'</td>';

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
