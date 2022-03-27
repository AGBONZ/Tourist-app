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
<!--start page wrapper -->

<div class="page-wrapper">
			<div class="page-content">

				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-lg-3 col-xl-2">
										<a href="create_story" class="btn btn-primary mb-3 mb-lg-0"><i class='bx bxs-plus-square'></i>New Story</a>
									</div>
									<div class="col-lg-9 col-xl-10">
										<form class="float-lg-end">
											<div class="row row-cols-lg-2 row-cols-xl-auto g-2">
												<div class="col">
													<div class="position-relative">
														<input type="text" class="form-control ps-5" placeholder="Search Product..."> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
													</div>
												</div>
												<div class="col">
													<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
														<button type="button" class="btn btn-white">Sort By</button>
														<div class="btn-group" role="group">
														  <button id="btnGroupDrop1" type="button" class="btn btn-white dropdown-toggle dropdown-toggle-nocaret px-1" data-bs-toggle="dropdown" aria-expanded="false">
															<i class='bx bx-chevron-down'></i>
														  </button>
														  <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
															<li><a class="dropdown-item" href="#">Dropdown link</a></li>
															<li><a class="dropdown-item" href="#">Dropdown link</a></li>
														  </ul>
														</div>
													  </div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid">
					
					<?php 
					 $rw = $connect2db->prepare("SELECT * FROM story order by id DESC LIMIT $offset, $no_of_records_per_page ");
					 $rw->execute();

					 while($story = $rw->fetch()){?>
					<div class="col">
						<div class="card">
							<img src="file/<?php echo $story['media_file']; ?>" class="card-img-top" alt="..." style="height:250px;width: 100%;">
							<div class="">
								<div class="position-absolute top-0 end-0 p-2 bg-dark text-white"><small class=""><?php echo date('F j, Y.  g:i a',strtotime($story['created_at'])); ?></small></div>
							</div>
							<div class="card-body">
								<h6 class="card-title cursor-pointer">
									<?php 
									echo substr($story['title'],0,20) .'...'; ?></h6>
								<div class="clearfix">
									<p class="mb-0 float-start"><?php echo substr($story['description'],0,20) .'...'; ?></p>
								</div>
								<div class="d-flex align-items-center mt-3 fs-6 p-3">
								  <div class="cursor-pointer">
								  	<?php if($story['published'] == 1){ ?>
								  		<label class="badge bg-success disabled"> Published </label>
									<?php }else{?>
										<a class="btn btn-info btn-sm text-white" href="?story_id=<?php echo $story['story_id']; ?>"> Publish </a> 
									<?php } ?>
									&nbsp;&nbsp;
								  </div>	
								  	<a class="btn btn-danger btn-sm ml-4" href="?delete_id=<?php echo $story['story_id']; ?>"> Delete</a>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>

					
				</div><!--end row-->

				<!-- Pagination goes here -->
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

			</div>
		</div>
<!--end page wrapper -->
<?php include '../includes/footer.php';?>	

<?php 

	// Script to delete 
	if(isset($_GET['delete_id'])){
	    $delID = $_GET['delete_id'];
	    $sql_del = $connect2db->prepare("DELETE FROM story WHERE story_id=?");
	    $sql_del->execute([$delID]);
	        if($sql_del){
	        echo "<script>error_noti('Story Successfully Deleted :)');;window.location='all_story';</script>";
	        }
	}

	// Script to Published 
	if(isset($_GET['story_id'])){
	    $pubID = $_GET['story_id'];
	    $pub = 1;
	    $sql_pub = $connect2db->prepare("UPDATE story SET published=? WHERE story_id = ?");
	    $sql_pub->execute([$pub, $pubID]);
	        if($sql_pub){
	        	echo "<script>success_noti('Published =:)');;window.location='all_story';</script>";
	        }
	}
 ?>
<!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum. -->