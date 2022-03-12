<?php
session_start();
$pageTitle = 'Items';

if(isset($_SESSION['user'])){
    header('Location: index.php');
}
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $fullname   = $_POST['fullname'];
    $password   = $_POST['password'];
    $hashPassword = sha1($password);
    $result = $db->checkUser($fullname, $hashPassword);
    // if (mysqli_num_rows($user) === 1) {
    $user = mysqli_fetch_assoc($result);
    if($user){
        $_SESSION['user'] = $fullname; 

        $_SESSION['uid'] = $user['UserID'];

        header('Location: index.php');
        // exit();
    }else{
        echo "error";
    
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
                    <div class="offset-sm-2 col-sm-10">
                        <input type="submit" value="login" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>