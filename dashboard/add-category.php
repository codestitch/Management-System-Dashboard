<?php
	include_once('header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12" id="contentBody">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i><?php echo ucwords(str_ireplace("-"," ",$basename)); ?>
							</div> 
						</div>
						<div class="portlet-body">

							<div class="form-body">
								<!-- <h3 class="form-section">Person Info</h3> -->
								
								<div class="row">
								
									<div class="col-md-6">
										<div class="form-group">
											<label>Image</label>
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
															<input type="file" name="form_image" id="form_image"/>
														</span>
														<a href="javascript:;" id="imgRemoveButton" class="btn default fileinput-exists" data-dismiss="fileinput">Remove</a>
													</div>
												</div>
												<p class="help-block justify margin-top-10">
													<span class="label label-sm label-danger">Note:</span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only
												</p>
											</form>
										</div>


									</div>
									<!--/span-->
									<div class="col-md-6">
										
									</div>
									<!--/span-->

								</div>
								<!--/row-->

								<br/>

								<div class="row">
									<div class="col-md-12">

										<div class="col-md-6">
											<div class="form-group form-md-line-input form-md-floating-label has-info">
												<input type="text" class="form-control" id="nameField">
												<label for="nameField">Name</label>
												<span class="help-block">Write the Category Name Here...</span>
											</div>

											<!-- <div class="form-group form-md-line-input form-md-floating-label has-info">
												<input type="text" class="form-control" id="iconField">
												<label for="iconField">Icon</label>
												<span class="help-block">Write the Category Icon Here...</span>
											</div> -->

											<div class="md-checkbox">
												<input type="checkbox" id="statusField" class="md-check" />
												<label for="statusField">
												<span></span>
												<span class="check"></span>
												<span class="box"></span>
												Status </label>
											</div>
										</div>
										<div class="col-md-6">		

											<br/>
											<div class="form-group">
												<label>Enter Captcha</label>
												<div class="input-group">
													<div class="g-recaptcha" data-sitekey="6LcI2w4TAAAAAGW-GmKy3fPmtwJR50Y526qtUeOz"></div>
												</div>
											</div>
																				
											<div class="margin-top-10">
												<a href="javascript:;" id="addButton" class="btn green">Submit</a>
												<a href="javascript:;" class="btn default">Cancel</a>
											</div>
										</div>
									</div>
								</div>
								<!--/row-->
				</div>
			</div>
			<!-- END SAMPLE TABLE PORTLET-->


		</div>
	</div>
	<!-- END CONTENT -->

<?php
	include_once('footer.php');
?>