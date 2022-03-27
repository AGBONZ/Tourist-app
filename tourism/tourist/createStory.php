<?php
session_start();
include '../includes/connection.php';

// Create Story Code 
if(isset($_POST['submit'])){

    if(!isset($_POST['title']) || empty($_POST['title'])){ 
        echo "<script>alert('Story Title Required');window.location='create_story';</script>";
    }if(!isset($_POST['description']) || empty($_POST['description'])){
        echo "<script>alert('Story Description Required');window.location='create_story';</script>";
    }if(!isset($_POST['country']) || empty($_POST['country'])){
        echo "<script>alert('Country Required');window.location='create_story';</script>";
    }if(!isset($_POST['state']) || empty($_POST['state'])){
        echo "<script>alert('State Required');window.location='create_story';</script>";
    }else{
	$title = check_input($_POST['title']);
	$description = check_input($_POST['description']);
	$country = check_input($_POST['country']);
	$state = check_input($_POST['state']);
	$city = check_input($_POST['city']);
	$date = date('Y-m-d H-m-s');
	$status = 0;
if(is_uploaded_file($_FILES['media']['tmp_name'])){
        $medFile = $_FILES['media']['name'];
        $tmp_dir = $_FILES['media']['tmp_name'];
        $medSize = $_FILES['media']['size'];
        $sql = $connect2db->prepare("SELECT title, description  FROM story WHERE title=? || description=?");
            $sql->execute([$title,$description]);
            if($sql->rowcount() > 0){
                echo "<script>alert('Story Info Already Exist !!!');window.location='create_story';</script>";
            }else{
                $path = "file";
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                $upload_dir = 'file/'; // upload directory

                $medExt = strtolower(pathinfo($medFile, PATHINFO_EXTENSION)); // get media extension
                // valid media extensions
                $valid_extensions = array('pdf', '.doc', 'docx', 'audio','docx','video','ppt','pptx'); // valid extensions

                // rename uploading image
                $medilContent = rand(1000,1000000).".".$medExt;

                // allow valid image file formats
                if(in_array($medExt, $valid_extensions)){           
                        // Check file size '150MB'
                if($medSize < 15000000){
                	$process_media = $connect2db->prepare("INSERT INTO story(title, description, country_id, state_id, city_id, status, media_file) VALUES(?,?,?,?,?,?,?)");
                	$process_media->execute([$title,$description,$country,$state,$city,$status,$medilContent]);
                            if($process_media){
                                move_uploaded_file($tmp_dir,$upload_dir.$medilContent);
                                echo "<script>alert('Story Successfully Created :)');;window.location='create_story';</script>";
                                }else{
                                    echo "<script>alert('Oops, Error occured while processing the request');window.location='create_story';</script>";
                                    }
                                }
                            }
                        
                }
            }
    }
}


function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
 ?>