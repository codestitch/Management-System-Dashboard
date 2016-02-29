<?php
	include_once('header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content"> 
		

			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12" id="bodyContent">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i>Add News
							</div> 
						</div>
						<div class="portlet-body">

							<div class="form-body">
								<!-- <h3 class="form-section">Person Info</h3> -->

								<div class="row">
									<div class="col-md-4">
										
										<form id="upload_press_form" enctype="multipart/form-data" name="upload_press_form">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
													<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
												<div>
													<span class="btn default btn-file">
														<span class="fileinput-new">Select image</span>
														<span class="fileinput-exists">Change</span>
														<input type="file" name="press_image" id="press_image"/>
													</span>
													<a href="javascript:;" id="removeImage" class="btn default fileinput-exists" data-dismiss="fileinput">Remove</a>
												</div>
											</div>
											<p class="help-block justify margin-top-10">
												<span class="label label-sm label-danger">Note:</span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only
											</p>
										</form>
									</div>
								<!--/span-->
								<div class="col-md-8">
									<div class="form-group">
										<!-- <label class="control-label">Last Name</label>
										<input type="text" id="lastName" class="form-control" placeholder="Lim">
										<span class="help-block">
										This field has error. </span> -->
										<label>Description</label>
										<div name="summernote" id="postDescField"></div>

										
									</div>
								</div>
								<!--/span-->

								</div>
								<!--/row-->

								<br/>

								<div class="row">
									<div class="col-md-12">

										<div class="col-md-6">
											<div class="form-group form-md-line-input form-md-floating-label has-info">
												<input type="text" class="form-control" id="subjectField">
												<label for="subjectField">News Title</label>
												<span class="help-block">Write the News Title Here...</span>
											</div>
											<div class="md-checkbox">
												<input type="checkbox" id="statusField" class="md-check" />
												<label for="statusField">
												<span></span>
												<span class="check"></span>
												<span class="box"></span>
												Status </label>
											</div>
										</div>
										<div class="col-md-4">		
											<br/>
										
											<div class="form-group">
												<label>Enter Captcha</label>
												<div class="input-group">
													<div class="g-recaptcha" data-sitekey="6LcI2w4TAAAAAGW-GmKy3fPmtwJR50Y526qtUeOz"></div>
												</div>
											</div>
											
																				
											<div class="margin-top-10">
												<a href="javascript:;" class="btn green" id="addButton">Submit</a>
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
	<!-- END PAGE CONTENT-->

<?php
	include_once('footer.php');
?>