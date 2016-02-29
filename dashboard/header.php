<?php
	$baseURL = '../php/api/';
	include_once($baseURL.'sessions/dashboard.session.php');
	// /********** Base Name **********/
	// $basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);

	// session_start();
	// $_SESSION['AIVEE_DASHBOARD_ACCOUNT_ID'] = 'ACCTJIM143JEZ697';
	// $_SESSION['AIVEE_DASHBOARD_ACCOUNT_SESSION'] = '0gP0Nl5zntefMHy4ddMbiDfGEhGVFLyKMp8AeOb0kkiJi7K3BElhCHtDM015nc1F';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="myApp">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?php echo MERCHANT; ?> | <?php echo ucwords(str_ireplace("-"," ",$basename)); ?> Page</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="Customer Portal"/>
<meta content="" name="Appsolutely Inc. by fLuGr1M & CodeStitch"/>

<!-- BEGIN PACE PLUGIN FILES -->
<script src="assets/js/plugins/pace/pace.min.js" type="text/javascript"></script>
<link href="assets/js/plugins/pace/themes/pace-theme-big-counter.css" rel="stylesheet" type="text/css"/>
<!-- END PACE PLUGIN FILES -->

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="assets/js/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<link href="assets/js/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/animate.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link href="assets/js/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
<script src='https://www.google.com/recaptcha/api.js'></script>


<?php if ($basename == 'login') { ?>
<link href="assets/css/login-soft.css" rel="stylesheet" type="text/css"/>
<?php } else if (($basename == '404') || ($basename == '500')) { ?>
<link href="assets/css/error.css" rel="stylesheet" type="text/css"/>
<?php
	} else if ($basename == 'dashboard') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/profile-old.css" rel="stylesheet" type="text/css"/>
<?php
	} else if ($basename == 'push-notification') {
?> 

<?php
	} else if ($basename == 'add-products') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<?php
	} else if ($basename == 'manage-products') {
?>
<link rel="stylesheet" type="text/css" href="assets/css/select2.css">
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>

<!-- ANGULAR JS -->
<script src="assets/js/angular.min.js"></script>

<?php
	} else if ($basename == 'add-category') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<?php
	} else if ($basename == 'manage-category') {
?>
<link rel="stylesheet" type="text/css" href="assets/css/select2.css">
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>

<!-- ANGULAR JS -->
<script src="assets/js/angular.min.js"></script>

<?php
	} else if ($basename == 'add-post') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<?php
	} else if ($basename == 'manage-post') {
?>
<link rel="stylesheet" type="text/css" href="assets/css/select2.css">
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>

<!-- ANGULAR JS -->
<script src="assets/js/angular.min.js"></script>

<?php
	} else if ($basename == 'add-location') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<?php
	} else if ($basename == 'manage-location') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<!-- ANGULAR JS -->
<script src="assets/js/angular.min.js"></script>

<?php
	} else if ($basename == 'add-campaign') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<?php
	} else if ($basename == 'manage-campaign') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="assets/css/select2.css">
<!-- ANGULAR JS -->
<script src="assets/js/angular.min.js"></script>

<?php
	} else if ($basename == 'add-promo') {
?>
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
<?php
	} else if ($basename == 'manage-promo') {
?>
<link rel="stylesheet" type="text/css" href="assets/css/select2.css">
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<!-- ANGULAR JS -->
<script src="assets/js/angular.min.js"></script>

<?php
	} else if ($basename == 'add-sku') {
?>

<?php
	} else if ($basename == 'manage-sku') {
?>
<link rel="stylesheet" type="text/css" href="assets/css/select2.css">
<link href="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/> 
<!-- ANGULAR JS -->
<script src="assets/js/angular.min.js"></script>


<?php
	} else if ($basename == 'manage-tablet') {
?>

<script src="assets/js/angular.min.js"></script>


<?php } ?>
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN THEME STYLES -->
<link href="assets/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/light.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link href="assets/img/favicon.png" rel="shortcut icon"/>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<?php if ($basename == 'login') { ?>
<body class="login">
<?php } elseif ($basename == '404') { ?>
<body class="page-500-full-page">
<!-- <body class="page-404-full-page"> -->
<?php } elseif ($basename == '500') { ?>
<body class="page-500-full-page">
<?php } else { ?>
<body class="page-md page-header-fixed page-sidebar-closed-hide-logo page-footer-fixed">
<!-- BEGIN HEADER -->
<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="index.php">
			<img src="assets/img/logo.png" alt="logo" class="logo-default" style="width: 83px; margin-top: 3px; margin-left: 40%;"/>
			</a>


					<!-- 	<?php //echo $_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_SESSION']; ?>
						<?php //echo $_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ID']; ?> -->
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="username username-hide-on-mobile">My Account</span>


						<!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
						<img alt="" class="img-circle" src="assets/img/favicon.png"/>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							
							<li>
								<a href="logout.php">
								<i class="icon-key"></i>Log Out</a>
							</li>

						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>			
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<?php include_once('sidebar.php'); } ?>
<div class="preloader-wrapper">
    <div class="preloader-conainer">
        <div class="sk-cube-grid">
			<div class="sk-cube sk-cube1"></div>
			<div class="sk-cube sk-cube2"></div>
			<div class="sk-cube sk-cube3"></div>
			<div class="sk-cube sk-cube4"></div>
			<div class="sk-cube sk-cube5"></div>
			<div class="sk-cube sk-cube6"></div>
			<div class="sk-cube sk-cube7"></div>
			<div class="sk-cube sk-cube8"></div>
			<div class="sk-cube sk-cube9"></div>
		</div>
    </div>
</div>