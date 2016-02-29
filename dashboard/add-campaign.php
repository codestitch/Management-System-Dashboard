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
									
									<div class="form-body">
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="campaignField">
											<label for="campaignField">Campaign Name</label>
											<span class="help-block">Type the name of campaign...</span>
										</div>
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="pointsField">
											<label for="pointsField">Points / Frequency:</label>
											<span class="help-block">Enter desired points / frequency for the campaign...</span>
										</div>
									</div>

									<div class="md-checkbox">
										<input type="checkbox" id="statusField" class="md-check" />
										<label for="statusField">
										<span></span>
										<span class="check"></span>
										<span class="box"></span>
										Enable Campaign </label>
									</div>	
									<br/><br/>
										
										<div class="form-group">
											<label>Enter Captcha</label>
											<div class="input-group">
												<div class="g-recaptcha" data-sitekey="6LcI2w4TAAAAAGW-GmKy3fPmtwJR50Y526qtUeOz"></div>
											</div>
										</div>
										
																			
										<div class="margin-top-10">
											<a href="javascript:;" class="btn green"  id="addButton">Submit</a>
											<a href="javascript:;" class="btn default">Cancel</a>
										</div>



								</div>

								<div class="col-md-6">
									<div class="form-body">


										<label>Description</label>
										<div name="summernote" id="descriptionField"></div>


										<label>Terms</label>
										<div name="summernote1" id="termsField"></div>



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