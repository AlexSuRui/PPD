<?php

function echoInput($id, $input, $placeholder, $type = "text", $value = null, $options = "") {
	
	global $_POST;
	
	if (isset($_POST[$id])) {
		$value = $_POST[$id];
	}
	
	if (isset($value)) {
		echo '<div class="form-group">
    <label class="control-label col-sm-2" for="'.$id.'">'.$input.'</label>
    <div class="col-sm-10"> 
      <input type="'.$type.'" class="form-control" id="'.$id.'" name="'.$id.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$options.'>
    </div>
  </div>';
	} else {
		echo '<div class="form-group">
    <label class="control-label col-sm-2" for="'.$id.'">'.$input.'</label>
    <div class="col-sm-10"> 
      <input type="'.$type.'" class="form-control" id="'.$id.'" name="'.$id.'" placeholder="'.$placeholder.'" '.$options.'>
    </div>
  </div>';
	}
	
}
function startDocument($title) {
echo 
'<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$title.'</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>';
}

function endDocument() {
echo 
'    <!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>';
}

function navBar($selected = 0) {
echo
'<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">NCSP <b>[DEV VERSION]</b></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Accueil</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="demandes.php">Demandes</a></li>
        <li><a href="aPropos.php">A Propos de la plateforme</a></li>
       <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Profil <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="enregistrement.php">S\'enregistrer</a></li>
            <li><a href="#">Se connecter</a></li>
            <li><a href="#">Accéder au profil</a></li>
            <li><a href="#">Se déconnecter</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">Options</li>
            <li><a href="#">Effectuer une demande</a></li>
            <li><a href="#">Contribuer</a></li>
          </ul>
        </li> -->
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>';	
}

function ecrireMessage($message) {
	echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
}

function ecrireAlerte($message) {
	echo '<div class="alert alert-warning" role="alert">'.$message.'</div>';
}

function ecrireErreur($message) {
	echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
}

?>