<?php

//set timezone
date_default_timezone_set('Europe/Helsinki');

// load storage
$data = file_get_contents('storage.json');
$storage = json_decode($data, true);
//init log
$logString = date('Y-m-d H:i:s');

switch( $_POST['action'] ) {
	case 'save':
		if($_REQUEST['type'] == 'sale') {
			$logString = $logString . ' - ' . $_POST['user'] . ' tabbed a "' . $_POST['product'] . '": ' . $_POST['amount'];
		} else if($_REQUEST['type'] == 'deposit') {
			$logString = $logString . ' - ' . $_POST['user'] . ' deposited ' . $_POST['amount'];
		}

		//update accountValue
		foreach ($storage as $key => $value) {
			if ($key == $_POST['user']) {
				if($_REQUEST['type'] == 'sale') {
					$newValue = $value['accountValue'] - floatval($_POST['amount']);
				} else if($_REQUEST['type'] == 'deposit') {
					$newValue = $value['accountValue'] + floatval($_POST['amount']);
				}
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

	//case 'users':
	default:
		//return users
		echo json_encode(array_keys($storage));
		break;
}

?>
