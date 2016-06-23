<?php 

	function moveFile($path,$account){
		$dir = './Public/Uploads/HistoryFace/'.$account.'/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$name = basename($path);
		rename($path,$dir.$name);
	}

 ?>