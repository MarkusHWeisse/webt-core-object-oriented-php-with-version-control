<?php
declare(strict_types = 1);
include_once 'src/Youtube.php';
include_once 'src/Vimeo.php';
include_once 'src/video.php';
session_start();

spl_autoload_register(function ($class_name) {
    include 'src/' . $class_name . '.php';
});

function checkForOverlap($s1, $s2) {
	if(strlen($s1) <= 0) {
		return true;
	}

	$a1 = explode(" ", $s1);
	foreach ($a1 as $k => $v) {
		if (strpos($s2, $a1[$k]) !== false) {
			return true;
		}	
	}
}

function writeIframes($wIv1) {
	if(checkForOverlap($_SESSION['suchString'], $wIv1->getName())) {
		$_SESSION['Iframes'] .= "<span class='AOAIframe'><div>\n";
		$_SESSION['Iframes'] .= "		" . $wIv1->getHTML() . "<br>\n";
		$_SESSION['Iframes'] .= "		<h3>" . $wIv1->getName() . "</h3>\n";
		$_SESSION['Iframes'] .= "	</div></span>\n";
	}	
}

function printIframes() {
	$_SESSION['Iframes'] = "";
	if(sizeof($_SESSION['videoArray']) > $_SESSION['arrayTillNow'] && $_SESSION['createTrailerPressed'] == false) {
		foreach ($_SESSION['videoArray'] as $key => $value) {
			writeIframes($value);
		}
	}	
}

function loadPHP() {
	if(!isset($_SESSION['videoArray'])) {
		$_SESSION['videoArray'] = array();
	}

	if(!isset($_SESSION['createTrailerPressed'])) {
		$_SESSION['createTrailerPressed'] = false;
	}

	if(!isset($_SESSION['fillArray'])) {
		$_SESSION['fillArray'] = false;
	}

	if(!isset($_SESSION['suchString'])) {
		$_SESSION['suchString'] = "";
	}

	if(!isset($_SESSION['arrayTillNow'])) {
		$_SESSION['arrayTillNow'] = 0;
	}

	if(isset($_POST['createTrailer'])) {
		$_SESSION['createTrailerPressed'] = true;
	}

	if(isset($_POST['textClick'])) {
		$_SESSION['suchString'] = $_POST['textValue'];
	}

	/*if(isset($_POST['createTrailerFormSubmit'])) {
		$_SESSION['fillArray'] = true;
	}*/

	if($_SESSION['fillArray'] == true) {
		if($_POST['Kategorie'] == 'Y') {
			if(!in_array(new Youtube($_POST['formSource'], $_POST['formTitle']), $_SESSION['videoArray'], true)){
     		    array_push($_SESSION['videoArray'], new Youtube($_POST['formSource'], $_POST['formTitle']));
    		}
			$_SESSION['fillArray'] = false;
		}else {

		}
	}
}	

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Acolytes Of Ash</title>
		<link rel="stylesheet" href="styles.css"/>
	</head>
	<body>
	<?php

		loadPHP(); 
	?>
	<div class="container"> 
		<div class="imgdiv">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input id="Logo" type="image" name="imgClick" src="AcolytesOfAsh_Logo.jpg" alt="AcolytesOfAsh_Logo.jpg" width="30%" height="30%">
			</form>
		</div>
		<div class="searchdiv">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input id="searchBar" type="text" name="textValue" placeholder="Suchen" required>
				<input class="AOAButtons" type="submit" name="textClick" value="Search">
			</form>	
		</div>	
		<div class="formdiv">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input class="AOAButtons" type="submit" name="createTrailer" value="Create Trailer" id="buttonCreate">
			</form>	
		</div>
	</div>
	<?php 
		printIframes();
		echo $_SESSION['Iframes'];

		if($_SESSION['createTrailerPressed'] == true) {
	?>	

	<div class="createTrailerForm">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<label class="createTrailerFormLeft" for="formSource">URL of the Trailer: </label>
			<input class="createTrailerFormText" type="text" id="formSource" name="formSource" placeholder="URL" required><br>
			<label for="formTitle" class="createTrailerFormLeft">Title: </label>
			<input class="createTrailerFormText" type="text" id="formTitle" name="formTitle" placeholder="Title" required><br><br>
			<label>Kategorie:</label><br>
			<input type="radio" name="Kategorie" id="Youtube" value="Y">
			<label for="Youtube">Youtube</label><br>
			<input type="radio" name="Kategorie" id="Vimeo" value="V">
			<label for="Vimeo">Vimeo</label><br><br>
			<input type="submit" name="createTrailerFormSubmit" class="AOAButtons" value="Create" action="<?php $_SESSION['fillArray'] = true; ?>">
		</form>	
	</div>	

	<?php
			$_SESSION['createTrailerPressed'] = false;
		}
	?>
	</body>
</html>