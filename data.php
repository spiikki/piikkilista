<?php

//set timezone
date_default_timezone_set('Europe/Helsinki');

// load storage
$data = file('storage.json');
$storage = json_decode($data[0], true);
//init log
$logString = date('Y-m-d H:i:s');
$logString = $logString . ' - ' . $_POST['user'] . ' tabbed a "' . $_POST['product'] . '": ' . $_POST['amount'];

switch( $_POST['action'] ) {
	case 'save':
		//update accountValue
		foreach ($storage as $key => $value) {
			if ($key == $_POST['user']) {
				$newValue = $value['accountValue'] - floatval($_POST['amount']);
				$storage[$key]['accountValue'] = $newValue;

				$logString = $logString . ' - balance: ' . $newValue;

				// return new value of account
				echo '{"accountValue":'.$storage[$key]['accountValue'].'}';
			}
		}

		// save storage
		$file = fopen('storage.json', 'w');
		fwrite($file, json_encode($storage));
		fclose($file);

		//save log
		$file = fopen('storage.log', 'a');
		fwrite($file, $logString . "\n");
		fclose($file);
		
		break;
		
	case 'userData':
		//return users accountValue
		foreach ($storage as $key => $value) {
			if ($key == $_POST['user']) {
				echo '{"accountValue":'.$storage[$key]['accountValue'].'}';
			}
		}
		break;

	case 'users':
		//return users
		echo json_encode(array_keys($storage));
		break;
}

?>
