    <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
        <div class="pull-right"> <?php echo app_name; ?>v1.2 </div>
        <div class="pull-left"> <?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?> &copy; <?php echo date('Y'); ?> | All rights reserved </div>
    </footer>
    
    <div class="modal fade" id="modal-popin" role="dialog">
        <div class="modal-dialog modal-dialog-popin">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close small" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle-o"></i> Close</span></button>
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body"> </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/main.min-2.2.js"></script>

<?php if($page_active=='dashboard'){ ?>
<script src="<?php echo base_url(); ?>assets/js/plugins/chartjs/Chart.min.js"></script>
<?php if(!empty($dash_type)){ ?>
<?php if($dash_type == 'Company Admin') { ?>
<script src="<?php echo base_url(); ?>assets/js/pages/base_pages_ecom_dashboard.js"></script>
<?php } else if($dash_type == 'Channel Partner') { ?>
<script src="<?php echo base_url(); ?>assets/js/pages/base_pages_partner_dashboard.js"></script>
<?php } else if($dash_type == 'Client') { ?>
<script src="<?php echo base_url(); ?>assets/js/pages/base_pages_client_dashboard.js"></script>
<?php } ?>
<?php } ?>
<?php } ?>
 
<?php if($page_active!='dashboard'){ ?>
<script src="<?php echo base_url(); ?>/assets/js/plugins/card/jquery.card.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/base_forms_wizard.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datetimepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/pages/base_tables_datatables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/masked-inputs/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/dropzonejs/dropzone.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/base_forms_pickers_more.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/base_pages_files.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/slick/slick.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/summernote/summernote.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/js/fileinput.js"></script>
<script>jQuery(function(){App.initHelpers(['summernote', 'ckeditor']);});</script>
<script>jQuery(function(){App.initHelpers('appear');jQuery('.js-card-form').card({container: '.js-card-container',formSelectors: {numberInput: '#checkout-cc-number',expiryInput: '#checkout-cc-expiry',cvcInput: '#checkout-cc-cvc',nameInput: '#checkout-cc-name'}});});</script>
<script>jQuery(function(){App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);});</script>
<script>jQuery(function(){App.initHelpers('slick');});</script>
<script>jQuery(function(){App.initHelpers('easy-pie-chart');});</script>
<?php } ?>
<script>jQuery(function(){App.initHelpers(['appear', 'appear-countTo']);});</script> 

<script src="<?php echo base_url(); ?>assets/js/jsform.js"></script>
<?php if(!empty($table_rec)){ ?>
<script type="text/javascript">
	$(document).ready(function() {
		//datatables
		var table = $('#dtable').DataTable({ 
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [[<?php if(!empty($order_sort)){echo $order_sort;} ?>]], //Initial order.
			"language": {
				"processing": "<i class='fa fa-spinner fa-2x fa-spin' aria-hidden='true'></i> Processing... please wait"
			},
			"pagingType": "full",
	 
			// Load data for the table's content from an Ajax source
			"ajax": {
				url: "<?php echo base_url($table_rec); ?>",
				type: "POST"
			},
	 
			//Set column definition initialisation properties.
			"columnDefs": [
				{ 
					"targets": [<?php if(!empty($no_sort)){echo $no_sort;} ?>], //columns not sortable
					"orderable": false, //set not orderable
				},
			],
	 
		});
	 
	});
</script>
<?php } ?>

<script type="text/javascript">
	function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;
	
		 document.body.innerHTML = printContents;
		 window.print();
		 document.body.innerHTML = originalContents;
	}
</script>

<script type="text/javascript">
	function ajax_check(str, path, res) {
		if(str == '' || str == 0 || str.length == 0) {
			document.getElementById(res).innerHTML = '';
			return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById(res).innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", path+"?str="+str, true);
			xmlhttp.send();
		}
	}
</script>
</body>
</html>