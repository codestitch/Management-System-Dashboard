<?php
	include_once('header.php');
?>
	<!-- BEGIN CONTENT -->
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


			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12" id="contentBody">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption"><i class="icon-note"></i><?php echo ucwords(str_ireplace("-"," ",$basename)); ?></div>
							 
						</div>
						<div class="portlet-body form">

							<div class="portlet-body form">

									<div class="form-body">

										<div class="form-group">
											<label>Enter Message</label>
											<div class="input-group">
												<span class="input-group-addon">
												<i class="fa fa-envelope"></i>
												</span>
											<textarea id="notificationMessageField" class="form-control todo-taskbody-taskdesc" rows="8" placeholder="Enter Push Notification Message here..."></textarea>
												
											</div>
										</div>
										<div class="form-group">
											<label>Enter Captcha</label>
											<div class="input-group">
												<div class="g-recaptcha" data-sitekey="6Ld2WukSAAAAAFQwuvkFHAlg0tD0I3PwjAnXUs5n"></div>
											</div>
										</div>
										
									</div>

									<div class="form-actions"> 

										<button class="btn default" id="clearButton">Clear</button>
										<button class="btn green" data-toggle="modal" id="initButton">Send</button>
										<button class="btn green-haze" data-toggle="modal" href="#basic" id="modalClick" style="display:none">Send</button>
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
	
	<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Notification Confirmation</h4>
				</div>
				<div class="modal-body">
					Are you sure you want to continue to send this message among devices?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
					<button type="button" class="btn blue" data-dismiss="modal" id="sendButton">Yes</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

<?php
	include_once('footer.php');
?>