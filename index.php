<!DOCTYPE html>
  	<?php
		include "module.php";
		include "moduleBDD.php";
		session_start();
		
		//startDocument("Page d'accueil");
		//navBar();
		connection(true);
		if (isset($_SESSION["utilisateur"]))
			$me = $_SESSION["utilisateur"];
	?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Projet PPD</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="assets/css/main.css">


	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body class="home">
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="index.php">
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

	<!-- Header -->
	<header id="head">
		<div class="container">
			<div class="row">
				<h1 class="lead">Make your data useful</h1><br>
				<div class="content-wrapper">
					<div class="col-md-12">
	                	<div id="Carousel" class="carousel slide" data-ride="carousel" data-interval="5000" >
			             <!--   <ol class="carousel-indicators">
			                    <li data-target="#Carousel" data-slide-to="0" class="active"></li>
			                    <li data-target="#Carousel" data-slide-to="1"></li>
			                    <li data-target="#Carousel" data-slide-to="2"></li>
			                </ol> -->
			               
		             	 	<div class="carousel-inner">
		                    
		                    	<div class="item active">
		                			<div class="row">
				                	    <div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/1.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
				                	  	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/2.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
				                	  	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/3.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
				                	  	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/4.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
									  	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/6.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                	  		  	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/7.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                			</div><!--.row-->
		                    	</div><!--.item-->
		            			<div class="item">
		                            <div class="row">
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/8.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/9.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/3.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/2.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		            					<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/1.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/4.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	</div><!--.row-->
		                   		</div><!--.item-->
		            			<div class="item">
		                            <div class="row">
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/7.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/9.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/8.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/3.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		            					<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/1.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            	<div class="col-md-2"><a href="#" class="thumbnail"><img src="assets/images/2.jpg" alt="Image" style="with: 250px; height: 150px;"></a></div>
		                            </div><!--.row-->
		                    	</div><!--.item-->
		                 
		              		</div>
	              	<!--.carousel-inner-->

	                  <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
	                  <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
	        		</div>
	        	</div>
	        	<script type="text/javascript">
	        	// Scroleto=0;
	        	// function ScrollWin()
	        	// {
	        	// 	while(Scroleto!=700)
	        	// 	{
	        	// 		this.scroll(1,Scroleto)
	        	// 		Scroleto++;
	        	// 	}
	        	// }
	        	// onload = ScrollWin;
	        	// </script>
        		<!-- <a href="#intro"><button class="btn btn-defaut" style="margin-top:50px">En savoir plus</button>
        		</a> -->
        	</div>		<!--.Carousel-->

		</div>
	</header>
	<!-- /Header -->

	<!-- Intro -->
	<div class="container text-center" id="intro">
		<br> <br>
		<h2 class="thin">The best place to tell people why they are here</h2>
		<p class="text-muted">
		<img src="assets/images/page.jpg">
		</p>
	</div>
	<!-- /Intro-->
		
	<!-- Highlights - jumbotron -->
	<div class="jumbotron top-space">
		<div class="container">
			
			<h3 class="text-center thin">Reasons to use this template</h3>
			
			<div class="row">
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-cogs fa-5"></i>Bootstrap-powered</h4></div>
					<div class="h-body text-center">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque aliquid adipisci aspernatur. Soluta quisquam dignissimos earum quasi voluptate. Amet, dignissimos, tenetur vitae dolor quam iusto assumenda hic reprehenderit?</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-flash fa-5"></i>Fat-free</h4></div>
					<div class="h-body text-center">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores, commodi, sequi quis ad fugit omnis cumque a libero error nesciunt molestiae repellat quos perferendis numquam quibusdam rerum repellendus laboriosam reprehenderit! </p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-heart fa-5"></i>Creative Commons</h4></div>
					<div class="h-body text-center">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, vitae, perferendis, perspiciatis nobis voluptate quod illum soluta minima ipsam ratione quia numquam eveniet eum reprehenderit dolorem dicta nesciunt corporis?</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-smile-o fa-5"></i>Author's support</h4></div>
					<div class="h-body text-center">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, excepturi, maiores, dolorem quasi reprehenderit illo accusamus nulla minima repudiandae quas ducimus reiciendis odio sequi atque temporibus facere corporis eos expedita? </p>
					</div>
				</div>
			</div> <!-- /row  -->
		
		</div>
	</div>
	<!-- /Highlights -->

	<!-- container -->
	<div class="container">

		<h2 class="text-center top-space">Frequently Asked Questions</h2>
		<br>

		<div class="row">
			<div class="col-sm-6">
				<h3>Which code editor would you recommend?</h3>
				<p>I'd highly recommend you <a href="http://www.sublimetext.com/">Sublime Text</a> - a free to try text editor which I'm using daily. Awesome tool!</p>
			</div>
			<div class="col-sm-6">
				<h3>Nice header. Where do I find more images like that one?</h3>
				<p>
					Well, there are thousands of stock art galleries, but personally, 
					I prefer to use photos from these sites: <a href="http://unsplash.com">Unsplash.com</a> 
					and <a href="http://www.flickr.com/creativecommons/by-2.0/tags/">Flickr - Creative Commons</a></p>
			</div>
		</div> <!-- /row -->

		<div class="row">
			<div class="col-sm-6">
				<h3>Can I use it to build a site for my client?</h3>
				<p>
					Yes, you can. You may use this template for any purpose, just don't forget about the <a href="http://creativecommons.org/licenses/by/3.0/">license</a>, 
					which says: "You must give appropriate credit", i.e. you must provide the name of the creator and a link to the original template in your work. 
				</p>
			</div>
			<div class="col-sm-6">
				<h3>Can you customize this template for me?</h3>
				<p>Yes, I can. Please drop me a line to sergey-at-pozhilov.com and describe your needs in details. Please note, my services are not cheap.</p>
			</div>
		</div> <!-- /row -->

		<div class="jumbotron top-space">
			<h4>Dicta, nostrum nemo soluta sapiente sit dolor quae voluptas quidem doloribus recusandae facere magni ullam suscipit sunt atque rerum eaque iusto facilis esse nam veniam incidunt officia perspiciatis at voluptatibus. Libero, aliquid illum possimus numquam fuga.</h4>
     		<p class="text-right"><a class="btn btn-primary btn-large">Learn more »</a></p>
  		</div>

</div>	<!-- /container -->
	
	<!-- Social links. @TODO: replace by link/instructions in template -->
	<section id="social">
		<div class="container">
			<div class="wrapper clearfix">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_linkedin_counter"></a>
				<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
				</div>
				<!-- AddThis Button END -->
			</div>
		</div>
	</section>
	<!-- /social links -->


	<footer id="footer" class="top-space">

		<div class="footer1">
			<div class="container">
				<div class="row">
					
					<div class="col-md-3 widget">
						<h3 class="widget-title">Contact</h3>
						<div class="widget-body">
							<p>+234 23 9873237<br>
								<a href="mailto:#">some.email@somewhere.com</a><br>
								<br>
								234 Hidden Pond Road, Ashland City, TN 37015
							</p>	
						</div>
					</div>

					<div class="col-md-3 widget">
						<h3 class="widget-title">Follow me</h3>
						<div class="widget-body">
							<p class="follow-me-icons">
								<a href=""><i class="fa fa-twitter fa-2"></i></a>
								<a href=""><i class="fa fa-dribbble fa-2"></i></a>
								<a href=""><i class="fa fa-github fa-2"></i></a>
								<a href=""><i class="fa fa-facebook fa-2"></i></a>
							</p>	
						</div>
					</div>

					<div class="col-md-6 widget">
						<h3 class="widget-title">Text widget</h3>
						<div class="widget-body">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, dolores, quibusdam architecto voluptatem amet fugiat nesciunt placeat provident cumque accusamus itaque voluptate modi quidem dolore optio velit hic iusto vero praesentium repellat commodi ad id expedita cupiditate repellendus possimus unde?</p>
							<p>Eius consequatur nihil quibusdam! Laborum, rerum, quis, inventore ipsa autem repellat provident assumenda labore soluta minima alias temporibus facere distinctio quas adipisci nam sunt explicabo officia tenetur at ea quos doloribus dolorum voluptate reprehenderit architecto sint libero illo et hic.</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

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