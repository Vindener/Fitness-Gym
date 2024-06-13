<?php
    $Name_File= $_FILES['myFile']['name'];
    $imgext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $Name_File));

    if($imgext == 'jpeg' || $imgext == 'jpg' || $imgext == 'png')
    {
        $Tmp_Name=$_FILES['myFile']['tmp_name'];
        $newfilename = $id_user_img.'.'.$imgext;
        $uploaddir = '../../images/products/';
        $uploadfile = $uploaddir.$newfilename;
        move_uploaded_file($Tmp_Name, $uploadfile);
        $update = mysqli_query($connect, "UPDATE Products SET image = '$newfilename' WHERE `product_id` = '$id_user_img'");
    }
?>
