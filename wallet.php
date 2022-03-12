<?php
session_start();

$pageTitle = 'Cart';

include 'init.php';

if(isset($_SESSION['user'])){

    if(isset($_POST['add'])){
        $deposit = $_POST['deposit'];
        $userid = $_SESSION['uid'];
        $resultData = $db->save("wallet", "VALUES(NULL, '".$userid."', '".$deposit."', 0, now())");
        if($resultData){
            header("location: wallet.php");
        }else{
            echo 'error';
        }
    }else{
        echo '';
    }
?>

    <div class="container mt-4">
        <h1 class="text-title mb-5"><i class="fa fa-angellist"></i> Welcome to your wallet</h1>
        <div class="row p-4 wallet">
            <div class="col-sm-6">
                <div class="card-header border-0 row bg-transparent mb-3">
                    <h1 class="fs-4 mb-3 text-muted">Wallet information</h1>
                    <h1 class="text-title fs-3 text-muted"><i class="fa fa-user text-info"></i> <?php echo $_SESSION['user'] ?></h1>
                </div>
                <?php
                $user = $_SESSION['uid'];
                $payments = $db->getAllTable("SUM(total) as sum", "wallet", "where userid = $user", '', "ID");
                $withdraws = $db->getAllTable("SUM(withdraw) as sum2", "withdraw", "where userid = $user", '', "ID");
                $payment = mysqli_fetch_assoc($payments);
                $withdraw = mysqli_fetch_assoc($withdraws);
                $result = $payment['sum'] - $withdraw['sum2'];
                $user = $db->saveUpdate("users", "total = $result", "UserID = '".$_SESSION['uid']."'");
                $userSession = $_SESSION['uid'];
                $userTotal = $db->getAllTable("total", "users", "where UserID = $userSession", '', "UserID");
                $total = mysqli_fetch_assoc($userTotal);
                // $sum = count('total');
                ?>
                <div class="card-body row mb-3">
                    <?php 
                    // while($row = $rows->fetch_column()){?>
                    <div class="col-sm-6">
                        <h2 class="text-info mb-0"><i class="fa fa-cc-diners-club"></i> <?php echo $total['total'] ?></h2>
                        <p class="ms-4 mt-0">Remaining balance</p>
                    </div>
                    <?php ?>
                    <div class="col-sm-6">
                        <h2 class="text-primary mb-0"><i class="fa fa-cc-mastercard"></i> 6567587 </h2>
                        <p class="ms-4 mt-0">Drawing balance</p>
                    </div>
                </div>
                <div class=" row card-footer bg-transparent">
                    <div class="col-sm-5">
                        <div class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">Deposit</div>
                    </div>
                    <div class="col-sm-5">
                        <div class="btn btn-primary">Withdrawal</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6 d-flex justify-content-center align-items-center">
                        <div class="circle rounded-circle border-info">
                            <h1 class="fs-4">%70</h1>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h1 class="fs-6 mb-0"><i class="fa fa-calendar text-primary"></i> 02/13/2022</h1>
                        <p class="text-muted mt-0">Fulled: $300</p>
                        <h1 class="fs-6 mb-0"><i class="fa fa-calendar text-primary"></i> 01/18/2022</h1>
                        <p class="text-muted mt-0">Fulled: $500</p>
                        <h1 class="fs-6 mb-0"><i class="fa fa-calendar text-primary"></i> 12/13/2021</h1>
                        <p class="text-muted mt-0">Fulled: $100</p>
                        <h1 class="fs-6 mb-0"><i class="fa fa-calendar text-primary"></i> 05/13/2020</h1>
                        <p class="text-muted mt-0">Fulled: $300</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Deposit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal main-form" action="wallet.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Deposit</label>
                            <div class="col-sm-10 col-md-10">
                                <input class="form-control" type="text" name="deposit">
                                <input type="submit" name="add" value="add" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
}else{
    $TheMsg = '<div class="alert alert-danger">Sorry Can you login and return</div>';
    redirectHome($TheMsg);
}
include $tepl . 'footer.php';
?>