<?php
	include_once('header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12" id="contentBody">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption"><i class="icon-note"></i><?php echo ucwords(str_ireplace("-"," ",$basename)); ?></div> 
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-6">
									
									<div class="form-group form-md-line-input has-info">
										<select class="form-control" id="locationField">
											<option value="">Select Location</option>
										</select>
										<label for="locationField">Location</label>
									</div>

								</div>

								<div class="col-md-6">
									<div class="form-body">

										<br/>
										<div class="md-checkbox">
											<input type="checkbox" id="statusField" class="md-check" />
											<label for="statusField">
											<span></span>
											<span class="check"></span>
											<span class="box"></span>
											Enable Tablet </label>
										</div>
										<br/>
										

										<div class="form-group">
											<label>Enter Captcha</label>
											<div class="input-group">
												<div class="g-recaptcha" data-sitekey="6LcI2w4TAAAAAGW-GmKy3fPmtwJR50Y526qtUeOz"></div>
											</div>
										</div>
										
										<div class="margin-top-10">
											<a href="javascript:;" class="btn green"   id="addButton">Submit</a>
											<a href="javascript:;" class="btn default">Cancel</a>
										</div>

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