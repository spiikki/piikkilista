<?php

// load storage
$data = file('storage.json');
$storage = json_decode($data[0], true);
//init log
$logString = date('Y-m-d h:i:s');
$logString = $logString . ' - ' . $_POST['user'] . ' tabbed: ' . $_POST['amount'];

if (isset($_POST['amount'])) {
	//update accountValue
	foreach ($storage as $key => $value) {
		if ($key == $_POST['user']) {
			$newValue = $value['accountValue'] - floatval($_POST['amount']);
			$storage[$key]['accountValue'] = $newValue;

			$logString = $logString . ' - balance: ' . $newValue;

			// return new value of account
			echo $storage[$key]['accountValue'];
		}
	}

	// save storage
	$file = fopen('storage.json', 'w');
	fwrite($file, json_encode($storage));
	fclose($file);

	//save log
	$file = fopen('storage.log','a');
	fwrite($file, $logString."\n");
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
