<?php

function showmap($coordenadas,$descricao,$contador)
{

	$endereco = null;
	$key = "AIzaSyBiCdmI_29HqwhZirfPfVYg3oxAA3-lCZQ";
	echo "<script src=\"http://maps.googleapis.com/maps/api/js?key=" . $key . "&sensor=false\" type=\"text/javascript\"></script>";
	?>
 	<div id="map_canvas" style="width: 800px; height: 600px;" align="center"></div>
	<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markermanager/src/markermanager.js"></script>
	<script type="text/javascript">
		var _this = this;
		setTimeout(function() { _this.lerMap() }, 0);
	 	
	 	function lerMap(){

				var myLatlng = new google.maps.LatLng(<?php echo($coordenadas[0][0]);?>,<?php echo($coordenadas[0][1]);?>);
				var myOptions = {
					zoom: 14,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.SATELLITE,
					draggable: true,
					mapTypeControl: false,
					navigationControl : true
				}
				var address = <?php echo "'".$endereco."'"; ?>;
				map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

				var addr = address+', Coimbra, Portugal';
				var geocoder = new google.maps.Geocoder();
				
				//Inicio TESTE1
				<?php
				
				for($i=0;$i<$contador;$i++)
				{
				
				?>
					var parliament = new google.maps.LatLng(<?php echo $coordenadas[$i][0] ?>,<?php echo $coordenadas[$i][1] ?>);
					var marker;		
					marker = new google.maps.Marker({
					map:map,
					title:  <?php echo "'". $descricao[$i] ."'"?>,
					draggable:false,
					animation: google.maps.Animation.DROP,
					position: parliament
					});
				<?php
				
				}
				
				?>
				
			}
	</script>
<?php

}

function showrotas($origem,$destino)
{
	$org=$origem;
	$dest=$destino;

	$key = "AIzaSyCcTmcKnNurALPqwrhMrjTCNYuiIamMHsM";
	echo "<script src=\"http://maps.googleapis.com/maps/api/js?key=" . $key . "&sensor=false\" type=\"text/javascript\"></script>";
?>
	<div id="map_canvas" style="float:left;width: 550px; height: 600px;"></div>
	<div id="directionsPanel" style="float:right;width: 300px; height: 300px"></div>
	<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markermanager/src/markermanager.js"></script>
	<script type="text/javascript">
	var _this = this;
	setTimeout(function() { _this.initi() }, 0);
	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
	
	function initi() 
	{
	 
	  directionsDisplay = new google.maps.DirectionsRenderer();
	  var coimbra = new google.maps.LatLng(40.22878426188078, -8.41627434999998);
	  var myOptions = {
		zoom:18,
		mapTypeId: google.maps.MapTypeId.SATELLITE,
		center: coimbra,
		draggable: false,
		mapTypeControl: false,
		navigationControl : true
	  }
	  
	  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	  directionsDisplay.setMap(map);
	   directionsDisplay.setPanel(document.getElementById("directionsPanel"));
	  var _this = this;
	   setTimeout(function() { _this.calcroute() }, 0);
	   calcroute();
	 }
	  
	function calcroute(){
	  var start = <?php echo "'".$org."'"?>+', Coimbra, Portugal';
	  var end = <?php echo "'".$dest."'"?>+', Coimbra, Portugal';
	  
	  var request = {
		origin:start,
		destination:end,
		travelMode: google.maps.TravelMode.DRIVING
		  // Note that Javascript allows us to access the constant
		  // using square brackets and a string value as its
		  // "property."
		 // travelMode: google.maps.TravelMode[selectedMode]
	  };
	  
	  directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
		  directionsDisplay.setDirections(result);
		}
	  });
	
	}
 
</script>
<?php
}

function cmp($a, $b) {
    if ((1 * $a['paragem']) == (1 * $b['paragem'])) {            # converte para numero
        return 0;
    }
    return ((1 * $a['paragem']) < (1 * $b['paragem'])) ? -1 : 1; # converte para numero
}


function teste_route($origem,$destino)
{
	$org=$origem;
	$dest=$destino;

	$key = "AIzaSyCcTmcKnNurALPqwrhMrjTCNYuiIamMHsM";
	echo "<script src=\"http://maps.googleapis.com/maps/api/js?key=" . $key . "&sensor=false\" type=\"text/javascript\"></script>";
?>
	<div id="map_canvas" style="float:left;width: 550px; height: 600px;"></div>
	<div id="directionsPanel" style="float:right;width: 300px; height: 300px"></div>

	<script type="text/javascript">
	// Create a directions object and register a map and DIV to hold the 
    // resulting computed directions
	
	
    var map;
	var directionsDisplay;
	var directionsService;
	var stepDisplay;
	var markerArray = [];
	
	function initialize() {
	  // Instantiate a directions service.
	  directionsService = new google.maps.DirectionsService();
	
	  // Create a map and center it on Manhattan.
	  var manhattan = new google.maps.LatLng(40.7711329, -73.9741874);
	  var mapOptions = {
		zoom: 13,
		//mapTypeId: google.maps.MapTypeId.ROADMAP,
		center: manhattan
		mapTypeId: google.maps.MapTypeId.SATELLITE,
				draggable: true,
				mapTypeControl: false,
				navigationControl : true
	  }

	  map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	  // Create a renderer for directions and bind it to the map.
	  var rendererOptions = {
		map: map
	  }
	  directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions)

	  // Instantiate an info window to hold step text.
	  stepDisplay = new google.maps.InfoWindow();
	}

	function calcRoute() {

	  // First, clear out any existing markerArray
	  // from previous calculations.
	  for (i = 0; i < markerArray.length; i++) {
		markerArray[i].setMap(null);
	  }

	  // Retrieve the start and end locations and create
	  // a DirectionsRequest using WALKING directions.
	  var start = document.getElementById("start").value;
	  var end = document.getElementById("end").value;
	  var request = {
		  origin: start,
		  destination: end,
		  travelMode: google.maps.TravelMode.WALKING
	  };

	  // Route the directions and pass the response to a
	  // function to create markers for each step.
	  directionsService.route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK) {
		  var warnings = document.getElementById("warnings_panel");
		  warnings.innerHTML = "" + response.routes[0].warnings + "";
		  directionsDisplay.setDirections(response);
		  showSteps(response);
		}
	  });
	}

	function showSteps(directionResult) {
	  // For each step, place a marker, and add the text to the marker's
	  // info window. Also attach the marker to an array so we
	  // can keep track of it and remove it when calculating new
	  // routes.
	  var myRoute = directionResult.routes[0].legs[0];

	  for (var i = 0; i < myRoute.steps.length; i++) {
		  var marker = new google.maps.Marker({
			position: myRoute.steps[i].start_point,
			map: map
		  });
		  attachInstructionText(marker, myRoute.steps[i].instructions);
		  markerArray[i] = marker;
	  }
	}

	function attachInstructionText(marker, text) {
	  google.maps.event.addListener(marker, 'click', function() {
		stepDisplay.setContent(text);
		stepDisplay.open(map, marker);
	  });
	}
	
    </script>
<?php

}

?>
