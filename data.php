<?php

// load storage
$data = file('storage.json');
$storage = json_decode($data[0],true);

//update accountValue
foreach($storage as $key=>$value) {
	if($key == $_POST['user']) {
		$storage[$key]['accountValue'] = floatval($_POST['accountValue']);
		// return new value of account
		echo $storage[$key]['accountValue'];
	}
}

// save storage
$file = fopen('storage.json','w');
fwrite($file,json_encode($storage));
fclose($file);


?>