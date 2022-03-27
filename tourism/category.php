<?php 
	include 'includes/adm-header.php';
	if (isset($_GET['delete'])) {
		$cat_id = $_GET['delete'];
		$deleteCat = $connect2db->prepare("DELETE FROM category WHERE id = ?");
		$deleteCat->execute([$cat_id]);
		if ($deleteCat) {
			echo "<script>alert('Category Deleted');window.location='category'</script>";
		}else{
			echo "<script>alert('Error Deleting Category')</script>";
		}
	}


?>

		<div class="card">
		  <div class="card-body p-4">
			  <h5 class="card-title"> Category</h5>
			  <hr/>
               <div class="form-body mt-4">
			    <div class="row">
				   <div class="col-lg-12">
                   <div class="table-responsive">
					<table class="table mb-0">
						<thead class="table-light">
							<tr>
								<th>#</th>
								<th>Category</th>
								<th>Slogan</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$category = $connect2db->prepare("SELECT * FROM category");
								$category->execute();
								
								$i = 1;
								while ($cat = $category->fetch()) {
								?>

							<tr>
								<td><?php echo $i; ?></td>
								<td>
									<div class="d-flex align-items-center">
										<div class="ms-2 text-uppercase">
											<h6 class="mb-0 font-14"><?php echo $cat['category']?></h6>
										</div>
									</div>
								</td>
								<td>
									<div class="">
										<?php echo $cat['slug']?>
									</div>
								</td>
								<td>
									<div class="d-flex order-actions">
										<a href="add-category?edit=<?php echo $cat['id']?>" class=""><i class='bx bxs-edit text-success'></i></a>
										<a onclick="return confirm('ARE YOU SURE?');" href="?delete=<?php echo $cat['id']?>" class="bg-danger ms-3"><i class='bx bxs-trash text-white'></i></a>
									</div>
								</td>
							</tr>

							<?php 
								$i++;
							}
							?>
						</tbody>
					</table>
				</div>
				   </div>
				   
			   </div><!--end row-->
			</div>
		  </div>
	  </div>
	</div>
</div>
<?php include 'includes/footer.php';?>