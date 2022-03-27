<?php include 'includes/adm-header.php';?>

<?php 
	
	if (isset($_POST['register'])) {
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$uname = trim($_POST['uname']);
		$pnum = trim($_POST['pnum']);
		$password = password_hash('password', PASSWORD_DEFAULT);
		$role = 1;
		$status = 1;

		if (empty($fname) || empty($lname) || empty($uname) || empty($pnum)) {
			echo "<script>alert('All Fields Are Required')</script>";
		} else {
			$validateUser = $connect2db->prepare("SELECT username, phone FROM users WHERE username = ? OR phone = ?");
			$validateUser->execute([$uname, $pnum]);
			if ($validateUser->rowcount() > 0) {
				echo "<script>alert('Username or Phone Number Already Exist')</script>";
			} else {
				$createUser = $connect2db->prepare("INSERT INTO users (firstname, lastname, username, phone, password, role, status) VALUES (?, ?, ?, ?, ?, ?, ?) ");
				if ($createUser->execute([$fname, $lname, $uname, $pnum, $password, $role, $status])) {
					echo "<script>alert('Administrator Successfully Created')</script>";
				} else {
					echo "<script>alert('Error Adding Administrator')</script>";
				}
				
			}
			
		}
	}
	
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$getDetails = $connect2db->prepare("SELECT * FROM users WHERE id = ?");
		$getDetails->execute([$id]);
		if ($getDetails->rowcount() > 0) {
			$details = $getDetails->fetch();
			$firstName = $details['firstname'];
			$lastName = $details['lastname'];
			$phone = $details['phone'];
			$username = $details['username'];
		} else {
			echo "<script>alert('Invalid Parameter Supplied');window.location='manage_admin'</script>";
		}
		
	}

	if (isset($_POST['update'])) {
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$uname = trim($_POST['uname']);
		$pnum = trim($_POST['pnum']);
		$user_id = $_GET['edit'];

		if (empty($fname) || empty($lname) || empty($uname) || empty($pnum)) {
			echo "<script>alert('All Fields Are Required')</script>";
		} else {
			$validateUser = $connect2db->prepare("SELECT * FROM users WHERE id != ? AND (username = ? OR phone = ?)");
			$validateUser->execute([$user_id, $uname, $pnum]);
			if ($validateUser->rowcount() > 0) {
				echo "<script>alert('Username or Phone Number Already Exist')</script>";
			} else {
				$updateUser = $connect2db->prepare("UPDATE users SET username = ?, lastname = ?, firstname = ?, phone = ? WHERE id = ?");
				if ($updateUser->execute([$uname, $lname, $fname, $pnum, $user_id])) {
					echo "<script>alert('Data Successfully Updated');window.location='manage_admin'</script>";
				} else {
					echo "<script>alert('Error Updating Data')</script>";
				}
				
			}
			
		} 
	}

?>

<div class="row">
	<div class="col-xl-9 mx-auto">
		<div class="card border-top border-0 border-4 border-primary">
			<div class="card-body p-5">
				<div class="card-title d-flex align-items-center">
					<div><i class="bx bxs-user me-1 font-22 text-primary"></i>
					</div>
					<h5 class="mb-0 text-primary uppercase">Add Administrator</h5>
				</div>
				<hr>
				<form class="row g-3" method="post">
					<div class="col-md-6">
						<label for="inputFirstName" class="form-label">First Name</label>
						<input type="text" value="<?php echo (isset($_GET['edit'])) ? $firstName : ""?>" class="form-control text-capitalize" name="fname">
					</div>
					<div class="col-md-6">
						<label for="inputLastName" class="form-label">Last Name</label>
						<input type="text" value="<?php echo (isset($_GET['edit'])) ? $lastName : ""?>" class="form-control text-capitalize" name="lname">
					</div>
					<div class="col-md-6">
						<label for="inputEmail" class="form-label">Username</label>
						<input type="text" value="<?php echo (isset($_GET['edit'])) ? $username : ""?>" class="form-control text-capitalize" name="uname">
					</div>
					<div class="col-md-6">
						<label for="inputPassword" class="form-label">Phone Number</label>
						<input type="text" value="<?php echo (isset($_GET['edit'])) ? $phone : ""?>" class="form-control" name="pnum">
					</div>
					
					<div class="col-12">
						<button type="submit" name="<?php echo (isset($_GET['edit'])) ? "update" : "register"?>" class="btn btn-primary px-5">
							<?php echo (isset($_GET['edit'])) ? "Update Data" : "Register"?>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include 'includes/footer.php';?>