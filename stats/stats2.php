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
    <title id='Description'>Revenue Statistics</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="../jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="../jqwidgets/styles/blakes_theme.css" type="text/css" />
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxchart.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxtabs.js"></script>
    <script type="text/javascript" src="../jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdocking.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxsplitter.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.aggregates.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {



        	//creates the docking layout
        	$('#docking').jqxDocking({ orientation: 'horizontal', width: '100%', mode: 'docked', theme: 'blakes_theme',});
        	$('#docking').jqxDocking('hideAllCloseButtons');
            $('#docking').jqxDocking('disableWindowResize', 'window1');
            $('#docking').jqxDocking('disableWindowResize', 'window2');
            $('#docking').jqxDocking('disableWindowResize', 'window3');
            $('#docking').jqxDocking('disableWindowResize', 'window4');

            // prepare data for BMI revenue chart
            var source =
            {
                datatype: "json",
              	type: "POST",
                datafields: [
                    { name: 'system' },
                    { name: 'revenue' },
                ],
                url: 'get_stats.php?mailer=BMI'
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {autoBind: true, async: false, loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error);} });

            // prepare data for 7Above revenue chart
            var source2 =
            {
                datatype: "json",
                type: "POST",
                datafields: [
                    { name: 'system' },
                    { name: 'revenue' },
                ],
                url: 'get_stats.php?mailer=7Above'
            };
            var dataAdapter2 = new $.jqx.dataAdapter(source2, {autoBind: true, async: false, loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error);} });

            //gets the data from the data adpaters and finds the max value and sets an approprate interval
            var BMIData=(dataAdapter.records);
          	var max=0;
          	for(var i=0;i<BMIData.length;i++){
          		if(BMIData[i].revenue>max)
          			max=BMIData[i].revenue;
          	}
          	var SevAbvData=(dataAdapter2.records);
          	for(var i=0;i<SevAbvData.length;i++){
          		if(SevAbvData[i].revenue>max){
          			max=SevAbvData[i].revenue;
          		}
          	}
          	interval=Math.round(max/15);

          	//creates a local data adpaters to speed up load times for the grids which cant take straight json data apparently
          	BMILocalSource ={
				datatype:'json',
				datafields: [
					{ name: 'system' },
					{ name: 'revenue' },
				],
				localdata:BMIData
			};
          	BMILocalDataAdapter = new $.jqx.dataAdapter(BMILocalSource);
          	SevAbvLocalSource ={
   				datatype:'json',
   				datafields: [
   					{ name: 'system' },
   					{ name: 'revenue' },
   				],
   				localdata:SevAbvData
   			};
          	SevAbvLocalDataAdapter = new $.jqx.dataAdapter(SevAbvLocalSource);

            //prepares the BMI chart
            var settings1 = {
                title: "Mailing Stats For BMI",
                description: "total revenue before split",
                showLegend: true,
                enableAnimations: true,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: BMIData,
                categoryAxis:
                    {
                        dataField: 'system',
                        showGridLines: true
                    },
                colorScheme: 'scheme02',
                seriesGroups:
                    [
                        {
                            valueAxis:
                            {
                                unitInterval:interval,
                                maxValue:max,
                                displayValueAxis: true,
                                description: 'Revenue'
                            },
                            type: 'column',
                            columnsGapPercent: 50,
                            click: myChartClickHandler,
                            series: [
                                { dataField: 'revenue', displayText: 'Revenue'},
                            ]
                        },
                    ]
            };

          	//prepares the Seven Above chart
            var settings2 = {
               title: "Mailing Stats For 7Above",
               description: "total revenue before split",
               showLegend: true,
               enableAnimations: true,
               titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
               source: SevAbvData,
               categoryAxis:
                   {
                       dataField: 'system',
                       showGridLines: true
                   },
               colorScheme: 'scheme01',
               seriesGroups:
                   [
                       {
                           type: 'column',
                           columnsGapPercent: 50,
                           valueAxis:
                           {
                           	   unitInterval:interval,
                               maxValue:max,
                               displayValueAxis: true,
                               description: 'Revenue'
                           },
                           click: myChartClickHandler,
                           series: [
                                   { dataField: 'revenue', displayText: 'Revenue'},
                               ]
                       },

                   ]
            };

            function myChartClickHandler(e) {
               	alert("Value $" + e.elementValue);
            };

            //setup the charts
            $('#jqxChart').jqxChart(settings1);
            $('#jqxChart2').jqxChart(settings2);

            /*
            var dataAdapter = new $.jqx.dataAdapter(source, {
                downloadComplete: function (data, status, xhr) { },
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }
            });*/

            //sets up the BMI data chart
            $("#jqxgrid").jqxGrid(
            {
                theme: 'blakes_theme',
                width: 670,
                source: BMILocalDataAdapter,
                autoheight: true,
                showstatusbar: true,
                statusbarheight: 26,
                showaggregates: true,
                altrows: true,
                enabletooltips: true,

                columns: [
                  { text: 'System', datafield: 'system' },
                  { text: 'Revenue', datafield: 'revenue', cellsformat: 'C2', aggregates: ['sum'] },
                ]
            });

            /*
            var SevAbvData = new $.jqx.dataAdapter(source2, {
                downloadComplete: function (data, status, xhr) { },
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }
            });
            */

            //sets up the Seven Above chart
            $("#jqxgrid2").jqxGrid(
            {
                theme: 'blakes_theme',
                width: 670,
                source: SevAbvLocalDataAdapter,
                autoheight: true,
                showstatusbar: true,
                statusbarheight: 26,
                showaggregates: true,
                altrows: true,
                enabletooltips: true,

                columns: [
                  { text: 'System', datafield: 'system', },
                  { text: 'Revenue', datafield: 'revenue', cellsformat: 'C2', aggregates: ['sum'] },
                ]
            });

            //handles the filter date request
            $("#date").jqxDateTimeInput({ width: 250, height: 25, selectionMode: 'range' });
            $("#jqxButton").jqxButton({ width: '50', theme: 'blakes_theme' });
            $("#jqxButton").on('click', function () {
            	$('#spinner').show();
            	var selection = $("#date").jqxDateTimeInput('getRange');
            	if (selection.from != null)
            	{
            		//gets the dates
            		var fromDate=(selection.from.getMonth()+1)+'/'+selection.from.getDate()+'/'+selection.from.getFullYear();
            		var toDate=(selection.to.getMonth()+1)+'/'+selection.to.getDate()+'/'+selection.to.getFullYear();
            		var data = { "start_date": fromDate, "end_date": toDate };

            		//injects the to and from date for the request
            		source.data = data;
                    source2.data = data;

                    //gets the data for the updates
            		var dataAdapterChart = new $.jqx.dataAdapter(source,{async: false});
                    var dataAdapterChart2 = new $.jqx.dataAdapter(source2,{async: false});

                    //processes the requests for the data
                    dataAdapterChart.dataBind();
                    dataAdapterChart2.dataBind();
                    BMIData=dataAdapterChart.records;
                    SevAbvData=dataAdapterChart2.records;

                    //finds the max value and the nessarry interval for the charts
                   	var max=0;
                   	for(var i=0;i<BMIData.length;i++){
                   		if(BMIData[i].revenue>max){
                   			max=BMIData[i].revenue;
                   		}
                   	}
                   	for(var i=0;i<SevAbvData.length;i++){
                   		if(SevAbvData[i].revenue>max){
                   			max=SevAbvData[i].revenue;
                   		}
                   	}
                  	interval=Math.round(max/15);

                  	//creates a local data adpaters to speed up load times for the grids
                  	BMILocalSource ={
           				datatype:'json',
           				datafields: [
           					{ name: 'system' },
           					{ name: 'revenue' },
           				],
           				localdata:BMIData
           			};
                   	BMILocalDataAdapter = new $.jqx.dataAdapter(BMILocalSource);
                   	SevAbvLocalSource ={
           				datatype:'json',
           				datafields: [
           					{ name: 'system' },
           					{ name: 'revenue' },
           				],
           				localdata:SevAbvData
           			};
                   	SevAbvLocalDataAdapter = new $.jqx.dataAdapter(SevAbvLocalSource);

                    //writes the data to the BMI chart
                    $('#jqxChart').jqxChart({ source: BMIData,
                    	seriesGroups:
                        [
                         {
                             type: 'column',
                             columnsGapPercent: 50,
                             valueAxis:
                             {
                             	 unitInterval:interval,
                                 maxValue:max,
                                 displayValueAxis: true,
                                 description: 'Revenue'
                             },
                             click: myChartClickHandler,
                             series: [
                                     { dataField: 'revenue', displayText: 'Revenue'},
                                 ]
                         },

                     ]});
                    $('#jqxChart').jqxChart('refresh');

                    //writes the data to the Seven Above Chart
                    $('#jqxChart2').jqxChart({ source: SevAbvData,
                    	seriesGroups:
                            [
                             {
                                 type: 'column',
                                 columnsGapPercent: 50,
                                 valueAxis:
                                 {
                                 	 unitInterval:interval,
                                     maxValue:max,
                                     displayValueAxis: true,
                                     description: 'Revenue'
                                 },
                                 click: myChartClickHandler,
                                 series: [
                                         { dataField: 'revenue', displayText: 'Revenue'},
                                     ]
                             },

                         ]});
                    $('#jqxChart2').jqxChart('refresh');

                    //writes data to the grids
                    $('#jqxgrid').jqxGrid({ source: BMILocalDataAdapter });
                    $('#jqxgrid2').jqxGrid({ source: SevAbvLocalDataAdapter});
            	}
            });
        });
    </script>
</head>
<body class='default'>
<div id="spinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="spinner.gif" alt="Loading"/>
</div>

<div id='jqxWidget'>
		<table>
		<tr>
		<td>
			<div id='date'></div>
		</td>
		<td>
			<input type="button" value="Filter" id='jqxButton' />
		</td>
		</tr>
		</table>

        <div id="docking">
            <div>
                <div id="window1" style="height: 400px;">
                    <div>
                        BMI Stats
                    </div>
                    <div style="overflow: hidden;">
                        <div style='height: 400px; width: 680px;margin: 0 auto;'>
    						<div id='host' style=" height:400px;">
								<div id='jqxChart' style="width:680px; height:400px; position: relative; left: 0px; top: 0px;"></div>
							</div>
    					</div>
                    </div>
                </div>
                <div id="window2" style="height: 300px;">
                    <div>
                       BMI Stats
                    </div>
                    <div style="overflow: hidden;">
						<div id="jqxgrid" style='margin:auto'></div>
                    </div>
                </div>
            </div>
            <div>
                <div id="window3" style="height: 400px">
                 <div>
                        7Above Stats
                    </div>
                    <div style="overflow: hidden;">
                        <div style='height: 400px; width: 680px;margin: 0 auto;'>
    						<div id='host' style=" height:400px;">
								<div id='jqxChart2' style="width:680px; height:400px; position: relative; left: 0px; top: 0px;"></div>
							</div>
    					</div>
                    </div>

                </div>
                <div id="window4" style="height: 300px;">
                    <div>
                        7Above Stats
                    </div>
                     <div style="overflow: hidden;">
						<div id="jqxgrid2" style='margin:auto'></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
   </body>

</html>