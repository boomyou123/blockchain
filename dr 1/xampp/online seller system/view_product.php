<?php 
include("include/db.php");

$qry="select * from tb_cart as c 
inner join tb_item as i on i.id=c.item_id
where cart_id='".$_GET["id"]."'";
$sttr=mysqli_query($conn,$qry);

?>
<label>Buyer Name:</label>
<label><?php echo $_GET["name"];?></label>
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
<table>
    <thead>
        <th>Image</th>
        <th>SKU</th>
        <th>Price</th>
    </thead>
    <tbody>
    <?php while($row=mysqli_fetch_array($sttr)){ 
    //$amo+=$row["Price"];?>
        <tr>
            <td><img src="<?=$row['image']?>" style="width: 100px;height: 100px;" /></td>
            <td><?=$row["SKU"]?></td>
            <td>RM <?=$row["Price"]?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
