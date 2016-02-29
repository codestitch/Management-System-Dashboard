<?php
	include_once('header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption"><i class="icon-note"></i><?php echo ucwords(str_ireplace("-"," ",$basename)); ?></div>
							<div class="tools">
								<a class="reload" href="javascript:;">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-6">
									
									<div class="form-body">
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="cardField">
											<label for="cardField">Generation Limit</label>
											<span class="help-block">Type the name of campaign...</span>
										</div>
									</div>
								
									<div class="form-group">
										<label>Enter Captcha</label>
										<div class="input-group">
											<div class="g-recaptcha" data-sitekey="6LctW-kSAAAAAPeXvq3e2MVb-dCVaIXaZEn-jm1c"></div>
										</div>
									</div>
										

									<div class="margin-top-10">
										<a id="addButton" class="btn green">Submit</a>
										<a href="javascript:;" class="btn default">Cancel</a>
									</div>

								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->

<?php
	include_once('footer.php');
?>