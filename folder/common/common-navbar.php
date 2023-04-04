<?php
if(isset($_SESSION)){


 include($_SERVER['DOCUMENT_ROOT'].'/common/database.php');    //connection to the database  (www.youtube.com, n.d.)
 include($_SERVER['DOCUMENT_ROOT'].'/common/session.php');    //connection to the session

$user=$_SESSION['user'];

$stmt =$pdo->prepare("SELECT * FROM `user` u where u.user_id = ". $user['user_id']);  //query the user, get the session to get the user id 
$stmt->execute();
$user=$stmt->FETCH(PDO::FETCH_ASSOC);				

    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
    <a class="navbar-brand">
       
        <span class="d-none d-lg-block">';
        if(isset($user['image_id']))     // if image id is set do the first one else the one below
        {
            echo '<img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="/common/image.php?image_id='. $user["image_id"].'" alt="..." />';
        } else {
            echo '<img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="/assets/img/profile.jpg" alt="..." />';
        }
        echo '</span> </a>';
        echo  '<span class="d-block text-white">Hello! '.$user['firstName']. ' ' .$user['lastName'].'</span>';
    echo '
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav">';
        echo '<li class="nav-item"><a class="nav-link" href="/home.php">Home</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="/common/profile_upload.php">Profile Upload</a></li>';
        switch ($user['role']) {
            
            case "STUDENT":
                echo '<li class="nav-item"><a class="nav-link" href="/app/student/add_form.php">Form</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/student/view_announcement.php">Anouncements</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/student/view_forms.php">My Forms</a></li>';
                break;
            case "ADMIN":
                echo '<li class="nav-item"><a class="nav-link" href="/app/admin/add_admin.php">Add New Admin</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/admin/add_department.php">Add Department</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/admin/departments.php">Departments</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/admin/contacts.php">Contacts</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/admin/students.php">Students</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/admin/courses.php">Courses</a></li>';
                break;
            case "STAFF":
                echo '<li class="nav-item"><a class="nav-link" href="/app/staff/add_announcement.php">Post Announcement</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/staff/view_announcement.php">Anouncements</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="/app/staff/view_forms.php">View Forms</a></li>';
                break;
        }
        echo '
            <li class="nav-item"><a class="nav-link" href="/logout.php">Logout</a></li>
        </ul>
    </div>
    </nav>';
}
?>