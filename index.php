<?php 
ob_start("ob_gzhandler");
include_once("inc.php"); 
?>
<!DOCTYPE html>
<html>

<head>
  <title>Aufgaben</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="apple-mobile-web-app-capable" content="yes" /> 
  <link href="css/style.css" type="text/css" rel="stylesheet" />
	<link href="css/gh-buttons.css" type="text/css" rel="stylesheet" />
  <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed_aufgaben.png"/>
</head>

<body>

<div id="page">

	<div id="header">
  	<ul id="navbar" class="button-group">
      <li class="active" id="showUncompleted"><span class="button big">offen</span></li>
      <li id="showCompleted"><span class="button big">erledigt</span></li>
  	</ul><!-- /navbar -->
  	<h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Aufgaben</a></h1>
	</div><!-- /header -->

	<div id="content">	
    <form action="backend.php" method="post" id="create">
  	   <input type="text" name="newtodotext" id="tn" value="" placeholder="Text eingeben" autocomplete="off"/>
    </form>
   
    <ul id="list"></ul>
    <div id="options">
      <span id="status"></span>
      <span class="button icon reload">Aktualisieren</span>
    </div>		
	</div><!-- /content -->
	
</div><!-- /page -->

<!-- 
<script src="js/jquery-1.7.1.min.js"></script>
<script src="js/jquery.livequery-1.0.3.js"></script>
<script src="js/todo.js"></script>
-->
 
<script src="jsmin.php?f=js/jquery-1.7.1.min.js;js/jquery.livequery-1.0.3.js;js/todo.js"></script>

<script>
  $(document).ready(function(){
    startTheShow();
 });
</script>
</body>
</html>