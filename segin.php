<?php
$pageTitle = 'Items';

include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $formErrors = array();

    $fullname   = $_POST['fullname'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];
    $location   = $_POST['location'];
    $hashPassword = sha1($password);

    if(empty($fullname)){
        $formErrors [] = 'Sorry User Name Cant Be Empty';
    }

    if(empty($email)){
        $formErrors[] = 'Sorry Email Cant Be Empty';
    }

    if(empty($password)){
        $formErrors[] = 'Sorry Password Cant Be Empty ';
    }

    if(empty($location)){

        $formErrors [] = 'Sorry Location Cant Be Empty';
    }

    if(!empty($formErrors)){
        echo '<div class="container mt-5">';
            foreach($formErrors as $errors){
                echo "<div class='alert alert-danger'>" . $errors . "</div>";
            }
        echo '</div>';
    }else{
        $userData = $db->save("users", "VALUES(NULL,'".$fullname."', '".$email."', '".$hashPassword."', '".$location."', NULL, 0)");
        if($userData){
            header("location: login.php");
        }else{
            echo "<div class='alert alert-danger'> Field Error</div>";
        }
    }
}

?>


<div class="container">
    <div class="row col-sm-12 login d-flex flex-column justify-content-evenly align-items-center">
        <h1 class="text-title text-center mb-3">Segin</h1>
        <div class="card col-sm-6 p-4 bg-light">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="col-sm-12">
                <div class="mb-2 row">
                    <label class="col-sm-2 col-form-label">Full Name</label>
                    <div class="col-sm-10 col-md-9">
                        <input 
                            class="form-control" 
                            type="text" 
                            name="fullname" 
                            placeholder="Enter your full name">
                    </div>
                </div>
                <div class="mb-2 row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10 col-md-9">
                        <input 
                            class="form-control" 
                            type="email" 
                            name="email" 
                            placeholder="Enter your Email">
                    </div>
                </div>
                <div class="mb-2 row">
                    <label class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10 col-md-9">
                        <input 
                            class="form-control" 
                            type="password" 
                            name="password" 
                            placeholder="Enter your Password">
                    </div>
                </div>
                <div class="mb-2 row">
                    <label class="col-sm-2 col-form-label">Location</label>
                    <div class="col-sm-10 col-md-9">
                        <input 
                            class="form-control" 
                            type="text" 
                            name="location" 
                            placeholder="Enter your Location">
                    </div>
                </div>
                <div class="mb-2 row">
                    <div class="offset-sm-2 col-sm-10">
                        <input type="submit" value="Signup" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>