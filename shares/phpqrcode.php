<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index.php 2011-10-10 0:23:12 jerry $
*/

$showtext = $_GET['showtext'];
!$showtext && die('Access Denied');

include('./plugins/phpqrcode/phpqrcode.php'); 

$size = $_GET['size'] ? $_GET['size'] : 20;

QRcode::png($showtext, false, QR_ECLEVEL_L, $size);