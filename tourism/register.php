

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css" />
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Tourism Management System</title>
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
					<div class="col mx-auto">
						<div class="my-4 text-center">
							<img src="assets/images/logo-img.png" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign Up</h3>
										<p>Already have an account? <a href="index">Sign in here</a>
										</p>
									</div>
									
									<div class="form-body">
										<form class="row g-3" method="post" >
											<div class="col-sm-6" id="fname">
												<label for="inputFirstName" class="form-label">First Name</label>
												<input type="text" name="fname" class="form-control" id="inputFirstName" placeholder="Jhon">
											</div>
											<div class="col-sm-6" id="lname">
												<label for="inputLastName" class="form-label">Last Name</label>
												<input type="text" name="lname" class="form-control" id="inputLastName" placeholder="Deo">
											</div>
											<div class="col-12" id="email">
												<label for="inputEmailAddress" class="form-label">Username</label>
												<input type="text" name="email" class="form-control" id="inputEmailAddress" placeholder="example@user.com">
											</div>
											<div class="col-12" id="pnum">
												<label for="inputEmailAddress" class="form-label">Phone Number</label>
												<input type="text" name="pnum" class="form-control" id="inputPhoneNumber">
											</div>
											<div class="col-12" id="pass">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="inputChoosePassword" name="pass" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>

											<div class="col-12">
												<label for="confirmPassword" class="form-label">Confirm Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="confirmPassword" name="cpass" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											
											<div class="col-12">
												<!-- <div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
													<label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to Terms & Conditions</label>
												</div> -->
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" name="submit" class="btn btn-primary"><i class='bx bx-user'></i>Sign up</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/notifications/js/lobibox.min.js"></script>
	<script src="assets/plugins/notifications/js/notifications.min.js"></script>
	<script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});

			// function validate () {
			// 	e.preventDefault()
			// 	let fname = $('#inputFirstName').val();
			// 	let lname = $('#inputLastName').val();
			// 	let email = $('#inputEmailAddress').val();
			// 	let pnum = $('#inputPhoneNumber').val();
			// 	let pass = $('#inputChoosePassword').val();
			// 	let cpass = $('#confirmPassword').val();

			// 	if (fname == "" || fname == " "){
			// 		$('#fname').append("<span class='text-danger'>First Name is Required</span>")
			// 	}
			// }



		});
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>



</html>

<?php 
	include 'includes/connection.php';
	if (isset($_POST['submit'])) {
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$pnum = trim($_POST['pnum']);
		$email = trim($_POST['email']);
		$pass = $_POST['pass'];
		$cpass = $_POST['cpass'];
		$role = 2;
		$status = 0

		if (empty($fname) || empty($lname) || empty($pnum) || empty($email) || empty($pass) ) {
			echo "<script>error_noti('All Fields Are Required')</script>";
		}else if ($pass <> $cpass) {
			echo "<script>error_noti('Password Mismatch')</script>";
		}else{
			$hashpass = password_hash($pass, PASSWORD_DEFAULT);
			$validateUsername = $connect2db->prepare("SELECT * FROM users WHERE username = ? || phone = ?");
			$validateUsername->execute([$email, $pnum]);
			if ($validateUsername->rowcount() > 0) {
				echo "<script>error_noti('Username/Phone Number Already Exist')</script>";
			}else{
				$register = $connect2db->prepare("INSERT INTO users (firstname, lastname, username, phone, password, role, status)VALUES(?,?,?,?,?,?,?)");
				$register->execute([$fname, $lname, $email, $pnum, $hashpass, $role, $status]);
				if ($register) {
					echo "<script>success_noti('Successful');window.location='index'</script>";
				} else {
					echo "<script>error_noti('Error Submitting Form')</script>";
				}
			}
			
			
		}
	}
?>