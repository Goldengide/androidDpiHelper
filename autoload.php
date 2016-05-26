<?php
 	function __autoload($classfile) {
 		require_once $classfile;
 	}
 	__autoload("AndroidDpiHelper.php");
?>