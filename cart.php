<?php
session_start();

$pageTitle = 'Cart';

include 'init.php';
// if(isset($_SESSION['mycart']) == $_SESSION['user']){
if(isset($_POST['py'])){
    $payment = $_POST['cart'];
    $user = $_SESSION['uid'];
    $rows = $db->getAllTable("total", "users", "where UserID = $user", '', "UserID");
    $row = mysqli_fetch_assoc($rows);
    if($payment <= $row['total']){
        $withdraw = $payment;
        $withdraws = $db->save("withdraw", "VALUES(null,'".$_SESSION['uid']."','".$withdraw."', now())");
        // session_destroy();
        unset($_SESSION['mycart']);
        $TheMsg = "<div class='alert alert-success'> Payment Success</div>";
        redirectHome($TheMsg);
    }else{
        $TheMsg = "<div class='alert alert-danger'> Error</div>";
        redirectHome($TheMsg, 'back');
    }
}

elseif(isset($_GET['do']) == 'update'){
    $id = $_GET['id'];
    if(isset($_SESSION['mycart'][$id])){
        $provi = $_SESSION['mycart'][$id]['quantity'];
        if($_POST['quantity'] < $provi){
            $_SESSION['mycart'][$id] = array(
                "itemid" => $id,
                "quantity" => $provi-$_POST['quantity']);
                
        }
        header("location: cart.php");
        exit();
    }
    
}elseif(isset($_GET['delete'])){
    $id = $_GET['delete'];
    unset($_SESSION['mycart'][$id]);
    header("location: cart.php");
}
?>

<div class="container view-item">
    <h1 class="text-title">
        <?php
        if(isset($_SESSION['mycart'])){
            echo count($_SESSION['mycart']);
        }else{
            echo 0;
        }
        ?>
    </h1>
    <div class="row d-flex justify-content-between align-items-start">
        <?php
        $total = 0;
        foreach($_SESSION['mycart'] as $key => $value){
            $rows = $db->getItems("WHERE ItemID = $key");
            while($row = mysqli_fetch_assoc($rows)){
                $total += $value['quantity'] *  $row['Price'];
            ?>
            
            <div class="row mb-2 p-2 border d-flex justify-content-between col-sm-8">
                <div class="col-sm-3 position-relative fw-bold">
                    <span class='price-items py-2 px-3 text-white'>$<?php echo $value['quantity'] *  $row['Price']?></span>
                    <div class='img-items'>
                        <?php echo "<img src='dashboard/upload/images/" . $row['image'] ."' alt='' class='img-fluid'>";?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h1><a href='#'> <?php echo $row['Name']?></a></h1>
                    <p><?php echo $row['Description']?></p>
                    <p>Quantity: <?php echo $value['quantity']?></p>
                    
                </div>
                <div class="col-sm-3">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $value['itemid']?>">Edit</a>
                    <a href="?delete=<?php echo $key?>" class="btn btn-danger">Delete</a>
                </div>
            </div>
            <div class="modal fade" id="exampleModal<?php echo $value['itemid']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal main-form" action="cart.php?do=update&id=<?php echo $value['itemid'] ?>" method="POST" enctype="multipart/form-data">
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Edit Quantity</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input class="form-control" type="text" name="quantity" value="<?php echo $value['quantity']?>">
                                        <input type="submit" name="submit" value="edit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <?php
                
                ?>
            </div>
        <?php }}?>
        <div class="col-sm-3">
            <div class="card">
                <h1 class="card-header"><?php echo $total ?></h1>
                <div class="card-body">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cartModal">Payment</a>
                </div>
                <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal main-form" action="cart.php?do=payment" method="POST" enctype="multipart/form-data">
                                    <div class="mb-2 row">
                                        <label class="col-sm-2 col-form-label">Visa Cart</label>
                                        <div class="col-sm-10 col-md-10">
                                            <input class="form-control" type="text" >
                                            <input class="form-control" type="text" name="cart" value="<?php echo $total?>">
                                            <input type="submit" name="py" value="Payment" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <?php
                    
                    ?>
                </div>
            </div>
        </div>
    </div>
</div> 

<?php

include $tepl . 'footer.php';
?>