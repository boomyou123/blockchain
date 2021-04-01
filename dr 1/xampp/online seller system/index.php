<?php
//Add db page code come in
include_once('include/db.php');

//Select all item query
$qry = "SELECT * FROM tb_item";
//Connect database
$sql = mysqli_query($conn, $qry);

if (isset($_POST['submit'])) {
    $search=$_POST['select'];
    $qry1="SELECT * FROM tb_item WHERE $search like '%" .$_POST['search_data']."%'";
    $sql=mysqli_query($conn,$qry1);
}

//check if button delete is click
if(isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete'){
	//get the data using $_GET[], inside the $_GET[] is the name on the url
	$id=$_GET['id'];
	//delete user query
	$Query="DELETE FROM tb_item WHERE id='$id'";
	//check if the query run success then messagebox will show
	if($result=mysqli_query($conn,$Query)){
        //go to index page and show a message box
		echo "<script>window.location.href = 'index.php';
			  alert('Record Successfully Delete');
			  </script>";
	//messagebox will show when users fail to delete
	}else{
		echo "<script>alert('Record Fails to Delete')</script>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>

<style>
table{
    border-collapse: collapse;
     width: 100%;
 }

th, td{
    border: 5px solid lightblue;
    padding:10px;
    text-align: center;
}

body{
    color: lightblue;
    background-image: url('img/01.png');
}

button{
    background-color:initial;
    background-color: lightblue;
    color:blue;
    text-align: center;
}
.www{
    float: right;
}
    
</style>

</head>

<body>
    <div class="www">
<?php if($_SESSION['permission']=="Seller"){?>
    <button type="button" onclick="window.location.href='add.php'">Add New</button>
    <button type="button" onclick="window.location.href='view_cart_admin.php'">view cart</button>
    <button type="button" onclick="window.location.href='login_page.php'">Log out</button>
    <?php }else{?>
    <button type="button" onclick="window.location.href='login_page.php'">Log out</button>
    <button type="button" onclick="window.location.href='view_cart.php'">view cart</button>
    <?php } ?>
</div>
<br>
<br>

<form action="index.php" method="post" enctype="multipart/form-data">
<div class="blocks">
    <div class="block">
        <select name="select">
            <option value="SKU">SKU</option>

            <option value="Quantity">Quantity</option>

            <option value="Price">Price</option>

        </select>
        <input type="text" class="empty" placeholder="&#xf002; search" name="search_data">
        <button type="submit" name="submit">submit</button>
    </div>
</div>

</form>

<?php
if ($_SESSION['permission']=='Seller') { ?>  
    <table>
    	<thead>
            <th>Image</th>
            <th>SKU</th>
            <th>Table</th>
            <th>Price</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody id="item_table_all">
        <?php while($row = mysqli_fetch_array($sql)){?>
            <tr>

                <td><img src="<?=$row['image']?>" style="width: 100px;height: 100px;" ></td>
            	<td><?=$row['SKU']?></td>
            	<td><?=$row['Quantity']?></td>
            	<td>RM <?=$row['Price']?></td>
            	<td>
                    <button type="button" onclick="window.location.href='edit.php?id=<?=$row['id']?>'">Edit</button>
                </td>
            	<td>
                    <a href="index.php?id=<?=$row['id']?>&action=delete" onclick="return confirm('Are you sure you want to Delete?');">
                        <button type="button">Delete</button>
                    </a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    <?php }else{?>
    <table>
        <thead>
            <th>Image</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Action</th>
        </thead>
        <tbody id="item_table">
        <?php while($row = mysqli_fetch_array($sql)){?>
            <tr>

                <td><img src="<?=$row['IMAGE']?>" style="width: 100px;height: 100px;"></td>
                
                <td><?=$row['SKU']?></td>

                <td>RM <?=$row['Price']?></td>

                <td><button type="button" onclick="window.location.href='cart.php?id=<?=$row['id']?>'" >Buy</button></td>

            </tr>
        <?php }?>
        </tbody>
    </table>
    <?php }?>
    <script>
    $(document).ready(function(){
        $('#search').keyup(function(){
            search_table($(this).val());
        });
        function search_table(value){
            $('#employee_table tr').each(function(){
                var found='false';
                $(this).each(function(){
                    if ($(this).text().toLowerCase().indexOf(value.toLowercase())>=0)
                    {
                        found='true';
                    }
                });
                if (found=='true'){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }
    });
</script>
</body>
</html>
