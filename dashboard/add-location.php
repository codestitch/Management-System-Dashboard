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
							<div class="caption"><i class="icon-note"></i>Add Location</div> 
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-6">
									
									<form id="upload_img_form" enctype="multipart/form-data" name="upload_img_form">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
												<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
											<div>
												<span class="btn default btn-file">
													<span class="fileinput-new">Select image</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="upload_img" id="upload_img"/>
												</span>
												<a href="javascript:;" id="imgRemoveButton" class="btn default fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
										</div>
										<p class="help-block justify margin-top-10">
											<span class="label label-sm label-danger">Note:</span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only
										</p>
									</form>

									<div class="form-body">

										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="nameField">
											<label for="nameField">Location Name</label>
											<span class="help-block">Type the branch name or location name...</span>
										</div>
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="addressField">
											<label for="addressField">Address</label>
											<span class="help-block">Type the address of the location...</span>
										</div>
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="latField">
											<label for="latField">Latitude</label>
											<span class="help-block">Enter the latitude for google map...</span>
										</div>
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="longField">
											<label for="longField">Longitude</label>
											<span class="help-block">Enter the longitude for google map...</span>
										</div>
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-body">
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="branchField">
											<label for="branchField">Branch Code</label>
											<span class="help-block">Enter the branch code...</span>
										</div>
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="phoneField">
											<label for="phoneField">Phone</label>
											<span class="help-block">Enter phone number...</span>
										</div>
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="emailField">
											<label for="emailField">Email</label>
											<span class="help-block">Enter email address...</span>
										</div>

										<div class="md-checkbox">
											<input type="checkbox" id="loyaltyField" class="md-check" />
											<label for="loyaltyField">
											<span></span>
											<span class="check"></span>
											<span class="box"></span>
											Enable Loyalty </label>
										</div>	

										<div class="md-checkbox">
											<input type="checkbox" id="statusField" class="md-check" />
											<label for="statusField">
											<span></span>
											<span class="check"></span>
											<span class="box"></span>
											Enable Location </label>
										</div>	

										
										<div class="form-group">
											<label>Enter Captcha</label>
											<div class="input-group">
												<div class="g-recaptcha" data-sitekey="6LcI2w4TAAAAAGW-GmKy3fPmtwJR50Y526qtUeOz"></div>
											</div>
										</div>
													
										<div class="margin-top-10">
											<a href="javascript:;" id="addButton" class="btn green">Submit</a>
											<a href="javascript:;" id="clearButton" class="btn default">Cancel</a>
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