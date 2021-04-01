<?php 
include("include/db.php");

$qry="select * from checkout";
$sttr=mysqli_query($conn,$qry);

if(isset($_POST["sub"])){
    $up="update checkout set tracking_num='".$_POST["trc"]."' where id='".$_POST["sub"]."'";
    if ($sttr_up=mysqli_query($conn,$up)) {
        echo "<script>window.location.href = 'view_cart_admin.php';
        alert('Successfully upload.');</script>";
    //messagebox will show when users fail to edit
    }else{
        echo "<script>window.location.href = 'view_cart_admin.php';
        alert('Failed upload.');</script>";
    }

}
?>
<style>
th, td{
    border: 2px solid black;
    padding:8px;
}

body{background-color: lightgreen;}

button{
    background-color:initial;
    background-color: lightgreen;
    color:green;
}
    
</style>
<a href='index.php'><button type="button">Back</button></a>
<form action="view_cart_admin.php" method="post"  enctype="multipart/form-data" >
<table>
            <thead>
            <th>Cart list</th>
                <th>Payment</th>
                <th>Amount</th>
                <th>receipt</th>
                <th>Address</th>
                <th>Tel</th>
                <th>Buyer Name</th>
                <th>Action</th>
                <th>Tracking Number</th>
            </thead>
            <tbody>
            <?php while($row=mysqli_fetch_array($sttr)){ 
                ?>
                <tr>
                <td><a href="view_product.php?id=<?=$row["cart_id"]?>&&name=<?=$row["username"]?>" target="_blank">View Product</a></td>
                    <td><?=$row["payment"]?></td>
                    <td>RM <?=$row["amount"]?></td>
                    <td><button type="button" onclick="view(this.value)" value="<?=$row["receipt"]?>">view receipt</button></td>
                    <td><?=$row["address"]?></td>
                    <td><?=$row["tel"]?></td>
                    <td><?=$row["username"]?></td>
                    <td><button type="submit" name="sub" value="<?php echo $row["id"];?>">Approve</button></td>
                    <td><?=$row["tracking_num"]?></td>
                </tr>
            <?php } ?>
            </tbody>
</table>
<br>
<br>
<label>Tracking Number</label>

<input type="text" name="trc" placeholder="tracking number"  />
<br>
<br>
<div id="receipt">

</div>
</form>
<script>
function view(img){
    var a=document.getElementById("receipt");
    a.innerHTML="<img src='"+img+"' style='width:300px; height:400px;' />";
}
</script>