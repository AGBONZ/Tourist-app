<?php include '../includes/header.php';
if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 15;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $result = $connect2db->prepare("SELECT COUNT(*) FROM story");$result->execute();
        $total_rows = $result->fetch()[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

?>
<div class="page-wrapper">
			<div class="page-content">
<h6 class="mb-0 text-uppercase">Unpublished Stories</h6>
<hr/>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xl-4">
	<?php 
		$getStories = $connect2db->prepare("SELECT * FROM story WHERE status = ? AND user_id = ? order by id DESC LIMIT $offset, $no_of_records_per_page ");
		$getStories->execute([0, $id]);
		if ($getStories->rowcount() > 0) {
			$i = 1;
			
			while ($story = $getStories->fetch()) {
				$color = ['primary', 'danger', 'success', 'warning'];
				$i = rand(0, 3);
					$status = ($story['status']==1) ? ['Published', 'bg-success'] : ['Unpublised', 'bg-danger'] ;

					$getImage = $connect2db->prepare("SELECT file FROM story_file WHERE story_id = ?");
					$getImage->execute([$story['id']]);
					$img = $getImage->fetch()['file'];

					$username = $connect2db->prepare("SELECT username FROM users WHERE id = ?");
					$username->execute([$story['user_id']]);
					$user = $username->fetch()['username'];
				?>
				
				<div class="col">
					<div class="card border-<?php echo $color[$i];?> border-bottom border-3 border-0">
						<img width="372px" height="248px" src="../story_files/<?php echo $img ?>" class="card-img-top" alt="...">
						<div class="card-body">
							<p class="card-title text-<?php echo $color[$i];?>">
								<strong><?php echo $story['title'] ?></strong>
							</p>
							<p class="card-text">

								<span>Publised By: </span> <span class="badge bg-gradient-quepal"><?php echo $user?></span><br>

								<span>Publised On:</span> <span class="badge bg-gradient-quepal"><?php echo $story['created_at']?></span> <br>

								<span>Status:</span> <span class="badge <?php echo $status[1]?>"><?php echo $status[0]?></span> <br>
							</p>
							<hr>
							<div class="d-flex align-items-center gap-2">
								<a href="create_story?slug=<?php echo $story['slug']?>" class="btn btn-inverse-<?php echo $color[$i];?>"><i class='bx bx-pen'></i>Edit</a>
								<a href="story_details?slug=<?php echo $story['slug']?>" class="btn btn-<?php echo $color[$i];?>"><i class='bx bx-analyse' ></i>View</a>
							</div>
						</div>
					</div>
				</div>
	<?php
				$i = $i + 1;
			} ?>
			<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid">
					<div id="pagination">
						<nav aria-label="Page navigation example">
							<ul class="pagination">
								<li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
									<a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Previous
									</a>
								</li>

								<?php $i=0; while($i<$total_pages){ $i++; ?>
								<li class="page-item <?php if($i == $pageno){ echo 'active'; }else{echo ' ';} ?>"><a class="page-link" href="?pageno=<?php echo $i ?>"><?php echo $i; ?></a>
								</li>
								<?php }?>

								<li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
									<a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
		<?php }  else { ?>
			</div>
			<div class="error-404 d-flex align-items-center justify-content-center">
			<div class="container">
				<div class="card py-5">
					<div class="row g-0">
						<div class="col col-xl-5">
							<div class="card-body p-4">
								<h1 class="display-1"><span class="text-primary">4</span><span class="text-danger">0</span><span class="text-success">4</span></h1>
								<h2 class="font-weight-bold display-4">You Have No Published Story</h2>
								
								<div class="mt-5"> 
									<a href="create_story" class="btn btn-primary btn-lg px-md-5 radius-30">Add Story</a>
									
								</div>
							</div>
						</div>
						<div class="col-xl-7">
							<img src="../../../../cdn.searchenginejournal.com/wp-content/uploads/2019/03/shutterstock_1338315902.html" class="img-fluid" alt="">
						</div>
					</div>
					<!--end row-->
				</div>
			</div>
		</div>
	<?php 
		}
	?>
	
	
</div>
				<!--end row-->
				

<?php include '../includes/footer2.php';?>