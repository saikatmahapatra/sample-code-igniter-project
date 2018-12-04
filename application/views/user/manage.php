<?php //echo isset($breadcrumbs) ? $breadcrumbs : ''; ?>
<div class="row heading-container">
    <div class="col-12">
        <h1 class="h3 mb-3 font-weight-normal"><?php echo isset($page_heading)? $page_heading:'Page Heading'; ?></h1>
    </div>
</div><!--/.heading-container-->


<div class="row">
    <div class="col-md-12">
        <?php
		// Show server side flash messages
		if (isset($alert_message)) {
			$html_alert_ui = '';                
			$html_alert_ui.='<div class="auto-closable-alert alert ' . $alert_message_css . ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$alert_message.'</div>';
			echo $html_alert_ui;
		}
		?>		
		<div class="grid-action-holder row my-2 px-3">
			<div class="col-md-8">
			<span class="mx-2"><i class="fa fa-circle text-success" aria-hidden="true"></i> Active</span>
			<span class="mx-2"><i class="fa fa-circle text-warning" aria-hidden="true"></i> Inactive</span>
			</div>
			<div class="col-md-4 text-right">
			<a href="<?php echo base_url($this->router->directory.$this->router->class.'/create_account');?>" class="btn btn-sm btn-outline-success" title="Add"> <i class="fa fa-plus"></i> Add New</a>
			</div>		
		</div><!--/.grid-action-holder-->
		
		
		<div class="table-responsive">
			<form class="form-inline my-3 " name="download" method="post" action="<?php echo current_url();?>">
				<input type="hidden" name="form_action" value="download">
				<button class="btn btn-sm btn-success" title="Download"> Download</button>
			</form>
				<table id="user-datatable" class="table ci-table table-striped">
					<thead class="thead-dark">
						<tr>
							<th>Employee Name</th>
							<th>Registered Email (W)</th>
							<th>Phone Number (P)</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<th>Employee Name</th>
							<th>Registered Email (W)</th>
							<th>Phone Number (P)</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
		</div><!--/.table-responsive-->
    </div>
</div>