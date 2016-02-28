
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Sign in - Progressus Bootstrap template</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="assets/css/main.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="index.html">
				<img src="assets/images/logoIDV.png" height="60" width="120" alt="CrowdDescartes"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li class="active"><a href="index.php">Acceuil</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">More Pages <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="sidebar-left.html">Task list</a></li>
							<li class="active"><a href="sidebar-right.html">Personel information</a></li>
						</ul>
					</li>
					<li><a href="contact.html">Exemple</a></li>
					<li><a class="btn" href="sign.php">Log in</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->

	<header id="head" class="secondary"></header>

	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="index.html">Home</a></li>
			<li class="active">User access</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title">Sign in</h1>

				</header>
				
				
				<div class="col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2">

					<div class="panel panel-primary"> 
						<div class="panel-heading">					
							<h1 class="page-title" style="text-align:center">Choose your type</h1>
						</div>
						<div class="panel-body">
							<div class="col-md-4 col-md-offset-2">
								<a href="signin.php">
								<button class="btn btn-default btn-lg " type="button"  ><img src="assets/images/demandeur.jpg" style="border-radius: 13px;"></button>
								</a>
								<h3 class="text-center">A Customer</h3>
							</div>
							<div class="col-md-4 col-md-offset-1">
								<a href="signin.php">
								<button class="btn btn-default btn-lg " type="button" ><img src="assets/images/crowdeur.jpg" style="border-radius: 13px"></button>
								</a>
								<h3 class="text-center">A Contributer</h3>	
							</div>
						</div>	
					</div>

				</div>
				
			</article>
			<!-- /Article -->

		</div>
	</div>	<!-- /container -->
	

<footer id="footer" class="top-space">


		<div class="footer2">
			<div class="container">
				<div class="row">
					
					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="simplenav">
								<a href="#">Home</a> | 
								<a href="about.html">About</a> |
								<a href="sidebar-right.html">Sidebar</a> |
								<a href="contact.html">Contact</a> |
								<b><a href="signup.html">Sign up</a></b>
							</p>
						</div>
					</div>

					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2014, Your name. Designed by <a href="http://gettemplate.com/" rel="designer">gettemplate</a> 
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>
	</footer>	
		




	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="assets/js/headroom.min.js"></script>
	<script src="assets/js/jQuery.headroom.min.js"></script>
	<script src="assets/js/template.js"></script>
</body>
</html>