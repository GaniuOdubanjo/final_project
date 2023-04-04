<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session
    include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database
    $user = $_SESSION['user'];
    if($user['role'] != 'ADMIN'){             // checks if the user is not an admin then
        header("Location: /logout.php");        //logout
    }

    if($_POST){           //if the button is clicked, it will save the data passed into database.
        $query='SELECT count(*) as result from department WHERE department.name="'.$_POST['department'].'" ';  // first, it check if the department name  supplied exist in the database, if it does it tells the user, so the user need to provide another name before it can add the department.
        $stmt=$pdo->prepare($query);    //prepares the query
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);// fetch the result
        $result = $stmt->fetchAll()[0];
        $totalUDepartmentWithname =  $result['result'];    // $totalUDepartmentWithname variable holds the passed value
        if($totalUDepartmentWithname < 1){
            $stmt = $pdo->prepare('INSERT INTO department(`name`)  
            VALUES (?)');   // preparing the query(inserting the passed value)
            
            $values = [                     //get the user inputs using the $_POST and save it in the database
                $_POST['department']
            ];
            $stmt->execute($values);    //process the data
            header("Location: /app/admin/departments.php");
        } else {
            $canCreate = false;
        }
        
     }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-head.php'; ?>  <!--includes the common_head  page which is stored in the common folder-->
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-navbar.php'; ?>    <!--includes the common_navbar page which is stored in the common folder-->
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        Create
                        <span class="text-primary">Department</span>
                    </h1>
                    <form action="" method="POST">     <!--form-->
                        <div class="form-group">
                            <label for="department">Department name</label>
                            <input type="text" class="form-control" name="department" id="department" placeholder="Department" required>
                        </div>
                        <br>
                        <?php if(isset($canCreate) && $canCreate == false) echo ' <p class="lead mb-1 text-danger">Invalid department name. There is already a department with this name</p>' ?>
                        <button type="submit" class="btn btn-primary" value="create-department">Add</button>
                    </form>
                </div>
            </section>
        </div>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/common/common-footer.php'; ?>   <!--includes the footer part of the page which is stored in the common folder(common-footer)-->
    </body>
</html>
