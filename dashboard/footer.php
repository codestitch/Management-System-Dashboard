<?php if ($basename == 'login') { ?>
<!-- BEGIN COPYRIGHT -->
<div class="copyright text-black">2015 &copy; Appsolutely Inc.</div>
<!-- END COPYRIGHT -->
<?php } elseif ($basename == '404') { ?>
<?php } elseif ($basename == '500') { ?>
<?php } else { ?>
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">2015 &copy; Appsolutely Inc.</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<?php } ?>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/js/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/js/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="assets/js/jquery.idletimeout.js" type="text/javascript"></script>
<script src="assets/js/jquery.idletimer.js" type="text/javascript"></script>

<?php if ($basename == 'login') { ?>
<script src="assets/js/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script src="assets/js/core/original/login.js" type="text/javascript"></script>
<?php
	} elseif ($basename == 'dashboard') {
?>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/qrcode.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/dashboard.js"></script>
<script type="text/javascript" src="assets/js/core/original/dashboardevents.js"></script>

<script>
jQuery(document).ready(function() {    
	ComponentsEditors.init();
});
</script>
<?php
	} elseif ($basename == 'push-notification') {
?>
<script type="text/javascript" src="assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/js/todo.js"></script>
<script type="text/javascript" src="assets/js/components-jqueryui-sliders.js"></script>
<script type="text/javascript" src="assets/js/core/original/push-notification.js"></script>

<?php
	} elseif ($basename == 'add-products') {
?>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/add-products.js"></script>
<script type="text/javascript">
	$(function() {
		ComponentsEditors.init();
	});
</script>

<?php
	} elseif ($basename == 'manage-products') {
?>

<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/manage-products.js"></script>
<script src="assets/js/core/original/dirPagination.js"></script>
<script type="text/javascript">
	$(function() {
		ComponentsEditors.init();
	});
</script>


<?php
	} elseif ($basename == 'add-category') {
?>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/add-category.js"></script>
<script type="text/javascript">
	$(function() {
		ComponentsEditors.init();
	});
</script>

<?php
	} elseif ($basename == 'manage-category') {
?>

<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/manage-category.js"></script>
<script src="assets/js/core/original/dirPagination.js"></script>
<script type="text/javascript">
	$(function() {
		ComponentsEditors.init();
	});
</script>

<?php
	}  elseif ($basename == 'add-post') {
?>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/add-news.js"></script>
<script type="text/javascript">
	$(function() {
		ComponentsEditors.init();
	});
</script>

<?php
	} elseif ($basename == 'manage-post') {
?>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/manage-news.js"></script>
<script src="assets/js/core/original/dirPagination.js"></script>
<script type="text/javascript">
	$(function() {
		ComponentsEditors.init();
	});
</script>

<?php
	} elseif ($basename == 'add-location') {
?>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/core/original/add-location.js"></script>

<?php
	} elseif ($basename == 'manage-location') {
?>
<script type="text/javascript">
	var role = "";
	role = "<?php echo $_SESSION[MERCHANT_APPNAME.'_DASHBOARD_ACCOUNT_ROLE']; ?>";
</script>

<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/core/original/manage-location.js"></script>
<script src="assets/js/core/original/dirPagination.js"></script>

<?php
	} elseif ($basename == 'add-campaign') {
?>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/add-campaign.js"></script>
<script type="text/javascript">
	$(function() {
		ComponentsEditors.init();
	});
</script>

<?php
	} elseif ($basename == 'manage-campaign') {
?>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/manage-campaign.js"></script>
<script src="assets/js/core/original/dirPagination.js"></script>
<script type="text/javascript">
	$(function() {
		ComponentsEditors.init();
	});
</script>

<?php
	} elseif ($basename == 'add-promo') {
?>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/core/original/add-promo.js"></script>


<?php
	} elseif ($basename == 'manage-promo') {
?>

<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/manage-promo.js"></script>
<script src="assets/js/core/original/dirPagination.js"></script>


<?php
	} elseif ($basename == 'add-sku') {
?>

<script type="text/javascript" src="assets/js/core/original/add-sku.js"></script>
<?php
	} elseif ($basename == 'manage-sku') {
?>

<script type="text/javascript" src="assets/js/jquery.form.js"></script>
<script type="text/javascript" src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/js/components-editors.js"></script>
<script type="text/javascript" src="assets/js/plugins/bootstrap-summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/core/original/manage-sku.js"></script>
<script src="assets/js/core/original/dirPagination.js"></script> 



<?php
	} elseif ($basename == 'add-tablet') {
?>

<script type="text/javascript" src="assets/js/core/original/add-tablet.js"></script>
<?php
	} elseif ($basename == 'manage-tablet') {
?>

<script src="assets/js/core/original/dirPagination.js"></script>
<script type="text/javascript" src="assets/js/core/original/manage-tablet.js"></script>


<?php
	} elseif ($basename == 'cardseries') {
?>
<script type="text/javascript" src="assets/js/core/original/cardseries.js"></script>
<?php } ?>




<!-- END PAGE LEVEL SCRIPTS -->
<!-- <script src="assets/admin/pages/scripts/ui-toastr.js"></script> -->

<script src="assets/js/metronic.js" type="text/javascript"></script>
<script src="assets/js/plugins/admin/layout.js" type="text/javascript"></script>
<!--script src="assets/js/plugins/admin/demo.js" type="text/javascript"></script-->
<script src="assets/js/plugins/admin/ui-idletimeout.js" type="text/javascript"></script>
<script type="text/javascript">
	var basename = "<?php echo $basename ?>";
</script>
<script src="assets/js/core/original/core.js" type="text/javascript"></script>
<?php if (($basename == '404') || ($basename == '500')) { ?>
<script src="assets/js/core/error.js"></script>
<?php } ?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>