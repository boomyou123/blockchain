<?php 
include('include/db.php');
if(isset($_GET["id"])){
    $insert="insert into tb_cart(item_id,user_id,p_status) values('".$_GET["id"]."','".$_SESSION["id"]."','PENDING')";
    $str_in=mysqli_query($conn,$insert);
}
$amo=0;
$qry="select * from tb_cart as c 
inner join tb_item as i on i.id=c.item_id
where c.user_id='".$_SESSION["id"]."' and c.p_status='PENDING'";
$sttr=mysqli_query($conn,$qry);

if(isset($_POST["sub"])){
    $qry="SELECT id FROM cartid";
    $select=mysqli_query($conn,$qry);
    $row=mysqli_fetch_array($select);
    $id=$row[0];
    $id++;
    $qry="INSERT INTO checkout(cart_id,payment,amount,receipt,address,tel,username,user_id) values($id,'NO','".$_POST["amo"]."','','".$_POST['address']."','".$_POST['tel']."','".$_POST["rec"]."','".$_SESSION["id"]."')";
    if($sttr_cart=mysqli_query($conn,$qry)){
        $update="UPDATE tb_cart set p_status='CHECKOUT', cart_id='".$id."' where p_status='PENDING'";
        $sttr_up=mysqli_query($conn,$update);
        $updateid="UPDATE cartid set id='$id'";
        $id_up=mysqli_query($conn,$updateid);
        echo "<script>alert('checkout success')
        window.location.href='cart.php'
        </script>";
    }else{
        echo "<script>alert('checkout fail')
        window.location.href='cart.php'
        </script>";
    }
    
    
}
if(isset($_POST["del"])){
    $query="delete from tb_cart where id='".$_POST["del"]."'";
    $del=mysqli_query($conn,$query);
    echo "<script>alert('delete success')
    window.location.href='cart.php'
    </script>";
    
}


?>
<style>
th, td{
    border: 2px solid black;
    padding:8px;
}
body{
    background-color: lightgreen;
}
button{
    background-color:initial;
    background-color: lightgreen;
    color:green;
}
input{
    background-color:initial;
    background-color: lightgreen;
    color:green;
}
    
</style>
<form action="cart.php" method="post">
<a href="index.php"><button type="button">Back</button></a>
    <div style="width:45%;">
        <table>
            <thead>
                <th>Image</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Action</th>
            </thead>
            <tbody>
            <?php while($row=mysqli_fetch_array($sttr)){ 
                $amo+=$row["Price"];
                ?>
                <tr>
                    <td><img src="<?=$row['image']?>" style="width: 100px;height: 100px;" /></td>
                    <td><?=$row["SKU"]?></td>
                   
                    <td>RM <?=$row["Price"]?></td>
                    <td><button type="submit" value='<?=$row[0]?>' name="del" >Delete</button></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</form>
<form action="cart.php" method="post">
    <div style="width:50%; float:right; left:50%; top:10%;   position:absolute; ">
    <button type="submit" style="float:right;" name="sub" >checkout</button>
    <br>
            <fieldset>
                <label>Amount(RM):</label><br>
                <input type="text" readonly name="amo" value="<?php echo $amo;  ?>" />
                <legend>checkOut</legend>
                <label>Destination address</label><br>
                <textarea name="address" required style="width:100%; height:50px;" ></textarea>
                <br>
                <br>
                <label>Tel:</label><br>
                <input type="text" name="tel" required placeholder="tel" />
                <br>
                <br>
                <label>Receiver Name:</label><br>
                <input type="text" name="rec" required placeholder="receiver name"  />
            </fieldset>
    </div>
</form>