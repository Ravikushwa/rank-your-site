jQuery(document).ready(function($) {
    'use strict';


	//  Analytics Daterangpicker Js
	
	var startDate = moment().subtract(8, 'days');
	var endDate = moment();
	const $ndf = `<div class="no-data-wrapper">
					<h2>No Data Available</h2>
					<p>It seems there is no data to display. Please reconnect the GA4 account in the Members Area</p>
				</div>`; 
	
    $(function () {
		function cb(start, end) {
			startDate = start;
			endDate = end;
			$('#dateRangePicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			setTimeout(() => {
				getGaData();
				CountryWiseNewUsers();
				// NewUserActivty();	
				TopCampaignsData();				
				TopCampaignsTrafficData();				
				TopEventsParamData();				
			}, 500)
		}
		if($("#rys_appName").length){
			cb(startDate, endDate);
		}

		$('#dateRangePicker').daterangepicker({
			startDate: startDate,
			endDate: endDate,
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, cb);
	});
        
	var Users = {};
	function UserActivityType(){		
		Users.loCation = $('#rys_Locations').val();		
		Users.appName = $('#rys_appName').val();
		Users.type = $('#rys_Dtype').val();
		Users.propertyId = $('#rys_propertyId').val();
		Users.startDate = startDate.format('MMMM D, YYYY');
		Users.endDate = endDate.format('MMMM D, YYYY');
		
		Users.function = "CountryWiseNewUsers";
		Users.action = 'usersAnalyticsData';	
		Users.chartName = 'countryWise';	
		return Users;		
	}

	// barChart Calling
	function CountryWiseNewUsers() {    
		
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data:  UserActivityType(),
			success: function(data, status) {
				var resp = $.parseJSON(data);						
				var  cArrays =[];  
				var  vArrays =[];  
				if (resp && Array.isArray(resp.rows) && resp.rows.length > 0) {        
					resp.rows.forEach(function (rowArray) { 
						rowArray.dimensionValues.forEach(function (dim, Dindex) {  
							if (Dindex == 0) {
								cArrays.push(dim.value); 
							}
						});     
						rowArray.metricValues.forEach(function (mValue, index) {  
							if (index == 0) {
								vArrays.push(mValue.value); 
							}
						});     
					});
		
					// Process arrays for unique values
					var uniqueArray1 = [...new Set(vArrays)];
					var uniqueArray2 = [...new Set(cArrays)];
		
					// Call barChart with unique arrays
					barChart(uniqueArray2, uniqueArray1);  
				} else {					
					$('#chartC').html($ndf);
				}     
				              
			},
			error: function(data) {
			
			}
		});
		return false;
	}

	/* Basic Bar Chart  */
	function barChart(lable, series) {	
		
        var options = {
			  series: [{
			  name: 'User', 
			  data: series
			}],
			chart: {
				height: 450,
				type: 'bar',
				fontFamily: 'Poppins, sans-serif',
				toolbar: {
					show: false
				},
				zoom: {
					enabled: false
				},
			},
			plotOptions: {
				bar: {
					horizontal: true,
				}
			},			
			dataLabels: {
				enabled: false
			},
			xaxis: {
			  categories: lable,
			},
			colors: ["#1a73e8"],	
			resolution: 'provinces',	
			colorAxis: {
				colors: ['#ffeb3b', '#ff5722'], // Different gradient for regions
			},
			backgroundColor: {
				fill: '#ffffff',
				stroke: '#BDBDBD',
				strokeWidth: 0
			},
			tooltip: {
				textStyle: {
					color: '#bf360c',
					fontSize: 12,
				},
				isHtml: true,
				showColorCode: true,
			},
			legend: {
				textStyle: {
					color: '#d84315',
					fontSize: 13,
				},
				numberFormat: 'decimal',
			},
			sizeAxis: {
				minSize: 5,
				maxSize: 20, // Larger bubbles for regional emphasis
			},		
			title: {
				text: 'New Users By',
				align: 'left',
				style: {
					fontSize: '16px',
					fontWeight: 'bold',
					color: '#263238'
				}
			},			
			explorer: {
				actions: ['dragToZoom', 'rightClickToReset'],
				maxZoomOut: 1,
			}	
			};
		$('#chartC').empty();
		setTimeout(function(){var chart = new ApexCharts(document.querySelector("#chartC"), options);chart.render();},100);
	}


	var Param = {};
	function getVal() {
		Param.loCation = $('#rys_Locations').val();		
		Param.appName = $('#rys_appName').val();
		Param.type = $('#rys_Dtype').val();
		Param.propertyId = $('#rys_propertyId').val();
		Param.startDate = startDate.format('MMMM D, YYYY');
		Param.endDate = endDate.format('MMMM D, YYYY');
		Param.action = 'GoogleAnalytics';
		return Param;
	}	

	function getGaData() {
	    $.ajax({
            method: "POST",
            url: ajaxurl,
            data:  getVal(),
            success: function(data, status) {
                var resp = $.parseJSON(data);
				if(resp.status !=0){
					let arrays = [];
					let Locations = '<option value="worldwide">WorldWide</option>';
		
					/********************showGeoChart*********************/
					if (Param.type == 'Visits')
						arrays.push(['Region', 'Sessions', 'Users']);
					else
						arrays.push(['Event', 'Unique', 'Total']);
					
					/********************showGeoChartNew*********************/
					if(resp.barData){
						resp.geoData.forEach(function (rowArray) {
							let dd = [
								rowArray.dimensionValues[0].value, 
								parseInt(rowArray?.metricValues[1]?.value || 0), 
								parseInt(rowArray?.metricValues[0]?.value || 0)
							];
							arrays.push(dd);
							Locations += '<option value="' + rowArray.dimensionValues[0].value + '">' + rowArray.dimensionValues[0].value + '</option>'
						});
						showGeoChartNew(arrays);
						
					}
		
					/********************showBarChart*********************/
					let nArrays = [];
					let rows = resp.geoData || [];
		
					if (Param.type == 'Visits') {
						nArrays.push(['Date', 'Users', 'Sessions']); $('.ap_chartheading').text('Views');
					} else {
						nArrays.push(['Date', 'Total', 'Unique']); $('.ap_chartheading').text('Installs');
					}
					rows.forEach(function (rowArray) {
						let dimData = rowArray?.dimensionValues || [];
						nArrays.push([moment(dimData[2]?.value, "YYYYMMDD").format("MMM DD"), parseInt(rowArray?.metricValues[1]?.value), parseInt(rowArray?.metricValues[0]?.value)]);
					});
					
					showBarChart(nArrays);
					/********************showBarChart*********************/
		
					if (Param.loCation == 'worldwide')
					$('#Locations').html(Locations);
				}
               	
            },
            error: function(data) {
              	if (data.responseJSON && data.responseJSON.message) {
    				alert(data.responseJSON.message);
    			} else {
    			alert('Something went wrong, please try again.');
    			}
            }
        });
        return false;
	}

	/* Basic Line Chart */
	function showGeoChartNew(arrays) {
		google.charts.load('current', {
			'packages': ['geochart'],
			'mapsApiKey': $('#rys_mapsApi').val()
		});
	
		// Customize the options object based on the parameters and add more settings
		let options = {};
		if (Param.loCation === 'worldwide') {
			options = {
				colorAxis: {
					colors: ['#ff537c', '#00796b'], // Gradient from light to dark for better contrast
				},
				backgroundColor: {
					fill: '#ffffff',
					stroke: '#BDBDBD',
					strokeWidth: 0
				}, // Light background color for better visual separation
				datalessRegionColor: '#44b678', // Gray color for regions with no data
				defaultColor: '#e0e3ed', // Default color for countries without data
				tooltip: {
					textStyle: {
						color: '#0C0D0E',
						fontSize: 14,
						fontName: 'Arial',
						bold: true,
					},
					isHtml: true,
					showColorCode: true,
					ignoreBounds: true,
					trigger: 'focus',
					// Custom styles applied directly to the tooltip via CSS
					tooltip: {
						backgroundColor: '#1e88e5', // Background color
						borderColor: '#1565c0', // Border color
						borderWidth: 2, // Border width
						borderRadius: 10, // Rounded corners
						padding: '10px', // Padding inside the tooltip
						boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)', // Shadow effect
					},
				},				
				legend: {
					textStyle: {
						color: '#00796b', // Legend text color
						fontSize: 13,
					},
					numberFormat: 'decimal', // Format numbers in legend
				},
				keepAspectRatio: true, // Maintain aspect ratio
				keepAspectRatio: true,
				enableRegionInteractivity: true,
				resolution: 'countries', // Resolution set to countries for global view
				sizeAxis: {
					minSize: 5,
					maxSize: 15, // Control the size of bubbles in bubble charts
				},				
				explorer: {
					actions: ['dragToZoom', 'rightClickToReset'],
					maxZoomOut: 2, // Allow zooming out for better overview
				}
			};
			// Applying styles directly via CSS
			const tooltipStyles = `
			.google-visualization-tooltip {
				background-color: #ffffff !important;
				border: 2px solid  #222 !important;
				border-radius: 10px !important;
				padding: 10px !important;
				box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
				color: white !important;
				font-size: 14px !important;
				font-family: Arial !important;
				font-weight: bold !important;
			}
			`;

			// Injecting custom CSS styles into the document
			const styleSheet = document.createElement("style");
			styleSheet.type = "text/css";
			styleSheet.innerText = tooltipStyles;
			document.head.appendChild(styleSheet);
		} else {
			let cc = getContryCode(Param.loCation);
			options = {
				region: cc,
				displayMode: 'regions',
				resolution: 'provinces',
				colorAxis: {
					colors: ['#ffeb3b', '#ff5722'], // Different gradient for regions
				},
				backgroundColor: {
					fill: '#ffffff',
					stroke: '#BDBDBD',
					strokeWidth: 0
				},
				datalessRegionColor: '#eeeeee',
				tooltip: {
					textStyle: {
						color: '#bf360c',
						fontSize: 12,
					},
					isHtml: true,
					showColorCode: true,
				},
				legend: {
					textStyle: {
						color: '#d84315',
						fontSize: 13,
					},
					numberFormat: 'decimal',
				},
				resolution: 'provinces', // Resolution set to provinces for detailed view
				sizeAxis: {
					minSize: 5,
					maxSize: 20, // Larger bubbles for regional emphasis
				},				
				explorer: {
					actions: ['dragToZoom', 'rightClickToReset'],
					maxZoomOut: 1,
				}
			};
		}
	
		google.charts.setOnLoadCallback(drawRegionsMap);
	
		function drawRegionsMap() {
			let data = google.visualization.arrayToDataTable(arrays);
			let chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
			chart.draw(data, options);
	
			// Add event listener for region clicks
			google.visualization.events.addListener(chart, 'regionClick', function (event) {
				console.log('Region clicked: ' + event.region);
				// You can add more interactive behavior here, such as displaying details about the region
			});
		}
	}
	
	function showBarChart(arrays) {
		google.charts.load('current', {
			'packages': ['corechart'],
		});
	
		var options = {
			// title: 'Value',
			titleTextStyle: {
				fontSize: 16, // Title font size
				color: '#333333', // Title font color
				bold: true, // Make the title bold
			},
			curveType: 'none',
			legend: {
				position: 'bottom',
				textStyle: {
					fontSize: 16, // Legend font size
					color: '#666666', // Legend font color
				}
			},
			hAxis: {
				title: 'Month',
				titleTextStyle: {
					fontSize: 12, // X-axis title font size
					color: '#444444', // X-axis title font color
					italic: true // Italicize the X-axis title
				},
				textStyle: {
					fontSize: 12, // X-axis labels font size
					color: '#555555', // X-axis labels font color
				},
				gridlines: {
					color: '#f0f0f0', // X-axis gridline color
					count: 5 // Number of gridlines
				},
				baselineColor: '#CCCCCC', // Color of the axis baseline
				minorGridlines: {
					count: 2 // Number of minor gridlines
				},
				slantedText: true, // Slant the text for better readability
				slantedTextAngle: 30 // Angle of slanted text
			},
			vAxis: {
				title: 'Value',
				titleTextStyle: {
					fontSize: 14, // Y-axis title font size
					color: '#444444', // Y-axis title font color
					italic: true // Italicize the Y-axis title
				},
				textStyle: {
					fontSize: 14, // Y-axis labels font size
					color: '#555555', // Y-axis labels font color
				},
				gridlines: {
					color: '#f0f0f0', // Y-axis gridline color
					count: 5 // Number of gridlines
				},
				baselineColor: '#CCCCCC', // Color of the axis baseline
				minorGridlines: {
					count: 2 // Number of minor gridlines
				}
			},
			series: {
				0: {
					color: '#FF7043',
					lineWidth: 2,
					pointSize: 8,
					pointShape: { type: 'triangle', rotation: 180 }, // Custom shape for data points
					visibleInLegend: true,
					dataOpacity: 0.9,
					lineDashStyle: [5, 2], // Custom dashed line style
				},
				1: {
					color: '#29B6F6',
					lineWidth: 2,
					pointSize: 8,
					pointShape: 'star',
					visibleInLegend: true,
					dataOpacity: 0.7,
				}
			},
			animation: {
				startup: true,
				duration: 1200, // Animation duration in milliseconds
				easing: 'inAndOut', // Animation easing style
			},
			backgroundColor: {
				fill: '#ffffff',
				stroke: '#BDBDBD',
				strokeWidth: 0
			},
			tooltip: {
				textStyle: {
					color: '#000000',
					fontSize: 13,
				},
				showColorCode: true,
				isHtml: true,
				trigger: 'both', // Show tooltips on both hover and focus
			},
			crosshair: {
				trigger: 'both', // Show crosshairs on both hover and selection
				orientation: 'vertical', // Orientation of the crosshair
				color: '#333', // Crosshair color
				opacity: 0.7, // Crosshair opacity
			},
			explorer: {
				actions: ['dragToZoom', 'rightClickToReset'], // Enable zoom and reset
				axis: 'horizontal', // Allow horizontal zooming and panning
				keepInBounds: true, // Keep the zoomed chart within bounds
				maxZoomIn: 0.5 // Limit the maximum zoom level
			},
			chartArea: {
				left: 60, // Increase space for the Y-axis labels
				top: 40, // Increase space for the title
				width: '100%', // Width of the chart area
				height: '75%' // Height of the chart area
			},
			annotations: {
				textStyle: {
					fontSize: 14,
					color: '#FF7043',
					auraColor: 'none',
					bold: true,
				},
				alwaysOutside: true,
			},			
			lineDashStyle: [2, 2], // Dashed line style
			gridlineColor: '#e0e0e0', // Color of the major gridlines
		};
	
		google.charts.setOnLoadCallback(drawVisualization);
	
		function drawVisualization() {
			let data = google.visualization.arrayToDataTable(arrays);
			let chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	}
	
	var TCampaigns = {};
	function TopCampaigns(){		
		TCampaigns.dimensions = $('#topcampaign').val();		
		TCampaigns.loCation = $('#rys_Locations').val();		
		TCampaigns.appName = $('#rys_appName').val();
		TCampaigns.type = $('#rys_Dtype').val();
		TCampaigns.propertyId = $('#rys_propertyId').val();
		TCampaigns.startDate = startDate.format('MMMM D, YYYY');
		TCampaigns.endDate = endDate.format('MMMM D, YYYY');
		
		TCampaigns.function = "TopCampaigns";
		TCampaigns.action = 'usersAnalyticsData';	
		TCampaigns.chartName = 'TopCampaigns';	
		return TCampaigns;		
	}
	
	function TopCampaignsData() {    
		$('.komodo-preloader').removeClass('komodo-el-hidden');
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data:  TopCampaigns(),
			success: function(data, status) {
				var resp = $.parseJSON(data);			
				var  cArrays =[];  
				var  vArrays =[];  
            	$('.komodo-preloader').addClass('komodo-el-hidden');
				if (resp && Array.isArray(resp.rows) && resp.rows.length > 0) {
        			resp.rows.forEach(function (rowArray) { 
						rowArray.dimensionValues.forEach(function (dim,Dindex) {  
							if(Dindex==0){
								cArrays.push(dim.value); 
								
							}
						});		
						rowArray.metricValues.forEach(function (mValue,index) {  
							if(index==0){
								vArrays.push(mValue.value); 								
							}
						});		
        			});
    			}			
				 $('.TopCampaignData').empty();
				 cArrays.forEach(function (tcv,inx) {  
					var TC = `<li>
								   <div class="komodo-progress-data">
									   ${tcv} <b>${vArrays[inx]}</b> 
								   </div>
								   <div class="komodo-progressbar">
									   <span style="width: ${vArrays[inx]}%;"></span>
								   </div>
							   </li>`;
					$('.TopCampaignData').append(TC);
					
				});	
				              
			},
			error: function(data) {
			
			}
		});
		return false;
	}

	var PageAndScreenParam = {};
	function PageAndScreen(){		
		PageAndScreenParam.dimensions = $('#topcampaign').val();		
		PageAndScreenParam.loCation = $('#rys_Locations').val();		
		PageAndScreenParam.appName = $('#rys_appName').val();
		PageAndScreenParam.type = $('#rys_Dtype').val();
		PageAndScreenParam.propertyId = $('#rys_propertyId').val();
		PageAndScreenParam.startDate = startDate.format('MMMM D, YYYY');
		PageAndScreenParam.endDate = endDate.format('MMMM D, YYYY');
		
		PageAndScreenParam.function = "PagesAndScreens";
		PageAndScreenParam.action = 'usersAnalyticsData';	
		PageAndScreenParam.chartName = 'PagesAndScreens';	
		return PageAndScreenParam;		
	}

	function TopCampaignsTrafficData() {   		
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data:  PageAndScreen(),
			success: function(data, status) {
				var resp = $.parseJSON(data);			
				var  cArrays =[];  
				var  vArrays =[];  
				if (resp && Array.isArray(resp.rows) && resp.rows.length > 0) {				
        			resp.rows.forEach(function (rowArray) { 
						rowArray.dimensionValues.forEach(function (dim,Dindex) {  
							if(Dindex==0){
								cArrays.push(dim.value); 
								
							}
						});		
						rowArray.metricValues.forEach(function (mValue,index) {  
							if(index==0){
								vArrays.push(mValue.value); 								
							}
						});		
        			});
    			}				
				 $('.PageAndScreen').empty();
				 var id = 1;
				 cArrays.forEach(function (tcv,inx) {  
					// Split the URL by '/'
					var segments = tcv.split('/');
					
					// Get the last segment
					var lastSegment = segments.pop() || segments.pop(); 
					var TC = `<li>
								   <div class="komodo-progress-data">
									  <div  class="komodo-progress-row">
									  	 <span class="page_screen_heading_${inx}">${lastSegment}</span>	
									   	 <span class="page_screen_heading_${id++}">${tcv}</span>
									  </div>
									   <b>${vArrays[inx]}</b>
								   </div>
								   <div class="komodo-progressbar">
									   <span style="width: ${vArrays[inx]}%;"></span>
								   </div>
							   </li>`;
					$('.PageAndScreen').append(TC);
					
				});	
				              
			},
			error: function(data) {
			
			}
		});
		return false;
	}

	var TopEventsParam = {};
	function TopEvents(){		
		TopEventsParam.dimensions = $('#topcampaign').val();		
		TopEventsParam.loCation = $('#rys_Locations').val();		
		TopEventsParam.appName = $('#rys_appName').val();
		TopEventsParam.type = $('#rys_Dtype').val();
		TopEventsParam.propertyId = $('#rys_propertyId').val();
		TopEventsParam.startDate = startDate.format('MMMM D, YYYY');
		TopEventsParam.endDate = endDate.format('MMMM D, YYYY');
		
		TopEventsParam.function = "TopEvents";
		TopEventsParam.action = 'usersAnalyticsData';	
		TopEventsParam.chartName = 'TopEvents';	
		return TopEventsParam;		
	}

	function TopEventsParamData() {   		
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data:  TopEvents(),
			success: function(data, status) {
				var resp = $.parseJSON(data);			
				var  cArrays =[];  
				var  vArrays =[];  
				if (resp && Array.isArray(resp.rows) && resp.rows.length > 0) {						
        			resp.rows.forEach(function (rowArray) { 
						rowArray.dimensionValues.forEach(function (dim,Dindex) {  
							if(Dindex==0){
								cArrays.push(dim.value); 
								
							}
						});		
						rowArray.metricValues.forEach(function (mValue,index) {  
							if(index==0){
								vArrays.push(mValue.value); 								
							}
						});		
        			});
    			}				
				 $('.TopEvents').empty();
				 cArrays.forEach(function (tcv,inx) {  
					
					var TC = `<li>
								   <div class="komodo-progress-data">									 
									   <span>${tcv}</span>
									   <b>${vArrays[inx]}</b>
								   </div>
								   <div class="komodo-progressbar">
									   <span style="width: ${vArrays[inx]}%;"></span>
								   </div>
							   </li>`;
					$('.TopEvents').append(TC);
					
				});	
				              
			},
			error: function(data) {
			
			}
		});
		return false;
	}

	$(document).on('change', '.filter', function () {
		var apexcart = $('#apexcharts-js').attr('src');	
		// Check if the src contains a query string
		var urlParts = apexcart.split('?'); // Split at the '?' character
	
		// The base URL without the query parameters
		var baseUrl = urlParts[0];
	
		// Create a new query string with an updated timestamp to bypass cache
		var newTimestamp = 'ver=' + new Date().getTime();
	
		// If there was already a query string, replace the timestamp, otherwise append the new one
		var newSrc = baseUrl + '?' + newTimestamp;
	
		// Update the src attribute with the new URL
		$('#apexcharts-js').attr('src', newSrc);
		getGaData();
		TopCampaignsData();
		CountryWiseNewUsers();    
	})

	$(document).on('change', '.TopCampaignfilter', function () {	  
		TopCampaignsData();
	})

	function getContryCode(country) {
		let r = '';
     	//console.log(country);
		let cc = countryCode();
		cc.forEach(function (i) {
			if (i[0] == country) {
				// console.log(i[1])
				r = i[1];
			}
		});
		return r;
	}

	function countryCode() {
		return [
			["Afghanistan", "AF"],
			["Åland Islands", "AX"],
			["Albania", "AL"],
			["Algeria", "DZ"],
			["American Samoa", "AS"],
			["Andorra", "AD"],
			["Angola", "AO"],
			["Anguilla", "AI"],
			["Antarctica", "AQ"],
			["Antigua and Barbuda", "AG"],
			["Argentina", "AR"],
			["Armenia", "AM"],
			["Aruba", "AW"],
			["Australia", "AU"],
			["Austria", "AT"],
			["Azerbaijan", "AZ"],
			["Bahamas", "BS"],
			["Bahrain", "BH"],
			["Bangladesh", "BD"],
			["Barbados", "BB"],
			["Belarus", "BY"],
			["Belgium", "BE"],
			["Belize", "BZ"],
			["Benin", "BJ"],
			["Bermuda", "BM"],
			["Bhutan", "BT"],
			["Bolivia", "BO"],
			["Bonaire", "BQ"],
			["Bosnia and Herzegovina", "BA"],
			["Botswana", "BW"],
			["Bouvet Island", "BV"],
			["Brazil", "BR"],
			["British Indian Ocean Territory", "IO"],
			["Brunei Darussalam", "BN"],
			["Bulgaria", "BG"],
			["Burkina Faso", "BF"],
			["Burundi", "BI"],
			["Cabo Verde", "CV"],
			["Cambodia", "KH"],
			["Cameroon", "CM"],
			["Canada", "CA"],
			["Cayman Islands", "KY"],
			["Central African Republic", "CF"],
			["Chad", "TD"],
			["Chile", "CL"],
			["China", "CN"],
			["Christmas Island", "CX"],
			["Cocos (Keeling) Islands", "CC"],
			["Colombia", "CO"],
			["Comoros", "KM"],
			["Congo", "CG"],
			["Congo, The Democratic Republic of the", "CD"],
			["Cook Islands", "CK"],
			["Costa Rica", "CR"],
			["Côte d\"Ivoire", "CI"],
			["Croatia", "HR"],
			["Cuba", "CU"],
			["Curaçao", "CW"],
			["Cyprus", "CY"],
			["Czechia", "CZ"],
			["Denmark", "DK"],
			["Djibouti", "DJ"],
			["Dominica", "DM"],
			["Dominican Republic", "DO"],
			["Ecuador", "EC"],
			["Egypt", "EG"],
			["El Salvador", "SV"],
			["Equatorial Guinea", "GQ"],
			["Eritrea", "ER"],
			["Estonia", "EE"],
			["Ethiopia", "ET"],
			["Falkland Islands [Islas Malvinas]", "FK"],
			["Faroe Islands", "FO"],
			["Fiji", "FJ"],
			["Finland", "FI"],
			["France", "FR"],
			["French Guiana", "GF"],
			["French Polynesia", "PF"],
			["French Southern Territories", "TF"],
			["Gabon", "GA"],
			["Gambia", "GM"],
			["Georgia", "GE"],
			["Germany", "DE"],
			["Ghana", "GH"],
			["Gibraltar", "GI"],
			["Greece", "GR"],
			["Greenland", "GL"],
			["Grenada", "GD"],
			["Guadeloupe", "GP"],
			["Guam", "GU"],
			["Guatemala", "GT"],
			["Guernsey", "GG"],
			["Guinea", "GN"],
			["Guinea-Bissau", "GW"],
			["Guyana", "GY"],
			["Haiti", "HT"],
			["Heard Island and McDonald Islands", "HM"],
			["Holy See", "VA"],
			["Honduras", "HN"],
			["Hong Kong", "HK"],
			["Hungary", "HU"],
			["Iceland", "IS"],
			["India", "IN"],
			["Indonesia", "ID"],
			["Iran", "IR"],
			["Iraq", "IQ"],
			["Ireland", "IE"],
			["Isle of Man", "IM"],
			["Israel", "IL"],
			["Italy", "IT"],
			["Jamaica", "JM"],
			["Japan", "JP"],
			["Jersey", "JE"],
			["Jordan", "JO"],
			["Kazakhstan", "KZ"],
			["Kenya", "KE"],
			["Kiribati", "KI"],
			["South Korea", "KP"],
			["North Korea", "KR"],
			["Kuwait", "KW"],
			["Kyrgyzstan", "KG"],
			["Lao People's Democratic Republic", "LA"],
			["Latvia", "LV"],
			["Lebanon", "LB"],
			["Lesotho", "LS"],
			["Liberia", "LR"],
			["Libya", "LY"],
			["Liechtenstein", "LI"],
			["Lithuania", "LT"],
			["Luxembourg", "LU"],
			["Macao", "MO"],
			["North Macedonia", "MK"],
			["Madagascar", "MG"],
			["Malawi", "MW"],
			["Malaysia", "MY"],
			["Maldives", "MV"],
			["Mali", "ML"],
			["Malta", "MT"],
			["Marshall Islands", "MH"],
			["Martinique", "MQ"],
			["Mauritania", "MR"],
			["Mauritius", "MU"],
			["Mayotte", "YT"],
			["Mexico", "MX"],
			["Micronesia", "FM"],
			["Moldova", "MD"],
			["Monaco", "MC"],
			["Mongolia", "MN"],
			["Montenegro", "ME"],
			["Montserrat", "MS"],
			["Morocco", "MA"],
			["Mozambique", "MZ"],
			["Myanmar", "MM"],
			["Namibia", "NA"],
			["Nauru", "NR"],
			["Nepal", "NP"],
			["Netherlands", "NL"],
			["New Caledonia", "NC"],
			["New Zealand", "NZ"],
			["Nicaragua", "NI"],
			["Niger", "NE"],
			["Nigeria", "NG"],
			["Niue", "NU"],
			["Norfolk Island", "NF"],
			["Northern Mariana Islands", "MP"],
			["Norway", "NO"],
			["Oman", "OM"],
			["Pakistan", "PK"],
			["Palau", "PW"],
			["Palestine", "PS"],
			["Panama", "PA"],
			["Papua New Guinea", "PG"],
			["Paraguay", "PY"],
			["Peru", "PE"],
			["Philippines", "PH"],
			["Pitcairn", "PN"],
			["Poland", "PL"],
			["Portugal", "PT"],
			["Puerto Rico", "PR"],
			["Qatar", "QA"],
			["Réunion", "RE"],
			["Romania", "RO"],
			["Russia", "RU"],
			["Rwanda", "RW"],
			["St. Barthélemy", "BL"],
			["St. Helena", "SH"],
			["St. Kitts and Nevis", "KN"],
			["St. Lucia", "LC"],
			["St. Martin (French part)", "MF"],
			["St. Pierre and Miquelon", "PM"],
			["St. Vincent and the Grenadines", "VC"],
			["Samoa", "WS"],
			["San Marino", "SM"],
			["Sao Tome and Principe", "ST"],
			["Saudi Arabia", "SA"],
			["Senegal", "SN"],
			["Serbia", "RS"],
			["Seychelles", "SC"],
			["Sierra Leone", "SL"],
			["Singapore", "SG"],
			["Sint Maarten (Dutch part)", "SX"],
			["Slovakia", "SK"],
			["Slovenia", "SI"],
			["Solomon Islands", "SB"],
			["Somalia", "SO"],
			["South Africa", "ZA"],
			["South Georgia and the South Sandwich Islands", "GS"],
			["South Sudan", "SS"],
			["Spain", "ES"],
			["Sri Lanka", "LK"],
			["Sudan", "SD"],
			["Suriname", "SR"],
			["Svalbard and Jan Mayen", "SJ"],
			["Swaziland", "SZ"],
			["Sweden", "SE"],
			["Switzerland", "CH"],
			["Syrian Arab Republic", "SY"],
			["Taiwan", "TW"],
			["Tajikistan", "TJ"],
			["Tanzania", "TZ"],
			["Thailand", "TH"],
			["Timor-Leste", "TL"],
			["Togo", "TG"],
			["Tokelau", "TK"],
			["Tonga", "TO"],
			["Trinidad and Tobago", "TT"],
			["Tunisia", "TN"],
			["Turkey", "TR"],
			["Turkmenistan", "TM"],
			["Turks and Caicos Islands", "TC"],
			["Tuvalu", "TV"],
			["Uganda", "UG"],
			["Ukraine", "UA"],
			["United Arab Emirates", "AE"],
			["United Kingdom", "GB"],
			["United States", "US"],
			["United States Minor Outlying Islands", "UM"],
			["Uruguay", "UY"],
			["Uzbekistan", "UZ"],
			["Vanuatu", "VU"],
			["Venezuela", "VE"],
			["Viet Nam", "VN"],
			["British Virgin Islands", "VG"],
			["U.S. Virgin Islands", "VI"],
			["Wallis and Futuna", "WF"],
			["Western Sahara", "EH"],
			["Yemen", "YE"],
			["Zambia", "ZM"],
			["Zimbabwe", "ZW"]
		]
	}
	// getGaData();


	/** Alert Function **/
	function ME_alert_message(msg, msg_status) {
	$('.rys-alert-wrap p').text(msg);
	$('.rys-alert-wrap').addClass(msg_status);

	setTimeout(function() {
		$('.rys-alert-wrap').removeClass(msg_status);
	}, 3500);
	}

});