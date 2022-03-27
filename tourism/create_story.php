<?php include 'includes/adm-header.php';
$category_id = "";

if (isset($_POST['submit'])) {
		$tmp_dir = $_FILES['file']['tmp_name'];
		$imgFile = $_FILES['file']['name'];
		$file_type = $_FILES['file']['type'];
		$cat_id = $_POST['category'];
		$title = $_POST['title'];
		$desc = $_POST['description'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		$city = $_POST['city'];
		$features = explode(',', $_POST['features']);
		$status = 1;
		$slug = $_POST['slug'];
		$created = date('Y:M:D H:i:s');
		if (!is_dir('story_files')) {
            mkdir('story_files');
        }
		$upload_dir = 'story_files/';

		// echo $desc;


		$createStory = $connect2db->prepare("INSERT INTO story (title, category_id, description, slug, country_id, state_id, city_id, status, created_at, user_id)VALUES(?,?,?,?,?,?,?,?,?,?)");
		$createStory->execute([$title, $cat_id, $desc, $slug, $country, $state, $city, $status, $created, $id]);
		if ($createStory) {
			$story_id = $connect2db->lastInsertId();
			foreach ($features as $i => $feature) {
				$insertFeatures = $connect2db->prepare("INSERT INTO story_features (story_id, features)VALUES(?,?)");
				$insertFeatures->execute([$story_id, $feature]);
			}

			
			foreach ($tmp_dir as $i => $file) {
				$file_ext = strtolower(pathinfo($imgFile[$i], PATHINFO_EXTENSION));
				// echo "<script>alert('$file);</script>";
				$newName = rand(00000000, 99999999);
				$newFile = $newName.'.'.$file_ext;
				$newFile_type = explode('/', $file_type[$i])[0];
				move_uploaded_file($file, $upload_dir.$newFile);
				$insertFile = $connect2db->prepare("INSERT INTO story_file (story_id,file,type) VALUES (?,?,?)");
				$insertFile->execute([$story_id, $newFile, $newFile_type]);
			}
			echo "<script>alert('Story Created Successfully');</script>";
		} else {
			echo "<script>alert('Error Creating Story');</script>";
		}
		
	}

if (isset($_GET['slug']) && $_GET['slug'] != "" ) {
			$slug = $_GET['slug'];
			$getID = $connect2db->prepare("SELECT s.*, co.name AS country, st.name AS state, ct.name AS city, c.category, u.firstname, u.lastname FROM story AS s JOIN category AS c ON s.category_id = c.id JOIN users AS u ON s.user_id = u.id JOIN countries AS co ON s.country_id = co.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.slug = ?");
			$getID->execute([$slug]);
			if ($getID->rowcount() > 0) {
				$features = '';
				$story_details = $getID->fetch();
				$story_id = $story_details['id'];
				$title = $story_details['title'];
				$date = $story_details['created_at'];
				$category = $story_details['category'];
				$category_id = $story_details['category_id'];
				$desc = $story_details['description'];
				$author = $story_details['firstname']." ".$story_details['lastname'];
				$country = $story_details['country']; 
				$country_id = $story_details['country_id'];
				$state = $story_details['state'];
				$state_id = $story_details['state_id'];
				$city = $story_details['city'];
				$city_id = $story_details['city_id'];
				$status = ($story_details['status']==1) ? ['Published', 'Unpublish'] : ['Unpublised', 'Publish'] ;
				
				$getFeatures = $connect2db->prepare("SELECT features FROM story_features WHERE story_id = ?");
				$getFeatures->execute([$story_id]);
				while ($fea = $getFeatures->fetch()) {
					$features .= $fea['features'].",";
				}
				// echo $features;
			} else {
				echo "<script>window.location='404'</script>";
			}
		
	} 


	function category($category_id){
		include 'includes/connection.php';
		if (isset($_GET['slug'])) {
			$query = "SELECT * FROM category WHERE id != '$category_id' ";
		}else{
			$query = "SELECT * FROM category";
		}
		$output = '';
		$getCat = $connect2db->prepare($query);
		$getCat->execute();
		while ($cats = $getCat->fetch() ) {
			$output .= '<option value="'.$cats['id'].'">'.$cats['category'].'</option>';
		}

		return $output;
	}

	function country(){
		include 'includes/connection.php';
		$output = '';
		$getCat = $connect2db->prepare("SELECT * FROM countries");
		$getCat->execute();
		while ($cats = $getCat->fetch() ) {
			$output .= '<option value="'.$cats['id'].'">'.$cats['name'].'</option>';
		}

		return $output;
	}

	

	if (isset($_POST['update'])) {
		$cat_id = $_POST['category'];
		$title = $_POST['title'];
		$desc = $_POST['description'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		$city = $_POST['city'];
		$features = explode(',', $_POST['features']);
		$status = 1;
		$slug = $_POST['slug'];
		$updated = date('Y:M:D H:i:s');

		$updStory = $connect2db->prepare("UPDATE story SET category_id = ?, title = ?, description = ?, country_id = ?, state_id = ?, city_id = ?, slug = ?, status = ?, updated_at = ? WHERE id = ? ");
		$updStory->execute([$cat_id,$title,$desc,$country,$state,$city,$slug,$status, $updated,$story_id]);
		if ($updStory) {
			$cleanDB = $connect2db->prepare("DELETE FROM story_features WHERE story_id = ?");
			$cleanDB->execute([$story_id]);
			if ($cleanDB) {
				foreach ($features as $i => $feature) {
					$insertFeatures = $connect2db->prepare("INSERT INTO story_features (story_id, features)VALUES(?,?)");
					$insertFeatures->execute([$story_id, $feature]);
				}
			}
			echo "<script>alert('Story Updated');window.location='story_details?slug=$slug'</script>";
		}else {
			echo "<script>alert('Error Updating Story');</script>";
		}
	}

	if (isset($_POST['changeImage'])) {
		$tmp_dir = $_FILES['image']['tmp_name'];
		$imgFile = $_FILES['image']['name'];
		$file_type = $_FILES['image']['type'];
		$file_id = $_POST['id']; 

		$upload_dir = 'story_files/';
		$file_ext = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
		$newName = rand(00000000, 99999999);
		$newFile = $newName.'.'.$file_ext;
		// $newFile_type = explode('/', $file_type)[0];
		if (move_uploaded_file($tmp_dir, $upload_dir.$newFile)) {
			$updImg = $connect2db->prepare("UPDATE story_file SET file = ? WHERE id = ?");
			$updImg->execute([$newFile, $file_id]);
			if ($updImg) {
				echo "<script>alert('Story Updated')</script>";
			}else{
				echo "<script>alert('Error Updating Story')</script>";
			}
		}
	}

	
?>

			  
<div class="card">
  <div class="card-body p-4">
	  <h5 class="card-title">Add New Story</h5>
	  <hr/>
       <div class="form-body mt-4">
	    <form method="post" action="" enctype="multipart/form-data"> 
	    	<div class="row">
		   <div class="col-lg-12">
           <div class="border border-3 p-4 rounded row">
			<div class="col-md-6 mb-3">
				<label for="inputProductTitle" class="form-label">Title</label>
				<input type="text" name="title" onkeyup="createSlug(this.value)"  class="form-control" required id="title" placeholder="Enter Title" value="<?php echo (isset($_GET['slug'])) ? $title : ""?>">
			  </div>

				<input type="hidden" name="slug" value="<?php echo (isset($_GET['slug'])) ? $slug : ""?>" class="form-control" id="slug" readonly>
			  

			  <div class="col-md-6 mb-3">
				<label for="inputProductTitle" class="form-label">Category</label>
				<select name="category" required class="form-control form-select">
					<?php
						if (isset($_GET['slug'])){?>
								<option value="<?php echo $category_id?>"><?php echo $category?></option>
					<?php	}
					?>
					<?php echo category($category_id)?>
				</select>
			  </div>

			  <div class="col-md-4 mb-3">
				<label for="inputProductTitle" class="form-label">Country</label>
				<select required name="country" onchange="getState(this.value)" class="form-control form-select">
					<option <?php echo (!isset($_GET['slug'])) ? 'selected' : ""?> disabled value=""> -- Select Country -- </option>
					<?php
						if (isset($_GET['slug'])){?>
								<option selected  value="<?php echo $country_id?>"><?php echo $country?></option>
					<?php	}
					?>
					<?php echo country();?>
				</select>
			  </div>

			  <div class="col-md-4 mb-3">
				<label for="inputProductTitle" class="form-label">State</label>
				<select required name="state" id="state" onchange="getCity(this.value)" class="form-control form-select">
					<option <?php echo (!isset($_GET['slug'])) ? 'selected' : ""?> disabled > 
						-- Select State -- 
					</option>
					<?php
						if (isset($_GET['slug'])){?>
								<option selected value="<?php echo $state_id?>"><?php echo $state?></option>
					<?php	}
					?>
				</select>
			  </div>

			  <div class="col-md-4 mb-3">
				<label for="inputProductTitle" class="form-label">City</label>
				<select required name="city" id="city" class="form-control form-select">
					<option <?php echo (!isset($_GET['slug'])) ? 'selected' : ""?> disabled value=""> -- Select City -- </option>
					<?php
						if (isset($_GET['slug'])){?>
								<option selected value="<?php echo $city_id?>"><?php echo $city?></option>
					<?php	}
					?>
					
				</select>
			  </div>

			  <div class="mb-3">
					<label class="form-label">Features</label>
					<input required value="<?php echo (isset($_GET['slug'])) ? $features : ""?>" type="text" name="features" class="form-control" data-role="tagsinput" >
				</div>

			  <div class="mb-3">
				<label for="description" class="form-label">Description</label>
				<textarea required class="form-control" name="description" id="description" rows="3">
					<?php echo (isset($_GET['slug'])) ? $desc : ""?>
				</textarea>
				<script>
                    CKEDITOR.replace( 'description' );
                </script>
			  </div>

			  <?php 
			  	if (!isset($_GET['slug'])) {?>
			  		<div class="mb-3">
							<label for="image-uploadify" class="form-label">Images</label>
							<input required id="image-uploadify" name="file[]" type="file" accept="image/*,video/*" multiple>
						  </div>
						 <?php 
						 		}
			  ?>

			  <div class="d-grid">
             <button type="submit" name="<?php echo (isset($_GET['slug'])) ? 'update' : "submit"?>" class="btn btn-primary"><?php echo (isset($_GET['slug'])) ? 'Update Story' : 'Save Story'?></button>
		  </div>
			  
            </div>


		   </div>
		   
		  
	   </div>
	    </form>

	    <?php if (isset($_GET['slug'])) {?>
	    	<div class="row">
	    		<?php 
	    	$getImages = $connect2db->prepare("SELECT * FROM story_file WHERE story_id = ?");
	    	$getImages->execute([$story_id]);
	    	while ($img = $getImages->fetch()) {?>
	    		<div class="col-md-3">
	    			<img width="90%" height="90%" src="story_files/<?php echo $img['file']?>">
	    			<form method="post" enctype="multipart/form-data">
	    				<input type="file" name="image">
	    				<input type="hidden" name="id" value="<?php echo $img['id']?>">
	    				<input type="submit" name="changeImage" value="Change" class="btn btn-inverse-primary">
	    			</form>
	    		</div>
	    <?php 
		    	}?>
		    </div>
		  <?php
		    }
	    ?>
	    <!--end row-->
	</div>
  </div>
</div>


<?php include 'includes/footer.php';?>
