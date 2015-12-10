<?php

function vd_my($varDump, $arrIP = array(), $myIP = ''){
	if ($_SERVER['REMOTE_ADDR'] == $myIP || in_array($_SERVER['REMOTE_ADDR'], $arrIP)){
		var_dump($varDump);
	}
}
