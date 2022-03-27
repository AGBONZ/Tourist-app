<?php 
	include 'includes/connection.php';
	if(isset($_POST['country_id'])){
		ob_clean();
		$cr_id = $_POST['country_id'];
		$st = $connect2db->prepare("SELECT id, country_id, name FROM states WHERE country_id=?");
		$st->execute([$cr_id]);

		while($states = $st->fetch()){
			echo "<option value='".$states['id']."'>". $states['name']."</option>";
		}

	}
	
	if(isset($_POST['state_id'])){
		ob_clean();
		$st_id = $_POST['state_id'];
		$ct = $connect2db->prepare("SELECT id, state_id, name FROM cities WHERE state_id=?");
		$ct->execute([$st_id]);

		while($cities = $ct->fetch()){
			echo "<option value='".$cities['id']."'>". $cities['name']."</option>";
		}

	}
?>