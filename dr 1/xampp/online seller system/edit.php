<?php
include_once('include/db.php');

//check if button register is click
if(isset($_POST['edit']) && isset($_GET['id'])){
    //if image is not empty
    if(!empty($_FILES['image']['name']))
    {   
        //take the image extensions
        $ext = explode('.', $_FILES['image']['name']);
        //change the extensions to lower cases
        $ext = strtolower(array_pop($ext));
        //set the image path and name
        $file = 'img/'.date('YmdHis').'.'.$ext;
        //check the extension type
        if(($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png')){ 
            $target_path = $file;
        }else{
            $error_ext = 1;
        }
        //check the file is exists in img folder or not
        if(file_exists($file)){
            $file_exists = 1;
        }
    //if image is empty
    }elseif(empty($_FILES['image']['name'])){
        
        $file = $_POST['old_img'];
    }
    if(isset($error_ext)){
        echo "<script>alert('Please upload .jpg, .jpeg or .png file only.')</script>"; 
    }elseif(isset($file_exists)){
        echo "<script>alert('Image already exists, please choose another image or change the image name.')</script>"; 
    }elseif(isset($target_path) && !move_uploaded_file($_FILES['image']['tmp_name'], $target_path)){
        echo "<script>alert('Image failed to upload image')</script>";  
    }else{
        //get the data using $_POST[], inside the $_POST[] is the name inside the input tag
        $image=$file;
        $sku=$_POST['sku'];
        $quantity=$_POST['quantity'];
        $Price=$_POST['price'];
        
        //update user query
        $Query="UPDATE tb_item SET image='$image',SKU='$sku',Quantity='$quantity',Price='$Price' WHERE id = '".$_GET['id']."'";
        //check if the query run success then messagebox will show
        if($result=mysqli_query($conn,$Query)){     
            echo "<script>window.location.href = 'index.php';
                alert('Record Success to Edit');
                </script>";     
        //messagebox will show when users fail to edit
        }else{          
            echo "<script>alert('Record Fails to Edit')</script>";
        }
    }
}
?>

<?php
$qry = "SELECT * FROM tb_item WHERE id='".$_GET['id']."'";
$sql = mysqli_query($conn, $qry);
$row = mysqli_fetch_array($sql);
?>
<div class="container">
    <form class="form-horizontal" action="edit.php?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">
        <div>
            <label>Image</label>
            <div>
                <input type="file" name="image" accept="image/*" onchange="loadFile(event)">
            </div>
        </div>
        <div>
        	<label>SKU</label>
            <div>
            	<input type="text" name="sku" placeholder="SKU" value="<?=$row['SKU']?>" required>
            </div>
        </div>
        <div>
        	<label>Quantity</label>
            <div>
            	<input type="number" name="quantity" placeholder="Quantity" value="<?=$row['Quantity']?>" required>
            </div>
        </div>
        <div>
        	<label>Price (RM)</label>
            <div>
            	<input type="text" name="price" placeholder="RM" value="<?=$row['Price']?>" required>
            </div>
        </div>
        <br />
        <div>
            <div>
                <button type="submit" name="edit" value="edit">Submit</button>
                <button type="button" onclick="window.location.href='index.php'">Back</button>
            </div>
        </div>
    </form>
</div>

<style>

body{background-color: lightgreen;}

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