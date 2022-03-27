<?php include 'includes/adm-header.php';?>

<?php 
	if (isset($_POST['changePassword'])) {
		$password = trim($_POST['password']);
		$newPass = trim($_POST['new_pass']);
		$conPass = trim($_POST['confirm_pass']);

		$getPass = $connect2db->prepare("SELECT password FROM users WHERE id = ?");
		$getPass->execute([$id]);
		$userPass = $getPass->fetch()['password'];
		if (password_verify($password, $userPass)) {
			if ($newPass<>$conPass) {
				echo "<script>alert('Password Mismatch')</script>";
			} else {
				$hashpass = password_hash($newPass, PASSWORD_DEFAULT);
				$changePass = $connect2db->prepare("UPDATE users SET password = ? WHERE id = ?");
				$changePass->execute([$hashpass, $id]);
				if ($changePass) {
					echo "<script>alert('Password Changed')</script>";
				} else {
					echo "<script>alert('Error Changing Password')</script>";
				}
			}
		} else {
			echo "<script>alert('Invalid Old Password')</script>";
		}
	}

	if (isset($_POST['update'])) {
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$uname = trim($_POST['uname']);
		$phone = trim($_POST['phone']);

		if (empty($fname) || empty($lname) || empty($uname) || empty($phone)) {
			echo "<script>alert('All Fields Are Required')</script>";
		} else {
			$updateUser = $connect2db->prepare("UPDATE users SET firstname = ?, lastname = ?, username = ?, phone = ? WHERE id = ?");
			$updateUser->execute([$fname, $lname, $uname, $phone, $id ]);
			if ($updateUser) {
				echo "<script>alert('Data Updated')</script>";
			} else {
				echo "<script>alert('Error Updating Data')</script>";
			}
			
		}
	}
?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
	<div class="breadcrumb-title pe-3">User Profile</div>
	<div class="ps-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0 p-0">
				<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">User Profilep</li>
			</ol>
		</nav>
	</div>
	
</div>

<div class="container">
	<div class="main-body">
		<div class="row">
			<div class="col-lg-4">
				<div class="card">
					<div class="card-body">
						<div class="d-flex flex-column align-items-center text-center">
							<img src="assets/images/avatars/avatar-2.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
							<div class="mt-3">
								<h4><?php echo $user_fullname?></h4>
								<p class="text-secondary mb-1"><?php echo $user_role?></p>
								<p class="text-muted font-size-sm"><?php echo $phone_number?></p>
								<h4><?php echo $uname?></h4>
							</div>
						</div>
						<hr class="my-4" />
						
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="card">
					<form method="post">
						<div class="card-body">
							<div class="row mb-3">
								<div class="col-sm-3">
									<!-- <h6 class="mb-0">Address</h6> -->
								</div>
								<div class="col-sm-9 text-secondary">
									<!-- <input type="text" class="form-control" value="Bay Area, San Francisco, CA" /> -->
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">First Name</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" required value="<?php echo $fname?>" class="form-control" name="fname" />
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Last Name</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="lname" required class="form-control" value="<?php echo $lname?>" />
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Username</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="uname" class="form-control" value="<?php echo $uname?>" />
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Mobile</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="phone" class="form-control" value="<?php echo $phone_number?>" />
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<!-- <h6 class="mb-0">Address</h6> -->
								</div>
								<div class="col-sm-9 text-secondary">
									<!-- <input type="text" class="form-control" value="Bay Area, San Francisco, CA" /> -->
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3"></div>
								<div class="col-sm-9 text-secondary">
									<input type="submit" name="update" class="btn btn-primary px-4" value="Save Changes" />
								</div>
							</div>
						</div>
					</form>
				</div>
				
			</div>

			<div class="col-sm-12">
				<div class="card">
					<form method="post">
						<div class="card-body">
							<h5 class="d-flex align-items-center mb-3">Change Password</h5>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Password</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="password" name="password" required class="form-control"  />
									</div>
								</div>

								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">New Password</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="password" name="new_pass" required class="form-control"  />
									</div>
								</div>

								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Confirm Password</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="password" name="confirm_pass" required class="form-control"  />
									</div>
								</div>

								<div class="row">
									<div class="col-sm-3"></div>
									<div class="col-sm-9 text-secondary">
										<input type="submit" name="changePassword" class="btn btn-primary px-4" value="Change Password" />
									</div>
								</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'includes/footer.php';?>