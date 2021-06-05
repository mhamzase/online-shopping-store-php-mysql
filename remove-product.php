<?php
    include "connection.php";
    
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        
        $result = mysqli_query($conn, "SELECT image FROM products WHERE id = '$id'");
        $row = mysqli_fetch_array($result);
       
        mysqli_query($conn,"DELETE FROM products WHERE id = $id");
        unlink($row['image']);

        header("Location: manage-products.php");
    }
    else{
        header("Location: login.php");
    }

?>