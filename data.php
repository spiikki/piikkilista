<?php

// load storage
$data = file('storage.json');
$storage = json_decode($data[0], true);

if (isset($_POST['amount'])) {
	//update accountValue
	foreach ($storage as $key => $value) {
		if ($key == $_POST['user']) {
			$newValue = $value['accountValue'] - floatval($_POST['amount']);
			$storage[$key]['accountValue'] = $newValue;
			// return new value of account
			echo $storage[$key]['accountValue'];
		}
	}

	// save storage
	$file = fopen('storage.json', 'w');
	fwrite($file, json_encode($storage));
	fclose($file);

} else {
	//return users accountValue
	foreach ($storage as $key => $value) {
		if ($key == $_POST['user']) {
			echo $storage[$key]['accountValue'];
		}
	}
	
}

?>