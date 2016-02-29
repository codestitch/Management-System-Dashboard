<?php
	include_once('header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">
					<!--BEGIN TABS-->
					<div class="tabbable tabbable-custom tabbable-noborder">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_1_1" data-toggle="tab" id="overviewTab">
								Overview </a>
							</li>
							<li>
								<a href="#tab_1_3" data-toggle="tab" id="accountTab">
								Account </a>
							</li>
						</ul>
						<div class="tab-content" id="contentBody">
							<div class="tab-pane active" id="tab_1_1">
								<div class="row">
									<div class="col-md-3">
										<ul class="list-unstyled profile-nav">
											<li>
												<center><img src="assets/img/logo.png" class="img-responsive" alt="" id="prof_image" onError='this.src="assets/img/logo.png";'/></center>
											</li>
										</ul>
										<div id="accordion1" class="panel-group">
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_7"><i class="icon-badge"></i> Loyalty Settings</a>
													</h4>
												</div>
												<div id="accordion1_7" class="panel-collapse collapse">
													<div class="panel-body">
														<div class="row">
															<div class="col-md-12">
																<div class="portlet light">
																	<div class="portlet-title">
																		<div class="caption">Points Settings</div> 
																	</div>
																	<div class="portlet-body">
																		<h4>Earn Mode: <span class="label label-primary strong">POINTS</span></h4>
																		<h4>Base Amount: <strong id="prof_baseValue"></strong></h4>
																		<h4>Points Per Earn: <strong id="prof_basePoint"></strong> </h4>
																		<h4>Registration Points: <strong id="prof_regPoint"></strong></h4>
																	</div>
																</div>
															</div>
															<div class="col-md-12">
																<div class="portlet light">
																	<div class="portlet-title">
																		<div class="caption">Raffle Settings</div> 
																	</div>
																	<div class="portlet-body">
																		<h4>Raffle Status: <span class="label strong" id="prof_raffleStatus"></span></h4>
																		<h4>Raffle Value: <strong id="prof_raffleValue"></strong></h4>
																		<h4>Raffle Entry: <strong id="prof_raffleEntry"></strong></h4>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1"><i class="icon-users"></i> Contact Person</a>
													</h4>
												</div>
												<div id="accordion1_1" class="panel-collapse collapse">
													<div class="panel-body" id="prof_contact"></div>
												</div>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_2"><i class="icon-envelope"></i> E-Mail Address</a>
													</h4>
												</div>
												<div id="accordion1_2" class="panel-collapse collapse">
													<div class="panel-body" id="prof_email"></div>
												</div>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_3"><i class="icon-pointer"></i> Address</a>
													</h4>
												</div>
												<div id="accordion1_3" class="panel-collapse collapse">
													<div class="panel-body" id="prof_address"></div>
												</div>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_4"><i class="icon-screen-smartphone"></i> Mobile Number</a>
													</h4>
												</div>
												<div id="accordion1_4" class="panel-collapse collapse">
													<div class="panel-body" id="prof_mobile"></div>
												</div>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_5"><i class="icon-call-end"></i> Landline Number</a>
													</h4>
												</div>
												<div id="accordion1_5" class="panel-collapse collapse">
													<div class="panel-body" id="prof_landline"></div>
												</div>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_6"><i class="icon-printer"></i> Fax Number</a>
													</h4>
												</div>
												<div id="accordion1_6" class="panel-collapse collapse">
													<div class="panel-body" id="prof_fax"></div>
												</div>
											</div> 
											<div class="panel panel-info">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_8"><i class="icon-wrench"></i> Merchant Code</a>
													</h4>
												</div>
												<div id="accordion1_8" class="panel-collapse collapse">
													<div class="panel-body">

															<!-- <div class="col-md-12">
																<div class="portlet light"> -->
																	<!-- <div class="portlet-title">
																		<div class="caption">Merchant Code</div> 
																	</div> -->
																	<!-- <div class="portlet-body"> -->
																		<center><div id="qrcode"></div></center>
																	<!-- </div> -->
															<!-- 	</div>
															</div> -->
															</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="col-md-12 profile-info justify">
												<h1 id="prof_company"></h1>
												<p id="prof_website"></p>
												<div id="prof_about"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--tab_1_2-->
							<div class="tab-pane" id="tab_1_3">
								<div class="row profile-account">
									<div class="col-md-3">
										<ul class="ver-inline-menu tabbable margin-bottom-10">
											<li class="active">
												<a data-toggle="tab" href="#tab_1-1">
												<i class="fa fa-cog"></i> Company Profile </a>
												<span class="after">
												</span>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_2-2">
												<i class="fa fa-picture-o"></i> Application Logo</a>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_3-3">
												<i class="fa fa-lock"></i> Reset Password </a>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_4-4">
												<i class="fa fa-eye"></i> Loyalty Settings </a>
											</li>
										</ul>
									</div>
									<div class="col-md-9">
										<div class="tab-content">
											<div id="tab_1-1" class="tab-pane active">
												<form role="form" action="#">
													<div class="form-group">
														<label class="control-label">Company</label>
														<input id="companyField" type="text" placeholder="Enter your company here" class="form-control"/>
													</div>
													<div class="form-group" id="person1">
														<label class="control-label">Primary Contact (First Name)</label>
														<input  id="fnameField" type="text" placeholder="enter primary contact first name" class="form-control"/>
													</div>
													<div class="form-group" id="person1">
														<label class="control-label">Primary Contact (Middle Name)</label>
														<input  id="mnameField" type="text" placeholder="middle name" class="form-control"/>
													</div>
													<div class="form-group" id="person1">
														<label class="control-label">Primary Contact (Last Name)</label>
														<input  id="lnameField" type="text" placeholder="last name" class="form-control"/>
													</div>
													<div class="form-group" id="person2">
														<label class="control-label">Secondary Contact (First Name)</label>
														<input id="fnameField2" type="text" placeholder="first name" class="form-control"/>
													</div>
													<div class="form-group" id="person2">
														<label class="control-label">Secondary Contact (Middle Name)</label>
														<input id="mnameField2" type="text" placeholder="middle name" class="form-control"/>
													</div>
													<div class="form-group" id="person2">
														<label class="control-label">Secondary Contact (Last Name)</label>
														<input id="lnameField2" type="text" placeholder="last name" class="form-control"/>
													</div>
													<div class="form-group" id="landline">
														<label class="control-label">Primary Landline Number</label>
														<input id="phoneField" type="text" placeholder="primary landline number" class="form-control"/>
													</div>
													<div class="form-group" id="landline2">
														<label class="control-label">Secondary Landline Number</label>
														<input id="phoneField2" type="text" placeholder="secondary landline number" class="form-control"/>
													</div>
													<div class="form-group" id="mobile">
														<label class="control-label">Primary Mobile Number</label>
														<input id="mobileField" type="text" placeholder="primary mobile number" class="form-control"/>
													</div>
													<div class="form-group" id="mobile2">
														<label class="control-label">Secondary Mobile Number</label>
														<input id="mobileField2" type="text" placeholder="secondary mobile number" class="form-control"/>
													</div>
													<div class="form-group"  id="fax">
														<label class="control-label">Primary Fax</label>
														<input id="faxField" type="text" placeholder="primary fax number" class="form-control"/>
													</div>
													<div class="form-group" id="fax2">
														<label class="control-label">Secondary Fax</label>
														<input id="faxField2" type="text" placeholder="secondary fax number" class="form-control"/>
													</div>
													<div class="form-group" id="email">
														<label class="control-label">Email</label>
														<input id="emailField" type="text" placeholder="email" class="form-control"/>
													</div>
													<div class="form-group" id="emails2">
														<label class="control-label">Address</label>
														<input id="addField" type="text" placeholder="address" class="form-control"/>
													</div>
													<!-- <div class="form-group">
														<label class="control-label">About</label>
														<textarea id="aboutField" class="form-control" rows="3" placeholder="We are KeenThemes!!!"></textarea>
													</div> -->

													<label>About</label>
													<div name="summernote" id="aboutField"></div>

													<div class="form-group">
														<label class="control-label">Website Url</label>
														<input id="webField" type="text" placeholder="http://www.mywebsite.com" class="form-control"/>
													</div>

													<div class="form-group">
														<label class="control-label">MerchantCode</label>
														<input id="codeField" type="text" placeholder="address" class="form-control"/>
													</div>
																	
													<div class="margiv-top-10">
														<a href="#openEditValidation" data-toggle="modal"  class="btn green">
														Save Changes </a>
														<a href="javascript:;" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<div id="tab_2-2" class="tab-pane"> 
												
												<form id="upload_image" enctype="multipart/form-data" name="upload_image">

													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
															<img id="imgPreview" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
														</div>
														<div id="imageThumb" class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
														<div>
															<span class="btn default btn-file">
																<span class="fileinput-new">Select image</span>
																<span class="fileinput-exists">Change</span>
																<input id="currentImage" type="file" name="currentImage" />
															</span>
															<a href="javascript:;" id="imageRemoveBtn" class="btn default fileinput-exists" data-dismiss="fileinput">Remove</a>
														</div>
													</div>
													<p class="help-block justify margin-top-10">
														<span class="label label-sm label-danger">Note:</span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only
													</p>
													<div class="margin-top-10">
														<a href="#openImageValidation" data-toggle="modal"  class="btn green">
														Update </a>
													</div>

												</form>
													
											</div>
											<div id="tab_3-3" class="tab-pane">
												<form action="#">
													<div class="form-group">
														<label class="control-label">Current Password</label>
														<input id="curpassField" type="password" class="form-control"/>
													</div>
													<div class="form-group">
														<label class="control-label">New Password</label>
														<input id="newpassField" type="password" class="form-control"/>
													</div>
													<div class="form-group">
														<label class="control-label">Re-type New Password</label>
														<input id="repeatpassField" type="password" class="form-control"/>
													</div>
													<div class="margin-top-10">
														<button id="initPassButton" class="btn green">
														Change Password </button>
													</div>
													<button class="btn blue" data-toggle="modal" href="#passValidation" id="callValidateButton" style="display:none;">Update</button>

												</form>
											</div>
											<div id="tab_4-4" class="tab-pane">
												<form action="#">
													

													<div class="row">

														<div class="col-md-12">
															<div class="portlet light">
																<div class="portlet-title">
																	<div class="caption">Points Settings</div>
																	<div class="tools">
																		<a class="reload" href="javascript:;">
																		</a>
																	</div>
																</div>
																<div class="portlet-body">
																	<h4>Earn Mode: <span class="label label-primary strong">POINTS</span></h4>
																	<h4>Base Amount: <input id="baseField" type="text" placeholder="Enter amount here" class="form-control"/> </h4>
																	<h4>Points Per Earn:  <input id="pointearnField" type="text" placeholder="Enter point here" class="form-control"/> <strong id="prof_basePoint"></strong> </h4>
																	<h4>Registration Points: <input id="regField" type="text" placeholder="Enter registration point here" class="form-control"/>  </h4>
																</div>
															</div>
														</div>

														<div class="col-md-12">
															<div class="portlet light">
																<div class="portlet-title">
																	<div class="caption">Raffle Settings</div>
																	<div class="tools">
																		<a class="reload" href="javascript:;">
																		</a>
																	</div>
																</div>
																<div class="portlet-body">
																	<div class="md-checkbox">
																		<input type="checkbox" id="raffleStatField" class="md-check" />
																		<label for="raffleStatField" style="margin-top: -5px;">
																		<span></span>
																		<span class="check"></span>
																		<span class="box"></span>
																		Enable Raffle </label>
																	</div>	
																	
																	<h4>Raffle Entry: <input id="raffleEntryField" type="text" placeholder="Enter raffle entry" class="form-control"/> </h4>
																	<h4>Raffle Value: <input id="raffleValueField" type="text" placeholder="Enter value" class="form-control"/> </h4>
																	
																</div>
															</div>
														</div>

													<!-- 	<div class="col-md-12">
															<div class="portlet light">
																<div class="portlet-title">
																	<div class="caption">Multiplier Settings</div>
																	<div class="tools">
																		<a class="reload" href="javascript:;">
																		</a>
																	</div>
																</div>
																<div class="portlet-body">
																	<h4>Multiplier Mode: </h4>
																	<div class="md-checkbox">
																		<input type="checkbox" id="mulmodeField" class="md-check" />
																		<label for="mulmodeField" style="margin-top: -5px;">
																		<span></span>
																		<span class="check"></span>
																		<span class="box"></span>
																		Enable Multiplier </label>
																	</div>	
																	
																	<h4>Multiplier Key: <input id="mulKeyField" type="text" placeholder="Enter Key" class="form-control"/> </h4>
																	<h4>Multiplier Amount: <input id="mulAmtField" type="text" placeholder="Enter amount" class="form-control"/> </h4>
																	<h4>Multiplier Entry Per Earn: <input id="mulEntryField" type="text" placeholder="Enter entry per earn" class="form-control"/>  </h4>
																</div>
															</div>
														</div> -->

													</div>


													<!--end profile-settings-->
													<div class="margin-top-10">
														<button id="initLoyaltyBtn" class="btn green">
														Save Changes </button>
													</div>
													<button class="btn blue" data-toggle="modal" href="#loyaltyValidation" id="callLoyalValidateButton" style="display:none;">Update</button>

												</form>
											</div>
										</div>
									</div>
									<!--end col-md-9-->
								</div>
							</div>
							<!--end tab-pane-->
						</div>
					</div>
					<!--END TABS-->
				</div>


			</div>
			<!-- END PAGE CONTENT-->

				<!-- MODAL -->

				<div class="modal fade" id="openEditValidation" tabindex="-1" role="basic" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body" id="serviceBody">
								Are you sure you want to update record?
							</div>
							<div class="modal-footer">
								<button id="cancelBtn" type="button" class="btn default" data-dismiss="modal">Cancel</button>
								<a class="btn green" onclick="javascript: UpdateContact();" data-toggle="modal" data-focus-on="input:first">Yes</a>

							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>

				<div class="modal fade" id="openImageValidation" tabindex="-1" role="basic" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body" id="serviceBody">
								Are you sure you want to update image?
							</div>
							<div class="modal-footer">
								<button id="cancelBtn" type="button" class="btn default" data-dismiss="modal">Cancel</button>
								<a class="btn green" onclick="javascript: UpdateImage();" data-dismiss="modal" data-focus-on="input:first">Yes</a>

							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>


				<div class="modal fade" id="passValidation" tabindex="-1" role="basic" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body" id="serviceBody">
								Are you sure you want to update password?
							</div>
							<div class="modal-footer">
								<button id="passValidationCancelButton" type="button" class="btn default" data-dismiss="modal">Cancel</button>
								<a class="btn green" id="updatePassButton" data-dismiss="modal" data-focus-on="input:first">Yes</a>

							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>



				<div class="modal fade" id="loyaltyValidation" tabindex="-1" role="basic" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body" id="serviceBody">
								Are you sure you want to loyalty settings?
							</div>
							<div class="modal-footer">
								<button id="validateCancelButton" type="button" class="btn default" data-dismiss="modal">Cancel</button>
								<a class="btn green" id="updateLoyaltySettings" data-dismiss="modal" data-focus-on="input:first">Yes</a>

							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>

				<!-- END MODAL -->
			
		</div>
	</div>
	<!-- END CONTENT -->

<?php
	include_once('footer.php');
?>