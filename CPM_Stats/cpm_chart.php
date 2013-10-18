<?php
include '../Login/config.php';
include '../Login/common.php';
include '../Login/users.php';
include '../Login/MenuBar.html';
//var_dump($_SESSION);
// Check if the user is logged in
//var_dump($_SESSION['valid']);
//echo cpm_stats;
$pos = strpos($_SESSION['valid'] ,cpm_stats);
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
header("Location: /PHP/Login/login.php");
exit;
}
?>
<!doctype html>
<html lang="en">
<head>
	

    <link rel="stylesheet" href="../jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="../jqwidgets/styles/blakes_theme.css" type="text/css" />
    <script type="text/javascript" src="../scripts/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxscrollview.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxmenu.js"></script>
   	<script type="text/javascript" src="../jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdatetimeinput.js"></script>
	<script type="text/javascript" src="../jqwidgets/jqxcalendar.js"></script>
	<script type="text/javascript" src="../jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdropdownlist.js"></script>
	<script type="text/javascript" src="../jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxchart.js"></script>
 	<script type="text/javascript" src="../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdragdrop.js"></script>
    <script type="text/javascript" src="../scripts/gettheme.js"></script>
    <script type="text/javascript">
    
          $(document).ready(function() {
        	  
               var theme = getDemoTheme();
                var url = "DisplayResults.php";
               //prepare data
              var  source ={
                    datatype: "json",
                    type: "POST",
                    datafields:[
                    { name: 'MessageID', type: 'int' },
                    { name: 'Start', type: 'date', cellsformat: 'MM/dd/yyyy HH:mm' },
                    { name: 'Status', type: 'string' },
                    { name: 'Campaign', type: 'string' },
                    { name: 'Queued', type:'int'},
                    { name: 'CampaignID', type: 'int' },
                    { name: 'CampaignName', type: 'string' },
                    { name: 'Processed' ,type:'int'},
                    { name: 'Delivered', type: 'int' },
                    { name: 'Bounced', type: 'int' },
                    { name: 'Open', type: 'int' },
                    { name: 'Clicks', type: 'int' }, ],
                    url: url
                  
                };
               // grid source to speed up load time using local data
             
               
				//data adapter
                	 var dataAdapter = new $.jqx.dataAdapter(source,
					{
						autoBind: true,
						async: false,
						downloadComplete: function () { },
						loadComplete: function () { },
						loadError: function () { }
					});
					
                	  var settings = {
                              title: "Delivered Campaigns Stats",
                              showLegend: true,
                              padding: { left: 5, top: 5, right: 5, bottom: 5 },
                              titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                              source:dataAdapter,
                              categoryAxis:
                                  {
                                      dataField: 'MessageID',
                                      showGridLines: true,

                                  },
                              colorScheme: 'scheme10',
                              seriesGroups:
                                  [
                                      {
                                          type: 'stackedcolumn',
                                         // showLabels: true,
                                          //symbolType:'circle',
                                         columnGapsPercent: 40,
                                          valueAxis:
                                          {
                                              unitInterval: 100000,
                                              minValue: 0,
                                              maxValue: 500000,
                                              displayValueAxis: true,
                                              description: 'Numbers of emails',
                                             //descriptionClass: 'css-class-name',

                                          },
                                          series: [
          										{ dataField: 'Queued', displayText: 'Queued' },
                                                { dataField:'Processed', displayText:'Processed'},
                                                { dataField:'Delivered', displayText: 'Delivered'},
                                                { dataField:'Bounced', displayText: 'Bounced'},
                                                { dataField:'Open', displayText:'Open'},
                                                { dataField:'Clicks', displayText:'Clicks'}
                                            ]
                                      }
                                  ]
                          }; 

                      //setup chart
          					$("#jqxChart").jqxChart(settings);
          					
          					$('#jqxRefreshDataButton1').jqxButton({ width: '150', theme:'blakes_theme'});
          	               // $('#jqxRefreshDataButton1').bind($('#jqxgrid1').jqxGrid());
          	                $('#jqxRefreshDataButton1').on('click', function () {
          	                    //$('#spinner').show();
          	                   // source1.replaceWith(source1clone);
          					    source.url = url;
          	                   dataAdapter.dataBind();
          	                            
          	                  $('#jqxChart').jqxChart({source: dataAdapter});
          	                }); 
       
              // setup the chart
               
               $('#jqxChart').jqxDragDrop();
			   $('#jqxRefreshDataButton1').jqxDragDrop();
                         //buttons
               $("#jqxcalendar").jqxDateTimeInput({ width: '250px', height: '25px', selectionMode: 'range',formatString: 'MM/dd/yyyy HH:mm' });
               $("#jqxDateButton").jqxButton({theme:'blakes_theme'});
               $("#jqxDateButton").on('click',function () {
                      $('#spinner').show();

                       var selection = $('#jqxcalendar').jqxDateTimeInput('getRange');
                       if (selection.from != null) {

                           //alert("HELLO");
                           //gets the dates
                           var fromDate = (selection.from.getMonth()+1)  + '/' + selection.from.getDate() + '/' + selection.from.getFullYear() + ' ' + '00:00:00';
                           var toDate = (selection.from.getMonth()+1)  + '/' + selection.to.getDate() + '/' + selection.to.getFullYear() + ' ' + '23:59:59';
                           var data = { "start_date": fromDate, "end_date": toDate };
                           var url = 'data.php';
                           source.url = url;
                          //injects the to and from date for the request
                           source.data = data;
						  //gets the data for the updates
						  var dataAdapterDate = new $.jqx.dataAdapter(source,{async:false});
						  dataAdapterDate.dataBind();
						 var dataDate= dataAdapterDate.records;
						  var localSourceDate={
	                              datatype: 'json',
	                              datafields:[
	                              { name: 'MessageID', type: 'int' },
	                              { name: 'Start', type: 'date', cellsformat: 'MM/dd/yyyy HH:mm' },
	                              { name: 'Status', type: 'string' },
	                              { name: 'Campaign', type: 'string' },
	                              { name: 'Queued', type:'int'},
	                              { name: 'CampaignID', type: 'int' },
	                              { name: 'CampaignName', type: 'string' },
	                              { name: 'Processed' ,type:'int'},
	                              { name: 'Delivered', type: 'int' },
	                              { name: 'Bounced', type: 'int' },
	                              { name: 'Open', type: 'int' },
	                              { name: 'Clicks', type: 'int' }, ],
	                              localdata:dataDate
	                            
	                          };
						  var localDateAdapter = new $.jqx.dataAdapter(localSourceDate);
                          
                         dataAdapter.dataBind();
                         $('#jqxChart').jqxChart({source:localDateAdapter});
               			}
                    });
                        });
      
        </script>

    <style type="text/css">
        .topcorner {
            position: absolute;
            top: 0;
            right: 0;
        }
    </style>
</head>

<body class = 'default'>
  <div id ='content'>

	    <div id='jqxcalendar' ></div>
        <input type="submit" value="filter" id="jqxDateButton" />
        <input type = 'button' value='Refresh Chart' id='jqxRefreshDataButton1' />
      </div>
      <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left; position: absolute; left: 50%" >
            <div id='jqxChart' style="width:1600; height:800px; position: relative; left:-50%"></div>
	  </div>
           
    <!--<a href="logout.php">Logout</a><br /><br />-->
</body>          
</html>
