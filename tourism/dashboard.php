<?php 

	include 'includes/adm-header.php';
	$getTotalStory = $connect2db->prepare("SELECT COUNT(id) AS total FROM story");
	$getTotalStory->execute([]);
	$ts = $getTotalStory->fetch()['total'];

	$getStoryteller = $connect2db->prepare("SELECT COUNT(id) AS total FROM users WHERE role = ?");
	$getStoryteller->execute([2]);
	$tst = $getStoryteller->fetch()['total']; 

	$published = $connect2db->prepare("SELECT COUNT(id) AS total FROM story WHERE status = ?");
	$published->execute([1]);
	$ps = $published->fetch()['total'];

	$unpublished = $connect2db->prepare("SELECT COUNT(id) AS total FROM story WHERE status = ?");
	$unpublished->execute([0]);
	$ups = $unpublished->fetch()['total'];
?>

	<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
       <div class="col">
		 <div class="card radius-10 border-start border-0 border-3 border-info">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Total Story</p>
						<h4 class="my-1 text-info"><?php echo $ts?></h4>
						<p class="mb-0 font-13">Published/Unpublished</p>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-folder'></i>
					</div>
				</div>
			</div>
		 </div>
	   </div>
	   <div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-danger">
		   <div class="card-body">
			   <div class="d-flex align-items-center">
				   <div>
					   <p class="mb-0 text-secondary">Total Storyteller</p>
					   <h4 class="my-1 text-danger"><?php echo $tst?></h4>
					   <p class="mb-0 font-13">Active and Inactive</p>
				   </div>
				   <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bxs-user'></i>
				   </div>
			   </div>
		   </div>
		</div>
	  </div>
	  <div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-success">
		   <div class="card-body">
			   <div class="d-flex align-items-center">
				   <div>
					   <p class="mb-0 text-secondary">Published Story</p>
					   <h4 class="my-1 text-success"><?php echo $ps?></h4>
					   <p class="mb-0 font-13"> &nbsp;</p>
				   </div>
				   <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
				   </div>
			   </div>
		   </div>
		</div>
	  </div>
	  <div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-warning">
		   <div class="card-body">
			   <div class="d-flex align-items-center">
				   <div>
					   <p class="mb-0 text-secondary">Unpublished Story</p>
					   <h4 class="my-1 text-success"><?php echo $ups?></h4>
					   <p class="mb-0 font-13">&nbsp;</p>
				   </div>
				   <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bxs-group'></i>
				   </div>
			   </div>
		   </div>
		</div>
	  </div> 
	</div><!--end row-->

	
	 <div class="card radius-10">
             <div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Recent Stories</h6>
					</div>
					<!-- <div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Action</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Another action</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="javascript:;">Something else here</a>
							</li>
						</ul>
					</div> -->
				</div>
			 <div class="table-responsive">
			   <table class="table align-middle mb-0">
				<thead class="table-light">
				 <tr>
				   <th>SN</th>
				   <th>Title</th>
				   <th>Writter</th>
				   <th>Status</th>
				   <th>Date</th>
				 </tr>
				 </thead>
				 <tbody>
				 	<?php 
				 		$getStory = $connect2db->prepare("SELECT s.*, u.firstname, u.lastname FROM story AS s JOIN users AS u ON u.id = s.user_id WHERE s.status = ?");
						$getStory->execute([0]);
						$i = 1;
						while ($story = $getStory->fetch()) {?>
							<tr>
							  <td><?php echo $i?></td>
							  <td><?php echo $story['title']?></td>
							  <td><?php echo $story['firstname']." ".$story['firstname']?></td>
							  <td><span class="badge bg-gradient-bloody text-white shadow-sm w-100">
							  Unpublished</span></td>
							  <td><?php echo $story['created_at']?></td>
							</tr>
					
					<?php	
						$i = $i++;
						}
				 	?>
				 	

				 

				 

			    </tbody>
			  </table>
			  </div>
			 </div>
		</div>


<!-- </div>
</div> -->
<!--end page wrapper -->
<?php include 'includes/adm-footer.php';?>	