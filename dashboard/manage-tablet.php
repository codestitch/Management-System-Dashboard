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
								<i class="fa fa-edit"></i>Manage Tablet 
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a> 
									<a id="reloadIcon" href="javascript:;" id="reloadIcon" class="reload">
									</a> 
								</div>
							</div> 
						</div>
						<div id="MyController" class="portlet-body" ng-controller="MyController" ng-init="onInitTable()">

							<div class="row">
					            <div class="col-xs-4">
					              <h3>Tablet Management Page: {{ currentPage }}</h3>
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
										Device Code
									</th>
									<th>
										Device ID
									</th>
									<th>
										Location Name
									</th>
									<th>
										Status
									</th>
									<th>
										Deploy Status
									</th>
									<th>
										Action
									</th>
								</tr>
								</thead>
								<tbody id="bodyTable"> 
									
									<tr dir-paginate="item in items | filter:q | orderBy: 'categoryID':true | itemsPerPage: pageSize" current-page="currentPage">
										<td>{{ item.deviceCode }}</td>
										<td>{{ item.deviceID }}</td>
										<td>{{ item.locName }}</td> 
										<td>
											<span ng-if="item.status == 'active'" class='label label-sm label-success'> {{ item.status | uppercase }} </span>
											<span ng-if="item.status =='inactive'" class='label label-sm label-danger'> {{ item.status | uppercase }} </span>
										</td>
										<td>
											<span ng-if="item.deploy == 'true'" class='label label-sm label-success'> {{ item.deploy | uppercase }} </span>
											<span ng-if="item.deploy =='false'" class='label label-sm label-danger'> {{ item.deploy | uppercase }} </span>
										</td>
										<td><a href="#" data-ng-click="editObject( item.deviceCode )" class='btn default btn-xs black'> 
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
					<!-- END SAMPLE TABLE PORTLET-->

					
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
							<h4 class="modal-title" id="serviceTitle">Tablet Information</h4>

							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>

						</div>
						<div class="modal-body" id="informationBody">
							<!-- IMAGE -->
							<div class="form-group" id="imagePanel" style="display:none;">
								
							</div>
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
						<div class="modal-body">
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