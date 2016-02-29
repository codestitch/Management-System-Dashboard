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
							<div class="caption">Add SKU</div> 
						</div>
						
						<div class="portlet-body">
							<div class="row">

								<div class="col-md-6">
									
									<div class="form-group">

										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="nameField">
											<label for="nameField">Name</label>
											<span class="help-block">Type the name of SKU...</span>
										</div>

										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="skuField">
											<label for="skuField">SKU Code</label>
											<span class="help-block">Type the name of SKU...</span>
										</div>

										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="priceField">
											<label for="priceField">Price</label>
											<span class="help-block">Type the name of SKU...</span>
										</div>
<!-- 
										<div class="form-group form-md-line-input has-info">
											<select class="form-control" id="promoField">
												<option value="bonus">Bonus Snap</option>
												<option value="frequency">Frequency</option>
											</select>
											<label for="promoField">Promo</label>
										</div> -->

									</div>

								</div>

								<div class="col-md-6">
									<div class="form-body">

										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="text" class="form-control" id="pointsField">
											<label for="pointsField">Points</label>
											<span class="help-block">Type the name of SKU...</span>
										</div>

										<div class="form-group form-md-line-input">
											<textarea id="descriptionField" class="form-control" rows="3" placeholder="Enter description of SKU"></textarea>
											<label for="form_control_1">Description</label>
										</div>

										<div class="md-checkbox">
											<input type="checkbox" id="statusField" class="md-check" />
											<label for="statusField">
											<span></span>
											<span class="check"></span>
											<span class="box"></span>
											Status </label>
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