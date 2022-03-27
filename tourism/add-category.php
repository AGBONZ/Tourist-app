<?php 
	include 'includes/adm-header.php';
	if (isset($_GET['edit'])) {
		$cat_id = $_GET['edit'];
		$cats = $connect2db->prepare("SELECT * FROM category WHERE id = ?");
		$cats->execute([$cat_id]);
		if ($cats->rowcount() > 0) {
			$cat = $cats->fetch();
			$cn = $cat['category'];
			$sl = $cat['slug'];
		} else {
			echo "<script>alert('Invalid Parameter Supplied');window.location='category'</script>";
		}
		
	}

	if (isset($_POST['update'])) {
		$category = $_POST['category'];
		$slug = $_POST['slug'];

		if (empty($category) || empty($slug)) {
			echo "<script>alert('All Fields Are Required')</script>";
		} else {
			$validateCategory = $connect2db->prepare("SELECT * FROM category WHERE id != ? AND category = ?");
			$validateCategory->execute([$cat_id, $category]);
			if ($validateCategory->rowcount() > 0) {
				echo "<script>alert('Category Already Exist')</script>";
			}else{
				$updCat = $connect2db->prepare("UPDATE category SET category = ?, slug = ? WHERE id = ?");
				$updCat->execute([$category, $slug, $cat_id]);

				if ($updCat) {
					echo "<script>alert('Category Updated');window.location='category'</script>";
				} else {
					echo "<script>alert('Error Updating Category');window.location='category'</script>";
				}
			}
		}
	}
?>

		<form method="post">
			<div class="card">
				  <div class="card-body p-4">
					  <h5 class="card-title">Category</h5>
					  <hr/>
                       <div class="form-body mt-4">
					    <div class="row">
						   <div class="col-lg-8">
                           <div class="border border-3 p-4 rounded">
							<div class="mb-3">
								<label class="form-label">Category</label>
								<input value="<?php echo (isset($_GET['edit']) ? $cn : "")?>" type="text" onkeyup="createSlug(this.value)" class="form-control" style="text-transform:capitalize;" id="category" name="category">
							  </div>

							  <div class="mb-3">
								<label class="form-label">Category Slug</label>
								<input value="<?php echo (isset($_GET['edit']) ? $sl : "")?>" type="text" readonly class="form-control" id="slug" name="slug">
							  </div>

							  <div class="col-12">
									  <div class="d-grid">
                                         <button type="submit" name="<?php echo (isset($_GET['edit']) ? "update" : "submit")?>" class="btn btn-primary">Submit</button>
									  </div>
								  </div>

                            </div>
						   </div>
						   
					   </div><!--end row-->
					</div>
				  </div>
			  </div>
		</form>
	</div>
</div>
<?php include 'includes/footer.php';?>
<script type="text/javascript">
		function createSlug(str) {
		str = str.replace(/\s+/g, '-').toLowerCase();
		$('#slug').val(str)
	}
</script>
<?php
	if (isset($_POST['submit'])) {
		$category = $_POST['category'];
		$slug = $_POST['slug'];
		if (empty($category) || empty($slug)) {
			echo "<script>alert(All Fields Are Required)</script>";
		} else {
			$validateCategory = $connect2db->prepare("SELECT category FROM category WHERE category = ?");
			$validateCategory->execute([$category]);
			if ($validateCategory->rowcount() > 0) {
				echo "<script>error_noti('Category Already Exist');</script>";
			} else {
				$insert = $connect2db->prepare("INSERT INTO category (category, slug)VALUES(?, ?)");
				$insert->execute([$category, $slug]);
				if ($insert) {
					echo "<script>success_noti('Category Added');</script>";
				}else {
					echo "<script>error_noti('Error Adding Category');</script>";
				}

			}
		}
		
	}
?>