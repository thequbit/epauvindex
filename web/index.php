<html>
<head>
</head>
<body>

	<center>
	
		<br><br><h3>United States UV Index Heat Map for <?php echo date("l F j, Y",strtotime(date("Y-m-d"))) ?></h3><br>

		<div id="controls" style="width: 800px; margin: auto;">
		
			<select name="stateselect" id="stateselect">
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select>
		
			<button type="button" id="btndisplay" name="btndisplay">Show Heat Map</button>
			
			<br><br>
		
		</div>

		<div id="heatmapArea" style="width: 800px; height: 600px; margin: auto;"></div>

	</center>

	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="js/heatmap.js"></script>
	<script type="text/javascript" src="js/heatmap-gmaps.js"></script>

	<script type="text/javascript">
	
		$("#btndisplay").click( function() {
			displayheatmap( $('#stateselect').val() );
		});
		
		// standard gmaps initialization
		var myLatlng = new google.maps.LatLng(40.4230, -98.7372);
		
		// define map properties
		var myOptions = {
		  zoom: 4,
		  center: myLatlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP,
		  disableDefaultUI: false,
		  scrollwheel: true,
		  draggable: true,
		  navigationControl: true,
		  mapTypeControl: false,
		  scaleControl: true,
		  disableDoubleClickZoom: false
		};
		
		var mapdiv = document.getElementById('heatmapArea');
		
		// we'll use the heatmapArea 
		var map = new google.maps.Map(mapdiv, myOptions);
		
		// let's create a heatmap-overlay
		// with heatmap config properties
		var heatmap = new HeatmapOverlay(map, {
			"radius":20,
			"visible":true, 
			"opacity":60
		});
		
		var mapready = false;
		
		// now we can set the data
		google.maps.event.addListenerOnce(map, "idle", function(){
			
			mapready = true;
			
		});

		function displayheatmap(state)
		{
			url = "http://mycodespace.net/projects/epauvindex/api/getstate.php?date=<?php echo date("Y-m-d"); ?>&hour=13&state=" + state;
			//alert(url);
			$.getJSON(url, function (response) {
			
				// create our dataset
				var dataset={
					max: 18,
					data: response
				};
			
				//alert("setting heatmap!");
			
				// this is important, because if you set the data set too early, the latlng/pixel projection doesn't work
				heatmap.setDataSet(dataset);
			
			});
		}
		

	</script>
</body>
</html>