<?php
	include_once('header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE HEADER-->
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<?php 

						$server = $_SERVER['DOCUMENT_ROOT'];
						$root = explode('/', $server);
						$dirlist='vol '.$root[0]; // DOS directory list command // /o/a 
						//echo 'Initial Directory Listing: ' .$dirlist ;
						$result = shell_exec($dirlist) ;
						$exp = explode(' ', $result);
						echo $exp[12];

					?>
					<h1>Blank Page <small>blank page</small></h1>
				</div>
				<!-- END PAGE TITLE -->
				<!-- BEGIN PAGE TOOLBAR
				<?php // include_once('toolbar.php'); ?>
				END PAGE TOOLBAR -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					Page content goes here
					<button id="test_toast" class="btn btn-success">Toast!</button>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->

<?php
	include_once('footer.php');
?>