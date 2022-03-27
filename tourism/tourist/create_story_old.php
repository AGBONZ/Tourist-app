<?php include '../includes/header.php';?>
<?php 
if(isset($_POST['country_id'])){
	ob_clean();
	$cr_id = $_POST['country_id'];
	$st = $connect2db->prepare("SELECT id, country_id, name FROM states WHERE country_id=?");
	$st->execute([$cr_id]);

	while($states = $st->fetch()){
		echo "<option value='".$states['id']."'>". $states['name']."</option>";
	}

}elseif(isset($_POST['state_id'])){
	ob_clean();
	$st_id = $_POST['state_id'];
	$ct = $connect2db->prepare("SELECT id, state_id, name FROM cities WHERE state_id=?");
	$ct->execute([$st_id]);

	while($cities = $ct->fetch()){
		echo "<option value='".$cities['id']."'>". $cities['name']."</option>";
	}
	exit();

}else{
	echo "<script>error_noti('Invalid Selection')</script>";
}


?>

<!--start page wrapper -->

	<!-- <script type="text/javascript" src="../assets/plugins/ckeditor/ckeditor.js"></script> -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-0">
			<div class="breadcrumb-title pe-3">Hi !</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item active" aria-current="page">Create New Story.</li>
					</ol>
				</nav>
			</div>
			
		</div>
		<small> Create and manage story for visitors ...</small> <hr>
		<!--end breadcrumb-->
	  
		<div class="card">
		  <div class="card-body p-4">
			  <h5 class="card-title">Input Story Info</h5>
			  <hr/>
			<form method="POST" enctype="multipart/form-data" id="story_form">
               <div class="form-body mt-4">
			    <div class="row">
				   <div class="col-lg-">
				  
                   <div class="border border-2 p-4 rounded">

					<div class="mb-3">
						<label for="inputStoryTitle" class="form-label">Title</label>
						<input type="text" class="form-control" id="inputStoryTitle" placeholder="Enter story title" name="title">
					  </div>
					  <div class="mb-3">
						<label for="inputStoryDescription" class="form-label">Description</label>
						<textarea class="form-control" id="editor1" rows="3" name="description"></textarea>
						 <script>
		                    CKEDITOR.replace( 'editor1' );
		                </script>
					  </div>
					  <div class="row mb-3">
					  	<label> Location</label>
					  	<div class="col-lg-4">
					  		<label for="inputCountry" class="form-label">&nbsp;</label>
						<select class="form-select" id="inputCountry" name="country">
							<option selected value=""> -- Select Country -- </option>
							<?php
								$ctr = $connect2db->prepare("SELECT id, name FROM countries");
								$ctr->execute();
								while ($country = $ctr->fetch()){?>
									<option value="<?php echo $country['id'] ?>"><?php echo $country['name'] ?></option>

								<?php }
							?>
						  </select>
					  </div>
					  <div class="col-lg-4">
						<label for="inputState" class="form-label">&nbsp;</label>
						<select class="form-select" id="inputState" name="state">
							<option selected value=""> -- Select State -- </option>
						  </select>
					  </div>
					  <div class="col-lg-4">
						<label for="inputCity" class="form-label">&nbsp;</label>
						<select class="form-select" id="inputCity" name="city">
							<option selected value=""> -- Select City -- </option>
						  </select>
					  </div>
					  </div>
					  <div class="mb-3">
						<label for="inputProductDescription" class="form-label">Story Media</label>
						<input id="image-uploadify" type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx," name="media" class="form-control" multiple onchange="preview()">
						<iframe src="" id="frame" width="100px" height="150px"></iframe>
					  </div>
					  <div class="mb-3">

					  	<button type="submit" name="submit" class="btn btn-primary story_btn"> SUBMIT DETAILS </button>
					  </div>
					</form>
                    </div>
				   </div>
				 
			   </div><!--end row-->
			</div>
		  </div>
	  </div>


	</div>
</div>
<!--end page wrapper -->
<?php include '../includes/footer.php';?>	
<?php

// Create Story Code 
if(isset($_POST['submit'])){

    if(!isset($_POST['title']) || empty($_POST['title'])){ 
        echo "<script>error_noti('Story Title Required');window.location='create_story';</script>";
    }if(!isset($_POST['description']) || empty($_POST['description'])){
        echo "<script>error_noti('Story Description Required');window.location='create_story';</script>";
    }if(!isset($_POST['country']) || empty($_POST['country'])){
        echo "<script>error_noti('Country Required');window.location='create_story';</script>";
    }if(!isset($_POST['state']) || empty($_POST['state'])){
        echo "<script>error_noti('State Required');window.location='create_story';</script>";
    }else{
	$title = check_input($_POST['title']);
	$description = check_input($_POST['description']);
	$country = check_input($_POST['country']);
	$state = check_input($_POST['state']);
	$city = check_input($_POST['city']);
	$date = date('Y-m-d H-m-s');
	$status = 0;
	$published = 0;
	$story_id = generateRandomString();
	// echo $story_id; 

	
if(is_uploaded_file($_FILES['media']['tmp_name'])){
        $medFile = $_FILES['media']['name'];
        $tmp_dir = $_FILES['media']['tmp_name'];
        $medSize = $_FILES['media']['size'];

        $sql = $connect2db->prepare("SELECT title, description FROM story WHERE title=? AND description=?");
        $sql->execute([$title, $description]);

            if($sql->rowcount() > 0){
                echo "<script>error_noti('Story Info Already Exist !!!');window.location='create_story';</script>";
            }else{
                $path = "file";
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                $upload_dir = 'file/'; // upload directory

                $medExt = strtolower(pathinfo($medFile, PATHINFO_EXTENSION)); // get media extension
                // valid media extensions
                $valid_extensions = array('pdf', '.doc', 'docx', 'audio','docx','video', 'jpg', 'jpeg', 'png', 'GIF'); // valid extensions

                // rename uploading image
                $medilContent = rand(1000,1000000).".".$medExt;

                // allow valid image file formats
                if(in_array($medExt, $valid_extensions)){           
                        // Check file size '150MB'
	                if($medSize < 15000000){
	                	$process_media = $connect2db->prepare("INSERT INTO story(title, description, country_id, state_id, city_id, status, published, user_id, story_id, media_file) VALUES(?,?,?,?,?,?,?,?,?,?)");
	                	$process_media->execute([$title,$description,$country,$state,$city,$status,$published, $id, $story_id, $medilContent]);
	                    if($process_media){
	                        move_uploaded_file($tmp_dir,$upload_dir.$medilContent);
	                        echo "<script>success_noti('Story Successfully Created :)');;window.location='create_story';</script>";
	                        }else{
	                            echo "<script>error_noti('Oops, Error occured while processing the request');window.location='create_story';</script>";
	                            }
	                        }else{
	                        	echo "<script>error_noti('Oops, File too large');window.location='create_story';</script>";
	                        }
                    }else{
                    	echo "<script>error_noti('Oops, Not a valid file extension');window.location='create_story';</script>";
                        
                }
                    }
        }else{
        	echo "<script>error_noti('Media File is Required :)');;window.location='create_story';</script>";
        }
    }
}

function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = str_shuffle($characters);
    $randomString = substr($charactersLength, 0,5);
    return $randomString;
}
?>