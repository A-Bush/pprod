<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();

// Add Stylesheets
$doc->addStyleSheet(JURI::root(true).'/templates/' . $this->template . '/css/dist/css/bootstrap.min.css');
$doc->addStyleSheet(JURI::root(true).'/templates/' . $this->template . '/js/slick/slick.css');
$doc->addStyleSheet(JURI::root(true).'/templates/' . $this->template . '/css/main.css');
$doc->addStyleSheet(JURI::root(true).'/templates/' . $this->template . '/css/responsive_recaptcha.css');

// Add JavaScript Frameworks

JHtml::_('bootstrap.framework');
$doc->addScript(JURI::root(true).'/templates/' . $this->template . '/js/slick/slick.js');
$doc->addScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyDsRztI0aZi93XWCMhzZE1bOIxUaQVG634');
$doc->addScript(JURI::root(true).'/templates/' . $this->template . '/js/script.js');


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <base href="templates/poparada/"> -->
	<jdoc:include type="head" />
<!-- CAPTCHA -->

<!-- END OF CAPTCHA -->
	<script>(function() {
		var _fbq = window._fbq || (window._fbq = []);
		if (!_fbq.loaded) {
		var fbds = document.createElement('script');
		fbds.async = true;
		fbds.src = '//connect.facebook.net/en_US/fbds.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(fbds, s);
		_fbq.loaded = true;
		}
		_fbq.push(['addPixelId', '1424029547890432']);
		})();
		window._fbq = window._fbq || [];
		window._fbq.push(['track', 'PixelInitialized', {}]);
		</script>
		<noscript><img height="1" width="1" alt="" style="display:none" src="/popa/rada/https://www.facebook.com/tr?id=1424029547890432&amp;ev=PixelInitialized" /></noscript>
	<!-- <link rel="stylesheet" href="css/dist/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" href="css/main.css"> -->
	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl; ?>/media/jui/js/html5.js"></script>
	<![endif]-->
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<!-- NAVIGATION -->

	<header>
		<nav id="top-nav" class="navbar navbar-white" role="navigation">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="/">
						<span class="brand-logo"><svg version="1.1" id="popa" xmlns="http://www.w3.org/2000/svg" x="0px"
													  y="0px"
								 width="106.299px" height="106.299px" viewBox="0 0 106.299 106.299" enable-background="new 0 0 106.299 106.299"
								 xml:space="preserve">
								<g id="logo">
									<path id="p" d="M79.725,0h-53.15C11.898,0,0,11.898,0,26.575v53.15c0,9.836,5.344,18.423,13.287,23.019V26.359
										c0-7.339,5.949-13.288,13.288-13.288h53.15c7.338,0,13.287,5.949,13.287,13.288v53.15c0,7.338-5.949,13.287-13.287,13.287H26.772
										l-11.149,11.148c3.339,1.513,7.047,2.354,10.952,2.354h53.15c14.677,0,26.574-11.897,26.574-26.574v-53.15
										C106.299,11.898,94.401,0,79.725,0z"/>
									<path id="around" d="M30.82,26.702h22.669c13.375,0,21.989,6.877,21.989,18.741c0,12.467-9.597,19.042-22.745,19.042h-7.254
										v15.112H30.82V26.702z M52.431,52.999c5.214,0,8.388-2.72,8.388-7.027c0-4.534-3.174-6.952-8.463-6.952h-6.876v13.979H52.431z"/>
								</g>
							</svg></span>
		      	<span class="brand-name">POPARADA</span>
		      </a>

		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="navbar-collapse-1">
			      <jdoc:include type="modules" name="nav" style="html5" />
			      <jdoc:include type="modules" name="top-right" style="html5" />
		      <div class="navbar-right">
		      	<ul class="nav navbar-nav">
		      	  <li>
		      	    <ul class="contacts collapse-toggle list-unstyled">
		      	      <li>044 232 86 40</li>
		      	      <li>096 716 40 40</li>
		      	      <li>093 701 40 40</li>
						<li><a type="button" href="http://hh.webcamp.com.ua/contact.html#callback">обратный звонок</a></li>
		      	    </ul>
		      	  </li>
		      	</ul>
		      	<ul class="nav navbar-nav">
		      	  <li>
		      	    <ul class="social collapse-toggle list-unstyled">
		      	      <li><a href="https://www.facebook.com/poparada.com.ua" target="blank"><span class="icon-facebook"></span></a></li>
		      	      <li><a href="https://vk.com/poparada" target="blank"><span class="icon-vk"></span></a></li>
		      	      <li><a href="https://instagram.com/poparada/" target="blank"><span class="icon-instagram"></span></a></li>
		      	    </ul>
		      	  </li>
		      	</ul>
		      </div>
		    </div><!-- /.navbar-collapse -->



		  </div><!-- /.container-fluid -->
		</nav>
	</header>

<!-- CAROUSEL -->

	<?php if ($this->countModules('carousel')) : ?>
	<script>
		function linkToCatalog() {location.href="/beskarkasnaya-mebel-katalog.html";}
	</script>

	<div id="carousel-slider" class="carousel slide">

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox" onclick="linkToCatalog()">
	    <div class="item active" style="background-image:url(images/carousel/carousel1.jpg)">
	      <!-- <div class="carousel-caption">
	        ...
	      </div> -->
	    </div>
	    <div class="item" style="background-image:url(images/carousel/carousel2.jpg)">

	    </div>
	    <div class="item" style="background-image:url(images/carousel/carousel3.jpg)">

	    </div>
	    <div class="item" style="background-image:url(images/carousel/carousel4.jpg)">

	    </div>
	    <div class="item" style="background-image:url(images/carousel/carousel5.jpg)">

	    </div>

	  </div>

	  <!-- Controls -->
	  <a class="carousel-control" href="#carousel-slider" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control" href="#carousel-slider" role="button" data-slide="next" style="right:0;left:auto;">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	  <nav id="top-subnav" class="start-position">
	  	<div class="container-fluid">
		    <ul id="top-subnavlist" class="list-inline text-center">
		    </ul>
	  	</div>
		</nav>
	</div><!-- /#carousel-slider -->
	<?php else : ?>

<!-- CONTENT -->
	<div class="content">
		<!-- subnav -->
				<nav id="top-subnav" class="start-position">
				<?php if ($this->countModules('top-subnav')) : ?>
					<jdoc:include type="modules" name="top-subnav" />
				<?php else : ?>
				  	<div class="container-fluid">
					    <ul id="top-subnavlist" class="list-inline text-center">
					    </ul>
				  	</div>
				<?php endif; ?>
				</nav>

	<?php endif; ?>


<!-- ABOUT -->
	<?php if ($this->countModules('about')) : ?>
		<div class="jumbotron">
		  <div class="container">
				<jdoc:include type="modules" name="about" />
				<div class="logo text-center">


					<svg version="1.1" id="popa" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
								 width="106.299px" height="106.299px" viewBox="0 0 106.299 106.299" enable-background="new 0 0 106.299 106.299"
								 xml:space="preserve">
								<g id="logo">
									<path id="p" d="M79.725,0h-53.15C11.898,0,0,11.898,0,26.575v53.15c0,9.836,5.344,18.423,13.287,23.019V26.359
										c0-7.339,5.949-13.288,13.288-13.288h53.15c7.338,0,13.287,5.949,13.287,13.288v53.15c0,7.338-5.949,13.287-13.287,13.287H26.772
										l-11.149,11.148c3.339,1.513,7.047,2.354,10.952,2.354h53.15c14.677,0,26.574-11.897,26.574-26.574v-53.15
										C106.299,11.898,94.401,0,79.725,0z"/>
									<path id="around" d="M30.82,26.702h22.669c13.375,0,21.989,6.877,21.989,18.741c0,12.467-9.597,19.042-22.745,19.042h-7.254
										v15.112H30.82V26.702z M52.431,52.999c5.214,0,8.388-2.72,8.388-7.027c0-4.534-3.174-6.952-8.463-6.952h-6.876v13.979H52.431z"/>
								</g>
							</svg>


				</div>
		  </div>
		</div>
	<?php endif; ?>



		<jdoc:include type="message" />
		<jdoc:include type="component" />
	</div><!-- content -->

<?php if ($this->countModules('company')) : ?>
	<jdoc:include type="modules" name="company" />
<?php endif; ?>

<?php if ($this->countModules('instafeed')) : ?>
	<jdoc:include type="modules" name="instafeed" />
	<?php
	$url = "https://api.instagram.com/v1/users/325609146/media/recent?access_token=7626787.af15809.7db9bb11c794465c81aecb08583b55b0&count=10";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$result = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result);?>
		<hr>
		<h3 id="instafeed" class="text-center item-title"><span class="icon-instagram"></span> <a href="https://instagram.com/poparada/" target="blank">poparada</a></h3>
			<div class="multiple-items">
				<?php foreach ($result->data as $post):?>
				 	<?php
				 		$src = $post->images->low_resolution->url;
				 		$caption = $post->caption->text;
				 	?>
					<div class="instapost">
						<img src="<?php echo $src ?>" class="img-responsive" alt="">
					</div>
				<?php endforeach; ?>
			</div>
			<!-- /.multiple-items -->

<?php endif; ?>
<!-- CLIENTS -->
	<?php if ($this->countModules('clients')) : ?>
	<?php
		$dir = $_SERVER['DOCUMENT_ROOT'];
			$imgDir = JURI::root(true).'/images/clients';
			$src = $dir.$imgDir;
			$content = array_diff(scandir($src, 1), array('..', '.'));
			$images = array_filter($content, function($item){
					$imgExtensions = array(
						'jpg',
						'jpeg',
						'gif',
						'png'
					);
					foreach ($imgExtensions as $img) {
						if(strpos(strtolower($item), $img) != false){
							return $item;
						}
					}
			});
		 ?>

		<jdoc:include type="modules" name="clients" />
		<hr>
		<h3 id="clients" class="text-center item-title">Наши клиенты</h3>
		<div class="responsive">
			<?php foreach ($images as $img) : ?>
				<div class="center">
					<img src="<?php echo $imgDir.'/'.$img?>" alt="" class="img-clients img-responsive center-center">
				</div>
			<?php endforeach; ?>
		</div><!-- /.responsive -->

	<script>
	 	jQuery(document).ready(function($) {
	 		NavBarView.addSlick.multiple();
	 		NavBarView.addSlick.responsive();
	 		NavBarView.addSlick.single();

	 	});
	 </script>
	<?php endif; ?>




<!-- BREADCRUMBS -->
		<jdoc:include type="modules" name="breadcrumbs" style="html5" />

<!-- FOOTER -->
	<footer>
		<jdoc:include type="modules" name="footer" style="html5" />
		<div class="text-center" style="padding: 10px 0 0 0;">
			<ul class="social list-inline">
      	      <li><a href="https://www.facebook.com/poparada.com.ua" target="blank"><span class="icon-facebook"></span></a></li>
      	      <li><a href="https://vk.com/poparada" target="blank"><span class="icon-vk"></span></a></li>
      	      <li><a href="https://instagram.com/poparada/" target="blank"><span class="icon-instagram"></span></a></li>
      	    </ul>
		</div>
		<div id="tm">
		<!--	<div class="module"> -->
				<div class="hidden-xs">
						<div style="color:grey; font-size: 80%; text-align: center;">
							<p><span style="font-family: courier new, courier, monospace;"><br><br>© </span>2010-<?php echo date('Y');?>. Студия Альтернативной мебели "POPARADA"</p>
							<p>Все права на материалы, размещенные на www.poparada.com.ua, охраняются в соответствии с законодательством Украины.</p>
							<p>При цитировании и использовании любых материалов и фотографий активная ссылка (гиперссылка) на www.poparada.com.ua обязательна.</p>
						</div>
			</div>
			<div class="visible-xs" style="color:grey; font-size: 100%; text-align: center;">
				<p><span style="font-family: courier new, courier, monospace;"><br><br>© </span>2010-<?php echo date('Y');?>. Студия Альтернативной мебели "POPARADA"</p>
			</div>
			<!-- </div> -->
		</div>
	</footer>


</body>
</html>