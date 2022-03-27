<?php include 'includes/adm-header.php';?>

<h6 class="mb-0 text-uppercase">All Stories</h6>
<hr/>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xl-4">
	<?php 
		$getStories = $connect2db->prepare("SELECT * FROM story WHERE status = ?");
		$getStories->execute([1]);
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
						<img width="372px" height="248px" src="story_files/<?php echo $img ?>" class="card-img-top" alt="...">
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
								<a href="story_details?slug=<?php echo $story['slug']?>" class="btn btn-<?php echo $color[$i];?>"><i class='bx bx-analyse' ></i>View Story</a>
							</div>
						</div>
					</div>
				</div>
	<?php
				$i = $i + 1;
			}
		}
	?>
	
</div>
				<!--end row-->

<?php include 'includes/footer.php';?>