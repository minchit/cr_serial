<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($cr_data);

?>
<HTML>
	<head>
	<!-- <meta http-equiv="refresh" content="5" /> -->
	    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    
    
    
   	<script>
   	
   	
   	var $cr_id;

	$( document ).ready(function() {
   		<?php 
				if(!empty($cookies))
				{
					echo "$('#cr_processed_by').val('".$_COOKIE['cr_processed_by']."').change();";
					
				}
				
			?>
   	});
		jQuery(function($){
			$(document).ready(function() {
			    $('input[type=radio][name=radio]').change(function() {
			        if (this.value == 'CR_ID') {
			            Enable_CR();
			            Disable_CR_Range();
			            Disable_Submit_Date();
			            Disable_Request();
			            Disable_Process_Date();
			            Disable_Process_By();
			            <?php $_SESSION['radio']='CR_D'; ?>
			        }
			        else if (this.value == 'CR_ID_Range') {
			            Enable_CR_Range();
			            Disable_CR();
			            Disable_Submit_Date();
			            Disable_Request();
			            Disable_Process_Date();
			            Disable_Process_By();
			            <?php $_SESSION['radio']='CR_ID_Range'; ?>
			        }
			        else if(this.value=='Submitted_Date')
			        {
			        	Enable_Submit_Date();
			        	Disable_CR();
			            Disable_CR_Range();
			            Disable_Request();
			            Disable_Process_Date();
			            Disable_Process_By();
			            <?php $_SESSION['radio']='Submitted_Date'; ?>
				    }
			        else if(this.value=='Requestor')
			        {
			        	Enable_Request();
			        	Disable_CR_Range();
			            Disable_Submit_Date();
			            Disable_CR();
			            Disable_Process_Date();
			            Disable_Process_By();
			            <?php $_SESSION['radio']='Requestor'; ?>
				    }
			        else if(this.value=='Processed_Date')
			        {
			        	Enable_Process_Date();
			        	Disable_CR_Range();
			            Disable_Submit_Date();
			            Disable_Request();
			            Disable_CR();
			            Disable_Process_By();
			            <?php $_SESSION['radio']='Processed_Date'; ?>
				    }
			        else if(this.value=='Processed_By')
			        {
			        	Enable_Process_By();
			        	Disable_CR_Range();
			            Disable_Submit_Date();
			            Disable_Request();
			            Disable_Process_Date();
			            Disable_CR();
			            <?php $_SESSION['radio']='Processed_By'; ?>
				    }
					
				    
			    });
			});
			function Enable_CR()
			{
				$("#cr_id_search").show();
				$("#cr_id_search1").show();
			}
			function Disable_CR()
			{
				$("#cr_id_search").hide();
				$("#cr_id_search1").hide();
			}
			function Enable_CR_Range()
			{
				$("#cr_range_from").show();
	            $("#cr_range_from1").show();
	            $("#cr_range_to").show();
	            $("#cr_range_to1").show();
			}
			function Disable_CR_Range()
			{
				$("#cr_range_from").hide();
	            $("#cr_range_from1").hide();
	            $("#cr_range_to").hide();
	            $("#cr_range_to1").hide();
			}
			function Enable_Submit_Date()
			{
				$("#submit_date").show();
				$("#submit_date1").show();
			}
			function Disable_Submit_Date()
			{
				$("#submit_date").hide();
				$("#submit_date1").hide();
			}
			function Enable_Request()
			{
				$("#request").show();
				$("#request1").show();
			}
			function Disable_Request()
			{
				$("#request").hide();
				$("#request1").hide();
			}
			function Enable_Process_Date()
			{
				$("#process_date").show();
				$("#process_date1").show();
			}
			function Disable_Process_Date()
			{
				$("#process_date").hide();
				$("#process_date1").hide();
			}
			function Enable_Process_By()
			{
				$("#process_by").show();
				$("#process_by1").show();
			}
			function Disable_Process_By()
			{
				$("#process_by").hide();
				$("#process_by1").hide();
			}
			function doconfirm()
			{
			    job=confirm("Are you sure to delete permanently?");
			    if(job!=true)
			    {
			        return false;
			    }
			}
			
			 
			 $( "#result table tr" ).click(function(e) {
				 //call_me(this.id);
				 $cr_id=this.id;
				 var cr_id=$cr_id;
				 //alert($cr_id);
				//cr_id=$cr_id;
				var submit = $(this).find(":submit").attr('value','Saved!'); //Creating closure for setTimeout function. 
    		//setTimeout(function() { 
        		//$( "#tbl1" ).load( " #tbl1" );
    		//}, 2000); //refresh every 2 seconds
    		document.getElementById("Reserve").value = "Update";
    		$("html, body").animate({ scrollTop: 0 }, "slow");
    		  
    		document.getElementById("cr_id").readonly=true;
    		//document.getElementById("New").hidden="false";
				$.ajax({
			         type: "POST",
			         url:"<?php echo base_url();?>"+"index.php/cr/select_cr" ,
			         
			         dataType: "text",  
			         data:{cr_id:cr_id},
			         
			         success:function(data){
			        	 if( !$.isArray(data) ||  !data.length )
			        	 {
			        		 var dataObj = JSON.parse(data);
	        	         	 
							 $('#cr_id').val(dataObj[0].cr_id);
							 $('#cr_title').val(dataObj[0].cr_title);
							 $('#cr_description').val(dataObj[0].cr_description);
							 $('#cr_submitted').val(dataObj[0].cr_submitted);
							 $('#cr_requestor').val(dataObj[0].cr_requestor);
							 $('#cr_requestor_unit').val(dataObj[0].cr_requestor_unit);
							 $('#cr_approval_ran').val(dataObj[0].cr_approval_ran);
							 $('#cr_approval_transmission').val(dataObj[0].cr_approval_transmission);
							 $('#cr_approval_build').val(dataObj[0].cr_approval_build);
							 $('#cr_approval_operations').val(dataObj[0].cr_approval_operations);
							 $('#cr_status_processed').val(dataObj[0].cr_status_processed);
							 
							 $('#cr_processed_by').val(dataObj[0].cr_processed_by);
							 							 						 
				        }
			        	 
			           },
			      });
			    								 
			 	});
 
		});

		
		
		function call_me(param){
			alert(param);
		}
   	</script>
	<script type="text/javascript">
	
	//auto expand textarea
	function adjust_textarea(h) {
	    h.style.height = "20px";
	    h.style.height = (h.scrollHeight)+"px";
	}
	
	</script>
	<link rel="stylesheet" href="<?php echo base_url();?>css/table.css" type="text/css" />
	</head>
	<body bgcolor="#4F0B0B">
		<div class="header"><img src="<?php echo base_url();?>images/ooredoologo.png" height="30px"><label>Change Request</label></div>
		<div class="content">
		<table>
			<tr>
				<td>
					<form method="POST" action="<?php echo base_url();?>index.php/cr/insert_inidata" class="form-style-4">
						<table>
							<tr>
								<td><label for="cr_id" >CR ID:</label></td>
								<td><input type="text" maxlength="6"  id="cr_id" name="cr_id" value="<?php echo (string)$last_cr;?>"><br/>
								<td><label for="text">CR Title:</label></td>
								<td><input type="text" id="cr_title" name="cr_title"></td>
							</tr>
							<tr>
								<td><label for="cr_description">CR Description:</label></td>
								<td colspan='3'><input  type="text" size="67" class="cr_description" id="cr_description" name="cr_description"></</td>
							</tr>
							
							<tr>
								<td><label for="cr_submitted">CR Submitted:</label></td>
								
								<td><input type="date" id="cr_submitted"  name="cr_submitted" ></td>
								<td><label for="cr_requestor">CR Requestor:</label> </td>
								<td><input type="text" id="cr_requestor" name="cr_requestor"></td>
							</tr>
							<tr>
								<td><label for="cr_requestor_unit">CR Requestor Unit:</label></td>
								<td><input type="text" id="cr_requestor_unit" name="cr_requestor_unit" ><br/>
								<td><label for="cr_approval_ran">CR Approval RAN:</label></td>
								<td><input type="text" id="cr_approval_ran" name="cr_approval_ran"></td>
							</tr>
							<tr>
								<td><label for="cr_approval_transmission">CR Approval Transmission:</label></td>
								<td><input type="text" id="cr_approval_transmission" name="cr_approval_transmission"><br/></td>
								<td><label for="cr_approval_build">CR Approval Build:</label></td>
								<td><input type="text" id="cr_approval_build" name="cr_approval_build"><br/></td>
							</tr>
							<tr>
								<td><label for="cr_approval_operations">CR Approval Operations:</label></td>
								<td><input type="text" id="cr_approval_operations" name="cr_approval_operations"><br/></td>
								<td><label for="cr_status_processed">CR Status Processed:</label></td>
								<td><input type="date" id="cr_status_processed"  name="cr_status_processed"><br/></td>
							</tr>
							<tr>
								<td><label for="cr_processed_by">CR Processed By:</label></td>
								<td colspan='3'>
								<!-- <input type="text" id="cr_processed_by" name="cr_processed_by"><br/> -->
									<select id="cr_processed_by" name="cr_processed_by"> 
										<option value="none" selected="selected">Select OX Admin</option>
										<option value="Poe Poe Ei">Poe Poe Ei</option>
										<option value="Angela">Angela</option>
										<option value="May Zon Kyaw">May Zon Kyaw</option>
										<option value="Phyo Phyo Thwe">Phyo Phyo Thwe</option>
										<option value="May Zun Htoo">May Zun Htoo</option>
										<option value="Andras Kovacs">Andras Kovacs</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan=2>
								<input type="button" value="New" ID="New" name="New" onClick="refreshPage()"  />
									<input type="submit" value="Reserve" ID="Reserve" name="Reserve" />
									
									<script type="text/javascript">
									function refreshPage(){
										window.location.href = "<?php base_url();?>";
									}
									</script>
								</td>
								
							</tr>
						</table>
						
					</form>
				</td>
				<td>
					<form method="POST" action="<?php echo base_url();?>index.php/cr/show_cr" class="form-style-1">
						<table>
							<tr>
								<td colspan="2">
									<label for="searchby">Search By:</label> <br/>
									<input type="radio" name="radio" value='CR_ID'><label for="crid">CR ID</label><br/>
									<input type="radio" name="radio" value='CR_ID_Range'><label for="cridrange">CR ID Range</label><br/>
									<input type="radio" name="radio" value='Submitted_Date'><label for="submitteddate">Submitted Date</label><br/>
									<input type="radio" name="radio" value='Requestor'><label for="requestor">Requestor</label><br/>
									<input type="radio" name="radio" value='Processed_Date'><label for="processeddate">Processed Date</label><br/>
									<input type="radio" name="radio" value='Processed_By'><label for="processedby">Processed By</label><br/>
								</td>
							</tr>
							<tr>
								<td colspan="2"><label for="noth">__________________________________________________________</label></td>
							</tr>
							<tr>
								<td>
									<div id="cr_id_search"><label for="cr_id_search">CR ID:</label></div>
									<div id="cr_range_from" hidden="true"><label for="cr_id_from">CR ID From:</label></div>
									<div id="submit_date" hidden="true"><label for="submit_date">Submitted Date:</label></div>
									<div id="request" hidden="true"><label for="request">Requestor:</label></div>
									<div id="process_date" hidden="true"><label for="process_date">Processed Date:</label></div>
									<div id="process_by" hidden="true"><label for="process_by">Processed By:</label></div>
								</td>
								<td>	
									<div id="cr_id_search1"><input type="text" maxlength="6" size="6" id="cr_id_search" name="cr_id_search" ></div>
									<div id="cr_range_from1" hidden="true"><input type="text" maxlength="6" size="6"  id="cr_id_from" name="cr_id_from" ></div>
									<div id="submit_date1" hidden="true"><input type="date" id="submit_date"  name="submit_date"></div>
									<div id="request1" hidden="true"><input type="text" maxlength="6" size="6"  id="request" name="request" ></div>
									<div id="process_date1" hidden="true"><input type="date" id="process_date"  name="process_date"></div>
									<div id="process_by1"  hidden="true">
										<select id="cr_processed_by" name="cr_processed_by"> 
										<option value="none" selected="selected">Select OX Admin</option>
										<option>Poe Poe Ei</option>
										<option>Angela</option>
										<option>May Zon Kyaw</option>
										<option>Phyo Phyo Thwe</option>
										<option>May Zun Htoo</option>
										<option>Andras Kovacs</option>
									</select>
									</div>
								</td>
								
								
							</tr>
							<tr>
								<td>
									
									<div id="cr_range_to" hidden="true"><label for="cr_id_to">CR ID To:</label></div>
								</td>
								<td>
									
									<div id="cr_range_to1" hidden="true"><input type="text" maxlength="6" size="6" id="cr_id_to" name="cr_id_to" ></div>
								</td>
							</tr>
							<tr>
								<td>
									<input type="submit" value="Show" ID="Show" name="Show" />
								</td>
								<td>
									<input type="submit" value="Export" ID="Export" name="Export" />
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
			
			
			<div>
			<!-- 
			<form method="POST" action="<?php echo base_url();?>index.php/cr/show_cr" class="form-style-3">
				<table>
					<tr>
						<td>
							<label for="cr_id_from">CR ID From:</label>
							<input type="text" maxlength="6" size="6"  id="cr_id_from" name="cr_id_from" >
						</td>
						<td>
							<label for="cr_id_to">CR ID To:</label>
							<input type="text" maxlength="6" size="6" id="cr_id_to" name="cr_id_to" >
						</td>
						<td>
							<input type="submit" value="Show" ID="Show" name="Show" />
						</td>
					</tr>
				</table>
			</form> -->
			</div>
				<div id="result">
				<table class="CSSTableGenerator" id="tbl1">
					<tr>
						<th>CR ID</th>
						<th>Title</th>
						<th>Description</th>
						<th>Submitted</th>
						<th>Requestor</th>
						<th>Requestor Unit</th>
						<th>Approval RAN</th>
						<th>Approval Transmission</th>
						<th>Approval Build</th>
						<th>Approval Operations</th>
						<th>Status Processed</th>
						<th>Processed By</th> 
						<th></th>
					</tr>
					<?php 
						foreach ($cr_data as $row)
						{
							?><tr id=<?php echo $row->cr_id;?>> 
								<td>
									<?php echo $row->cr_id;?>
								</td>
								<td>
									<?php echo $row->cr_title;?>
								</td>
								<td>
									<?php echo $row->cr_description;?>
								</td>
								<td>
									<?php echo $row->cr_submitted;?>
								</td>
								<td>
									<?php echo $row->cr_requestor;?>
								</td>
								<td>
									<?php echo $row->cr_requestor_unit;?>
								</td>
								<td>
									<?php echo $row->cr_approval_ran;?>
								</td>
								<td>
									<?php echo $row->cr_approval_transmission;?>
								</td>
								<td>
									<?php echo $row->cr_approval_build;?>
								</td>
								<td>
									<?php echo $row->cr_approval_operations;?>
								</td>
								<td>
									<?php echo $row->cr_status_processed;?>
								</td>
								<td>
									<?php echo $row->cr_processed_by;?>
								</td>
								<td>
									<?php if($row->cr_processed_by==null or $row->cr_processed_by=='none')
									{
										?> 
										 <a href="<?php echo base_url()."index.php/cr/delete_cr/".$row->cr_id ?>" onclick="return confirm('Are you sure to delete this CR?');"> 
										<img src="<?php echo base_url();?>images/bin.png" width="20px" > </a>
									<?php }
										?>
									
								</td>
								
							</tr> <?php 
						}
					?>
				</table>
				
				</div>
				
			
			
		</div>
	</body>
</HTML>
