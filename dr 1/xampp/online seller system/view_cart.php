<?php
include_once('include/db.php');

$qry="SELECT * FROM checkout";
$sttr=mysqli_query($conn,$qry);

if(isset($_POST["btn"])){
    if(!empty($_FILES['image']['name']))
	{	
		//take the image extensions
		$ext = explode('.', $_FILES['image']['name']);
		//change the extensions to lower cases
		$ext = strtolower(array_pop($ext));
		//set the image path and name
		$file = 'receipt/'.date('YmdHis').'.'.$ext;
		//check the extension type
		
		$target_path = $file;
		
		//check the file is exists in img folder or not
		if(file_exists($file)){
			$file_exists = 1;
		}
	}
	if(isset($error_ext)){
		echo "<script>alert('Please upload .jpg, .jpeg or .png file only.')</script>"; 
	}elseif(isset($file_exists)){
		echo "<script>alert('Image already exists, please choose another image or change the image name.')</script>"; 
	}elseif(isset($target_path) && !move_uploaded_file($_FILES['image']['tmp_name'], $target_path)){
		echo "<script>alert('Image failed to upload image')</script>";  
	}else{
		//get the data using $_POST[], inside the $_POST[] is the name inside the input tag
		
		//insert item query
		$up=mysqli_query($conn,"update checkout set payment='YES' ,receipt='".$target_path."' where id='".$_POST["btn"]."'");
		//check if the query run success then messagebox will show
		if ($result=mysqli_query($conn,$qry)) {
			echo "<script>window.location.href = 'view_cart.php';
			alert('Successfully upload.');</script>";
		//messagebox will show when users fail to edit
		}else{
			echo "<script>window.location.href = 'view_cart.php';
			alert('Failed upload.');</script>";
		}
	}
    
}
?>
<style>
th, td{
    border: 2px solid black;
    padding:8px;
}
input{
    font-size: 13px;
    text-align: 16px；
    font-family: cursive;
}
#product{

}
body{background-color: lightgreen;}

</style>
<a href='index.php'><button type="button">Back</button></a>
<form action="view_cart.php" method="post"  enctype="multipart/form-data" >
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
                <th>tracking Number</th>
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
                    <td><button type="submit" name='btn' value="<?=$row["id"]?>">Upload</button></td>
                    <td><?=$row["tracking_num"]?></td>
                </tr>
            <?php } ?>
            </tbody>
</table>
<br>
<br>
<input type="file" name="image" required />
<div id="receipt">

</div>
<div id="product">

</div>
</form>
<script>
function view(img){
    var a=document.getElementById("receipt");
    a.innerHTML="<img src='"+img+"' style='width:300px; height:400px;' />";
}
</script>