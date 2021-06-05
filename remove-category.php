<?php
    include "connection.php";
    
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $sql = "DELETE FROM categories WHERE id = $id";
        mysqli_query($conn,$sql);
        header("Location: manage-categories.php");
    }
    else{
        header("Location: login.php");
    }

?>