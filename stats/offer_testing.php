<?php
include '../Login/config.php';
include '../Login/common.php';
include '../Login/users.php';
include '../Login/MenuBar.html';
//var_dump($_SESSION);
// Check if the user is logged in
//var_dump($_SESSION['valid']);
//echo offer_testing;
$pos = strpos($_SESSION['valid'] ,offer_testing);
//var_dump($pos);
if( $pos === false){
	header("HTTP/1.1 404 invalid user");
	echo "invalid user";
	exit;
}
session_start();
$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];

if(!isSet($_SESSION['username']))
{
header("Location: ../Login/login.php");
exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <title id='Description'>Test Drop Statistics</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="../jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="../jqwidgets/styles/blakes_theme.css" type="text/css" />
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcore.js"></script>
   	<script type="text/javascript" src="../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.columnsresize.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxinput.js"></script>


    <script type="text/javascript">
    	$(document).ready(function () {

    		$("#campaign_name_input").hide();
    		$("#campaign_id_input").hide();
    		$("#subject_line_input").hide();
    		$("#from_line_input").hide();
   		 	$("#jqxSubmitButton").hide();
      		$("#jqxWindowViewRequests").hide();
       		$("#listCountInput").hide();
       		$("#jqxSubmitButtonListCount").hide();

     		 //The source for the data in the grid.
            var gridSource =
            {
                //Will be returning json.
                datatype: "json",

                //Post the data to request.
              	type: "POST",

              	//The url to send the request to.
                url: 'testing_stats.php',

                //The fields that will be returned.
            	datafields: [
					{ name: 'campaign_id' },
					{ name: 'campaign_name' },
					{ name: 'list_count' },
					{ name: 'date_dropped' },
					{ name: 'opens' },
					{ name: 'open_percent' },
					{ name: 'clicks' },
					{ name: 'click_percent' },
					{ name: 'conversions' },
					{ name: 'conversion_percent' },
					{ name: 'epc' },


           	    ]
            };

            //The source for the data in the grid.
            var gridSourceViewRequests =
            {
                //Will be returning json.
                datatype: "json",

                //Post the data to request.
              	type: "POST",

              	//The url to send the request to.
                url: 'get_test_requests.php',

                //The fields that will be returned.
            	datafields: [
					{ name: 'campaign_id' },
					{ name: 'campaign_name' },
					{ name: 'from_line' },
					{ name: 'subject_line' },
					{ name: 'date_request_submitted' },

           	    ]
            };



            //The data adaptor for the grid source.
            var dataAdapter = new $.jqx.dataAdapter(gridSource, {autoBind: true, async: false, loadError: function (xhr, status, error) { alert('Error loading "' + gridSource.url + '" : ' + error);} });

            var  dataAdapterViewRequests = new $.jqx.dataAdapter(gridSourceViewRequests, {autoBind: true, async: false, loadError: function (xhr, status, error) { alert('Error loading "' + gridSource.url + '" : ' + error);} });


            $("#jqxgridViewRequests").jqxGrid({
            	width: 870,
                source: dataAdapterViewRequests,
                theme: 'blakes_theme',
                selectionmode: 'multiplerowsextended',
                sortable: true,
                pageable: true,
                autoheight: true,
                columnsresize: true,
                showstatusbar: true,
	            renderstatusbar: function (statusbar) {
	                // appends buttons to the status bar.
	                var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
	                var MarkAsTestedButton = $("<div id='markastested' style='float: left; margin-left: 5px;'><span style='margin-left: 4px; position: relative; top: -3px;'>Mark As Tested</span></div>");

	              	container.append(MarkAsTestedButton);
	                statusbar.append(container);

	                MarkAsTestedButton.jqxButton({ theme: 'blakes_theme', width: 105, height: 20 });

	            },

                columns: [
                          { text: 'Campaign ID', datafield: 'campaign_id', width: 150 },
                          { text: 'Campaign Name', datafield: 'campaign_name', width: 330 },
                          { text: 'From Line', datafield: 'from_line', width: 150 },
                          { text: 'Subject Line', datafield: 'subject_line', width: 100 },
                          { text: 'Date of Request', datafield: 'date_request_submitted', width: 140 },

                        ],
            });

            $("#markastested").click(function (event) {
            	var selectedrowindexes = $('#jqxgridViewRequests').jqxGrid('selectedrowindexes');
				if (selectedrowindexes.length > 0)
				{
					for(var index in selectedrowindexes )
					{
						var selectedRowData = $('#jqxgridViewRequests').jqxGrid('getrowdata', selectedrowindexes[index]);
						var selectedCampaignID = selectedRowData.campaign_id;

						$('#jqxWindowMarkAsTested').jqxWindow({

	                		 showCollapseButton: true, maxHeight: 200, maxWidth: 400, minHeight: 200, minWidth: 400, height: 200, width: 400, theme: 'blakes_theme',
		                        initContent: function () {
		                        	$("#listCountInput").jqxInput({ placeHolder: "List Count", height: 25, width: 200, theme: 'blakes_theme'});
		                        	$("#jqxSubmitButtonListCount").jqxButton({ width: '150', theme: 'blakes_theme' });
		                        	$("#listCountInput").show();
		                        	$("#jqxSubmitButtonListCount").show();
		                        	$("#jqxSubmitButtonListCount").click(function(event)
				                    {
		                        		$.ajax({
		              		  				url: "mark_as_tested.php",
		              		  				type: 'POST',
		              		  				data: {
		              							campaign_id:  	selectedCampaignID,
		              			  				list_count: 	$("#listCountInput").val(),
		                  			  		}
		              					}).done(function(msg) {
		                  					if (msg.indexOf("Success") > -1)
		                  					{
		                  						$("#jqxgridViewRequests").jqxGrid({source: dataAdapterViewRequests});
		                  						$("#jqxgrid").jqxGrid({source: dataAdapter});

		                  					}
		                  					else
		                  					{
		                      					alert(msg);
		                  					}

		              					}).fail(function(){
		              		  				alert('Server Error, please contact system admin');
		              					});

		                        		$('#jqxWindowMarkAsTested').jqxWindow('close');

		                        	});
				                }
		            	});

					}

				}

				else alert("No campaign selected in the grid");
            });

            var cellsrenderer = function(row, column, value, defaultHtml, columnSettings, rowData) {
            	var element = $(defaultHtml);
            	var amount = parseFloat(value.replace("$",""));
            	if (amount < 0.50)
            	{
                	element.css({ 'background-color': '#FF0000' });
                	element.css({ 'color': '#000000' });
            	}

            	else if (amount < 0.80 && amount >= 0.50 )
            	{
                	element.css({ 'background-color': '#FFFF00' });
                	element.css({ 'color': '#000000' });
            	}

            	else
            	{
                	element.css({ 'background-color': '#00FF00' });
                	element.css({ 'color': '#000000' });
                }

                return element[0].outerHTML;
            	return defaultHtml;
            }

            $("#jqxgrid").jqxGrid({
            	width: 1160,
                source: dataAdapter,
                theme: 'blakes_theme',
                selectionmode: 'multiplerowsextended',
                sortable: true,
                pageable: true,
                autoheight: true,
                columnsresize: true,
                columns: [
                          { text: 'Campaign ID', datafield: 'campaign_id', width: 150 },
                          { text: 'Campaign Name', datafield: 'campaign_name', width: 330 },
                          { text: 'Date Dropped', datafield: 'date_dropped', width: 130 },
                          { text: 'List Count', datafield: 'list_count', width: 150 },
                          { text: 'Clicks', datafield: 'clicks', width: 100 },
                          { text: 'Conversions', datafield: 'conversions', width: 100 },
                          { text: 'Conversion %', datafield: 'conversion_percent', width: 100 },
                          { text: 'EPC', datafield: 'epc', width: 100, cellsrenderer: cellsrenderer }
                        ],
	            showstatusbar: true,
	            renderstatusbar: function (statusbar) {
	                // appends buttons to the status bar.
	                var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
	                var addButton = $("<div style='float: left; margin-left: 5px;'><span style='margin-left: 4px; position: relative; top: -3px;'>Make Request</span></div>");
	                var viewButton = $("<div style='float: left; margin-left: 5px;'><span style='margin-left: 4px; position: relative; top: -3px;'>View Requests</span></div>");

	                var reloadButton = $("<div style='float: left; margin-left: 5px;'><span style='margin-left: 4px; position: relative; top: -3px;'>Reload</span></div>");

	              	container.append(addButton);
	              	container.append(viewButton);
	              	container.append(reloadButton);
	                statusbar.append(container);

	                addButton.jqxButton({ theme: 'blakes_theme', width: 85, height: 20 });
	                viewButton.jqxButton({ theme: 'blakes_theme', width: 105, height: 20 });
	                reloadButton.jqxButton({ theme: 'blakes_theme', width: 65, height: 20 });

	                // add new row.
	                addButton.click(function (event) {

	                    $('#jqxWindow').jqxWindow({
	                        showCollapseButton: true, maxHeight: 400, maxWidth: 700, minHeight: 200, minWidth: 200, height: 300, width: 600, theme: 'blakes_theme',
	                        initContent: function () {
	                       	 	$("#campaign_name_input").jqxInput({ placeHolder: "Campaign Name", height: 25, width: 400, theme: 'blakes_theme'});
	                            $("#campaign_id_input").jqxInput({ placeHolder: "Campaign ID", height: 25, width: 400, theme: 'blakes_theme'});
	                            $("#subject_line_input").jqxInput({ placeHolder: "Subject Line (Optinional)", height: 25, width: 400, theme: 'blakes_theme'});
	                            $("#from_line_input").jqxInput({ placeHolder: "From Line (Optinional)", height: 25, width: 400, theme: 'blakes_theme'});
	                            $("#jqxSubmitButton").jqxButton({ width: '150', theme: 'blakes_theme' });
	                            $('#jqxWindow').jqxWindow('focus');

	                        	$("#campaign_name_input").show();
	                    		$("#campaign_id_input").show();
	                    		$("#subject_line_input").show();
	                    		$("#from_line_input").show();
	                    		$("#jqxSubmitButton").show();

	                    		//Click event for the submit request button.
	                    		$("#jqxSubmitButton").click(function (event) {

	                    			$.ajax({
		                          		  url: "submit_test_request.php",
		                          		  type: 'POST',
		                          		  data: {
		                          				campaign_id:  	$("#campaign_id_input").val(),
		                          			  	campaign_name: 	$("#campaign_name_input").val(),
			                          			subject_line: 	$("#subject_line_input").val(),
			                          			from_line: 		$("#from_line_input").val(),

		                          			}
		                          		}).done(function(msg) {
			                          		if (msg.indexOf("Success") > -1)
			                          		{
			                          			$('#jqxWindow').jqxWindow('close');
			                          			$('#jqxWindowViewRequests').jqxWindow({
				           	                		 showCollapseButton: true, maxHeight: 400, maxWidth: 900, minHeight: 200, minWidth: 900, height: 300, width: 900, theme: 'blakes_theme',
				           		                        initContent: function () {
					           		                         $("#jqxgridViewRequests").jqxGrid({source: dataAdapterViewRequests});
					           		                   	}
				           		            	});

				           	                	$('#jqxWindowViewRequests').jqxWindow('open');
			                          		}
			                          		else
			                          		{
				                          		alert(msg);
			                          		}

		                          		}).fail(function(){
		                          		  alert('Failed');
		                          		});
		                    	});
	                        }
	                    });


						$('#jqxWindow').jqxWindow('open');
	                });

	                // reload grid data.
	                reloadButton.click(function (event) {
	                    $("#jqxgrid").jqxGrid({ source: dataAdapter });
	                });

	                viewButton.click(function (event) {
	                	$("#jqxgridViewRequests").jqxGrid({source: dataAdapterViewRequests});

	                	$('#jqxWindowViewRequests').jqxWindow({

	                		 showCollapseButton: true, maxHeight: 400, maxWidth: 900, minHeight: 200, minWidth: 900, height: 300, width: 900, theme: 'blakes_theme',
		                        initContent: function () {

		                        }
		            	});

	                	$('#jqxWindowViewRequests').jqxWindow('open');

	                });


	            },
           });
        });
    </script>

</head>
<body class='default'>
    <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left; position: absolute; left: 50%">
        <div id="jqxgrid" style="position: relative;left:-50%;"></div>
		<div id="jqxWindow">
        	<div id="windowHeader">
            	<span>Request Test Drop</span>
            </div>
            <div style="overflow: hidden;" id="windowContent">
				<input type="text" id="campaign_id_input"/>
				<input type="text" id="campaign_name_input"/><br/>
				<input type="text" id="from_line_input"/>
				<input type="text" id="subject_line_input"/><br/>
				<input style='margin-top: 20px;' type="submit" value="Submit" id='jqxSubmitButton' />
            </div>
       	</div>
        <div id="jqxWindowViewRequests">
        	<div id="windowHeaderViewRequests">
            	<span>Current Requests</span>
            </div>
            <div style="overflow: hidden;" id="windowContent">
				<div id="jqxgridViewRequests"></div>
            </div>
       	</div>
       	<div id="jqxWindowMarkAsTested">
       		<div id="jqxWindowHeaderMarkAsTested">
       			<span>Test Drop Properties</span>
       		</div>
       		<div style="overflow: hidden;" id="windowContent">
       			<input type="text" id="listCountInput"/><br/>
       			<input style='margin-top: 20px;' type="submit" value="Submit" id='jqxSubmitButtonListCount' />
       		</div>
       	</div>
    </div>
    </body>
</html>