<?php
	include_once('header.php');
?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content"> 
			

			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12" id="bodyContent">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption"><i class="icon-note"></i><?php echo ucwords(str_ireplace("-"," ",$basename)); ?></div>
							
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a> 
								<a href="javascript:;" id="reloadIcon" class="reload">
								</a> 
							</div>
						</div>
						<div id="MyController" class="portlet-body" ng-controller="MyController" ng-init="onInitTable()">

							<div class="row">
					            <div class="col-xs-4">
					              <h3>Campaign Page: {{ currentPage }}</h3>
					            </div>
					            <div class="col-xs-4">
					              <label for="search">Search:</label>
					              <input ng-model="q" id="search" class="form-control" placeholder="Filter text">
					            </div>
					            <div class="col-xs-4">
					              <label for="search">items per page:</label>
					              <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
					            </div>
							</div>

							<div class="table-scrollable">
								<table class="table table-striped table-hover" id="dataTable">
								<thead>
								<tr> 
									<th>
										 Name
									</th>
									<th>
										 Promo Type
									</th>
									<th>
										 Points
									</th>
									<th>
										 Status
									</th>
									<th>
										 Action
									</th>
								</tr>
								</thead>
								<tbody id="bodyTable">
<!--| orderBy: 'name'-->
									<tr dir-paginate="product in products | filter:q | orderBy:predicate:reverse | itemsPerPage: pageSize" current-page="currentPage">
                                        
										<td>{{ product.name }}</td>
										<td>{{ product.promoType }}</td>
										<td>{{ product.points }} </td>
										<td>
											<span ng-if="product.status == 'active'" class='label label-sm label-success'> {{ product.status | uppercase }} </span>
											<span ng-if="product.status == 'inactive'" class='label label-sm label-danger'> {{ product.status | uppercase }} </span>
										</td>
										<td><a href="#" data-ng-click="editObject( product.loyaltyID )" class='btn default btn-xs black'> 
										<i class='fa fa-edit'></i> Edit </a> </td>
									</tr>

								</tbody>
								</table>

								<div ng-controller="OtherController">
									<div class="text-center">
									<dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="dirPagination.tpl.php"></dir-pagination-controls>
									</div>
						        </div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
			

			<!-- MODAL -->

			<!-- DELETE VALIDATION MODAL -->
			<a id="delModal" class="btn default" data-toggle="modal" href="#basic" style="display:none;"></a>
			<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Validation</h4>
						</div>
						<div class="modal-body">
							 Are you sure you want to remove selected record?
						</div>
						<div class="modal-footer">
							<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn blue" data-dismiss="modal" onclick="javascript: Delete(); ">Delete</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>

			<!-- INFORMATION MODAL -->
			<a id="alertModal" class="btn default" data-toggle="modal" href="#basicalert" style="display:none;"></a>
			<div class="modal fade" id="basicalert" tabindex="-1" role="basic" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title" id="alertTitle"></h4>
						</div>
						<div class="modal-body" id="alertBody">
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>

			<!-- EDIT INFORMATION MODAL -->
			<a id="editModalBtn" class="btn default" data-toggle="modal" href="#basicedit" style="display:none;" data-focus-on="input:first"></a>
			<div class="modal fade" id="basicedit" tabindex="-1" role="basic" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title" id="serviceTitle">Campaign Information</h4> 

						</div>
						<div class="modal-body" id="informationBody">
							<div  id="serviceBody"></div>
							<br/><br/>

						</div>
						<div class="modal-footer">
							<button id="editInfoBtn" type="button" class="btn default" data-dismiss="modal">Close</button>
							<a class="btn green" data-toggle="modal" href="#editValidation" data-focus-on="input:first">Update</a>

						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>

			<div class="modal fade" id="editValidation" tabindex="-1" role="basic" aria-hidden="true">
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
							<button type="button" id="closeBtn" class="btn default" data-dismiss="modal">Cancel</button>
							<a class="btn green" id="updateBtn" data-toggle="modal"  data-focus-on="input:first">Yes</a>

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