<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/basket/inc/cart_functions.php';

if(ServerManager::isLocal()) {
	print <<< END
	<section id="localhost-notification">localhost</section>
END;
}

$count = count_items();
?>	
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<div class="visible-xs second-basket">
					<a href="/basket/">
						<section class="cart-container">
							<p class="cart-num"><?php print $count;?></p>
							<img src="/images/housestyle/basket-icon.png" width="33"/>
						</section>
					</a>
				</div>

				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false">
					<div class="hb-container">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</div>
					<span class="hb-caption">MENU</span>
				</button>
				<a class="navbar-brand" href="/">
					<img src="/images/housestyle/pixel.gif" width=1 height=1 />
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div id="main-nav">
				<ul class="nav navbar-nav collapse navbar-collapse">
					<li><a href="/shop/">Shop</a></li>
					<li><a href="/corporate_weddings/">Wedding Favours</a></li>
					<li><a href="/contact/">Get in Touch</a></li>
					<li><a href="/chocolate_info/">Chocolate Info</a></li>
					<li><a href="/about/">About Us</a></li>
					<li class="hidden-xs">
						<a href="/basket/">
							<section class="cart-container">
								<p class="cart-num"><?php print $count;?></p>
								<img src="/images/housestyle/basket-icon.png" width="33"/>
							</section>
						</a>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container -->
	</nav>