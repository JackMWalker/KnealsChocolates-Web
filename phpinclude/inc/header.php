<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/basket/inc/cart_functions.php';

if(ServerManager::isLocal()) {
	print <<< END
	<section id="localhost-notification">localhost</section>
END;
}

$count = count_items();
?>
<nav class="navbar navbar-expand-lg navbar-default navbar-dark">
    <div class="container">
        <div class="row w-100">
            <a class="navbar-brand" href="/">
                <img src="/images/housestyle/pixel.gif" width=1 height=1 />
            </a>

            <div class="col">
                <ul class="d-flex d-lg-none d-xl-none flex-row h-100 align-items-center justify-content-end">
                    <li class="mx-2">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </li>
                    <li class="mx-2">
                        <div class="d-lg-none d-xl-none d-block second-basket">
                            <a href="/basket/">
                                <section class="cart-container">
                                    <p class="cart-num"><?php print $count;?></p>
                                    <img src="/images/housestyle/basket-icon.png" width="33"/>
                                </section>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>


            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/shop/">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/corporate_weddings/">Wedding Favours</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact/">Get in Touch</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/chocolate_info/">Chocolate Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about/">About Us</a>
                    </li>
                    <li class="nav-item d-none d-lg-list-item">
                        <a class="nav-link" href="/basket/">
                            <section class="cart-container">
                                <p class="cart-num"><?php print $count;?></p>
                                <img src="/images/housestyle/basket-icon.png" width="33"/>
                            </section>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</nav>