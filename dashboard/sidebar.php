<?php

	$dashboard = "";
	$push_notification = "";
	$products = "";
	$add_products = "";
	$manage_products = "";
	$add_category = "";
	$manage_category = "";
	$post = "";
	$add_post = "";
	$manage_post = "";
	$location = "";
	$add_location = "";
	$manage_location = "";
	$campaign = "";
	$add_campaign = "";
	$manage_campaign = "";
	$staff = "";
	$add_staff = "";
	$manage_staff = "";
	$promo = "";
	$add_promo = "";
	$manage_promo = "";
	// $press = "";
	// $add_press = "";
	// $manage_press = "";
	$add_sku = "";
	$manage_sku = "";
	$add_tablet = "";
	$manage_tablet = "";
	$cardseries = "";

	if ($basename == 'dashboard') {
        $dashboard = "active";
    } elseif ($basename == 'push-notification') {
        $push_notification = "active";
    } elseif ($basename == 'add-products') {
        $add_products = "active";
        $products = "open";
    } elseif ($basename == 'manage-products') {
        $manage_products = "active";
        $products = "open";
    } elseif ($basename == 'add-category') {
        $add_category = "active";
        $menu = "open";
    } elseif ($basename == 'manage-category') {
        $manage_category = "active";
        $menu = "open";
    } elseif ($basename == 'add-post') {
        $add_post = "active";
        $post = "open";
    } elseif ($basename == 'manage-post') {
        $manage_post = "active";
        $post = "open";
    } elseif ($basename == 'add-location') {
        $add_location = "active";
        $location = "open";
    } elseif ($basename == 'manage-location') {
        $manage_location = "active";
        $location = "open";
    }elseif ($basename == 'add-campaign') {
        $add_campaign = "active";
        $campaign = "open";
    } elseif ($basename == 'manage-campaign') {
        $manage_campaign = "active";
        $campaign = "open";
    } elseif ($basename == 'add-staff') {
        $add_staff = "active";
        $staff = "open";
    } elseif ($basename == 'manage-staff') {
        $manage_staff = "active";
        $staff = "open";
    } elseif ($basename == 'add-promo') {
        $add_promo = "active";
        $promo = "open";
    } elseif ($basename == 'manage-promo') {
        $manage_promo = "active";
        $promo = "open";
    // } elseif ($basename == 'add-press') {
    //     $add_press = "active";
    //     $press = "open";
    // } elseif ($basename == 'manage-press') {
    //     $manage_press = "active";
    //     $press = "open";
    } elseif ($basename == 'add-sku') {
        $add_sku = "active";
        $sku = "open";
    } elseif ($basename == 'manage-sku') {
        $manage_sku = "active";
        $sku = "open";
    } elseif ($basename == 'add-tablet') {
        $add_tablet = "active";
        $tablet = "open";
    } elseif ($basename == 'manage-tablet') {
        $manage_tablet = "active";
        $tablet = "open";
    } elseif ($basename == 'cardseries') {
        $cardseries = "active";
    }

?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li class="start <?php echo $dashboard; ?>">
				<a href="dashboard.php">
					<i class="icon-speedometer"></i>
					<span class="title">Company Profile</span>
				</a>
			</li>
			<li class="<?php echo $push_notification; ?>">
				<a href="push-notification.php">
					<i class="icon-envelope-letter"></i>
					<span class="title">Push Notification</span>
				</a>
			</li>
			<li class="<?php echo $add_products.$manage_products.$add_category.$manage_category ?>">
				<a href="#">
					<i class="icon-bag"></i>
					<span class="title">Products</span>
					<span class="arrow <?php echo $products; ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php echo $add_category; ?>">
						<a href="add-category.php"><i class="fa fa-angle-right"></i>Add Category</a>
					</li>
					<li class="<?php echo $manage_category; ?>">
						<a href="manage-category.php"><i class="fa fa-angle-right"></i>Manage Category</a>
					</li>
					<li class="<?php echo $add_products; ?>">
						<a href="add-products.php"><i class="fa fa-angle-right"></i>Add Product</a>
					</li>
					<li class="<?php echo $manage_products; ?>">
						<a href="manage-products.php"><i class="fa fa-angle-right"></i>Manage Products</a>
					</li>
				</ul>
			</li>
			<li class="<?php echo $add_post.$manage_post; ?>">
				<a href="#">
					<i class="icon-book-open"></i>
					<span class="title">News</span>
					<span class="arrow <?php echo $post; ?>"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php echo $add_post; ?>">
						<a href="add-post.php"><i class="fa fa-angle-right"></i>Add News</a>
					</li>
					<li class="<?php echo $manage_post; ?>">
						<a href="manage-post.php"><i class="fa fa-angle-right"></i>Manage News</a>
					</li>
				</ul>
			</li>
			<li class="<?php echo $add_location.$manage_location; ?>">
				<a href="#">
					<i class="icon-direction"></i>
					<span class="title">Locations</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">

					<?php 
						if ($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ROLE'] == "developer") {
					?>
						<li class="<?php echo $add_location?>">
							<a href="add-location.php"><i class="fa fa-angle-right"></i>Add Location</a>
						</li>
					<?php 
						}
					?>

					<li class="<?php echo $manage_location?>">
						<a href="manage-location.php"><i class="fa fa-angle-right"></i>Manage Locations</a>
					</li>
				</ul>
			</li>
			<li class="<?php echo $add_campaign.$manage_campaign?>">
				<a href="#">
					<i class="icon-present"></i>
					<span class="title">Campaigns</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php echo $add_campaign?>">
						<a href="add-campaign.php"><i class="fa fa-angle-right"></i>Add Campaigns</a>
					</li>
					<li class="<?php echo $manage_campaign?>">
						<a href="manage-campaign.php"><i class="fa fa-angle-right"></i>Manage Campaigns</a>
					</li>
				</ul>
			</li>
<!-- 			<li class="<?php //echo $add_staff.$manage_staff?>">
				<a href="#">
					<i class="icon-users"></i>
					<span class="title">Doctors</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php //echo $add_staff?>">
						<a href="add-staff.php"><i class="fa fa-angle-right"></i>Add Doctors</a>
					</li>
					<li class="<?php //echo $manage_staff?>">
						<a href="manage-staff.php"><i class="fa fa-angle-right"></i>Manage Doctors</a>
					</li>
				</ul>
			</li> -->
			<li class="<?php echo $add_promo.$manage_promo?>">
				<a href="#">
					<i class="icon-handbag"></i>
					<span class="title">Promo</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php echo $add_promo?>">
						<a href="add-promo.php"><i class="fa fa-angle-right"></i>Add Promo</a>
					</li>
					<li class="<?php echo $manage_promo?>">
						<a href="manage-promo.php"><i class="fa fa-angle-right"></i>Manage Promo</a>
					</li>
				</ul>
			</li>
<!-- 			<li class="<?php //echo $add_press.$manage_press?>">
				<a href="#">
					<i class="icon-star"></i>
					<span class="title">Press</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php //echo $add_press?>">
						<a href="add-press.php"><i class="fa fa-angle-right"></i>Add Press</a>
					</li>
					<li class="<?php //echo $manage_press?>">
						<a href="manage-press.php"><i class="fa fa-angle-right"></i>Manage Press</a>
					</li>
				</ul>
			</li> -->

			<!-- DEVELOPER ACCOUNT -->
			<?php 
				if ($_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ROLE'] == "developer") {
			?>

		<!-- 	<li class="<?php //echo $add_sku.$manage_sku?>">
				<a href="#">
					<i class="icon-layers"></i>
					<span class="title">SKU Management</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php// echo $add_sku?>">
						<a href="add-sku.php"><i class="fa fa-angle-right"></i>Add SKU</a>
					</li>
					<li class="<?php// echo $manage_sku?>">
						<a href="manage-sku.php"><i class="fa fa-angle-right"></i>Manage SKU</a>
					</li>
				</ul>
			</li> -->

			<li class="<?php echo $add_tablet.$manage_tablet?>">
				<a href="#">
					<i class="icon-screen-tablet"></i>
					<span class="title">Tablet Management</span>
					<span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li class="<?php echo $add_tablet?>">
						<a href="add-tablet.php"><i class="fa fa-angle-right"></i>Add Tablet</a>
					</li>
					<li class="<?php echo $manage_tablet?>">
						<a href="manage-tablet.php"><i class="fa fa-angle-right"></i>Manage Tablet</a>
					</li>
				</ul>
			</li>

			<!-- 
			<li class="<?php //echo $cardseries; ?>">
				<a href="cardseries.php">
					<i class="icon-credit-card"></i>
					<span class="title">Card Generator</span>
				</a>
			</li> -->


			<?php } ?>

			<!-- END DEVELOPER ACCOUNT -->
			

		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>
<!-- END SIDEBAR -->