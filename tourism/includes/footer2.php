</div></div>
<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © <?php echo date('Y');?>. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="../assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/plugins/input-tags/js/tagsinput.js"></script>
	<script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../assets/plugins/chartjs/js/Chart.min.js"></script>
	<script src="../assets/plugins/chartjs/js/Chart.extension.js"></script>
	<script src="../assets/js/index.js"></script>
	<script src="../assets/plugins/notifications/js/lobibox.min.js"></script>
	<script src="../assets/plugins/notifications/js/notifications.min.js"></script>
	<script src="../assets/plugins/notifications/js/notification-custom-script.js"></script>
	<script src="../assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>
	<script src="../assets/plugins/fancy-file-uploader/jquery.fancy-fileupload.js"></script>
	<script>
		$(document).ready(function () {
			$('#image-uploadify').imageuploadify();
		})
	</script>
	<script>
		$('#fancy-file-upload').FancyFileUpload({
			params: {
				action: 'fileuploader'
			},
			maxfilesize: 1000000
		});
	</script>
	<!--app JS-->
	<script src="../assets/js/app.js"></script>
	<script type="text/javascript">
		function createSlug(str) {
		str = str.replace(/\s+/g, '-').toLowerCase();
		$('#slug').val(str)
	}

	function getState(country_id) {
		$.ajax({
			url: '../country_state_city.php',
			method: 'POST',
			data:{country_id:country_id},
			success: function(response){
				// console.log(response)
				$('#state').html(response);
			}
		});
	}

	function getCity (state_id){
		$.ajax({
			url: '../country_state_city.php',
			method: 'POST',
			data:{state_id:state_id},
			success: function(response){
				// console.log(response)
				$('#city').html(response);
			}
		});
	}
</script>
</body>

</html>