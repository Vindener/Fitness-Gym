<?php
    $Name_File= $_FILES['myFile']['name'];
    $imgext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $Name_File));

    if($imgext == 'jpeg' || $imgext == 'jpg' || $imgext == 'png')
    {
        $Tmp_Name=$_FILES['myFile']['tmp_name'];
        $newfilename = $id_user_img.'.'.$imgext;
        $uploaddir = '../../images/trainer/';
        $uploadfile = $uploaddir.$newfilename;
        move_uploaded_file($Tmp_Name, $uploadfile);
        $update = mysqli_query($connect, "UPDATE Trainers SET photo = '$newfilename' WHERE `trainer_id` = '$id_user_img'");
    }
?>
