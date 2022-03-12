<?php
session_start();

include 'init.php';

if(isset($_GET['cart']) == 'add'){
    $id = $_GET['id'];
    if(isset($_SESSION['mycart'][$id])){
        $provi = $_SESSION['mycart'][$id]['quantity'];
        $_SESSION['mycart'][$id] = array(
            "itemid" => $id,
            "quantity" => $provi+$_POST['quantity']);
    }else{
        $_SESSION['mycart'][$id] = array(
            "itemid"=>$id,
            "quantity"=> $_POST['quantity']
        );
    }
    header("location: index.php");
}
?>

<div class="container">
    <h1 class="text-title">
        <?php
        if(isset($_SESSION['mycart'])){
            echo "<a href='cart.php'>" . count($_SESSION['mycart']) . "</a>";
        }else{
            echo 0;
        }
        ?>
    </h1>
    <a href="newad.php" class="btn btn-primary">Add</a>
    <div class="row row-cols-1 col-items row-cols-md-4 rwo-cols-sm-2">
        
        <?php  
        $result = $db->getItems();
            while($item = mysqli_fetch_assoc($result)){
                
                ?>
                <form action="index.php?cart=add&id=<?php echo  $item['ItemID']?>" method="POST">
                    <input type="hidden" name="quantity" value="1">
                    <div class="card">
                        <div class="card-header">
                            <span class='price-items'>$<?php echo  $item['Price']?></span>
                            <div class='img-items'>
                                <?php echo "<img src='dashboard/upload/images/" . $item['image'] ."' alt='' class='img-fluid'>";?>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3><a href='items.php?itemid=<?php echo $item['ItemID']?>'> <?php echo $item['Name']?></a></h3>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="submit" value="Add to cart" class="btn btn-danger">
                        </div>
                    </div>
                </form>
            <?php }?>
    </div>


</div> 

<?php
include $tepl . 'footer.php';
?>