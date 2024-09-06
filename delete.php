<?php

    $id="";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    require_once("book.class.php");
    $obj = new Book();

    if($obj->delete($id)){
        echo "success";
    }
    else{
        echo "failed";
    }


