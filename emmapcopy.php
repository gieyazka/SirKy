
<?php
include_once 'header.php';
include 'locations_model.php';
require_once("connect.php");
session_start();



if ($_SESSION['type'] != 'employee') {
    header("Location: login.php");
    exit;
}
?>

<head>
    <!-- meta data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!--font-family-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- title of site -->
    <title>อุทยานแห่งชาติเขาใหญ่</title>
    <!-- For favicon png -->
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />

    <!--font-awesome.min.css-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!--animate.css-->
    <link rel="stylesheet" href="assets/css/animate.css">

    <!--flaticon.css-->
    <link rel="stylesheet" href="assets/css/flaticon.css">

    <!--bootstrap.min.css-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!--style.css-->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--responsive.css-->
    <link rel="stylesheet" href="assets/css/responsive.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <style>
		img{
			width:100%;
			height: 500px;
			object-fit:cover;
			background-repeat:no-repeat;
			background-size:cover;
		}
		#contain_map{
			position:relative;
			width:75%;
			height:200px;
			margin:auto;
		}
		/* css กำหนดความกว้าง ความสูงของแผนที่ */
		#map_canvas {
			overflow:hidden;
			padding-bottom:56.25%;
			position:relative;
			height:0;
		}
	</style>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <style>
        img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>

</head>

<body id="page-top">

    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
    <section class="top-area">
        <nav class="navbar navbar-expand-lg navbar-dark " id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">Khao Yai</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <!--/button-->
                <div class="collapse navbar-collapse nav-responsive-list" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="em-index.php">home</a>
                        </li>
                        <!--/.nav-item-->
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="emmap.php">Point</a>
                        </li>
                        <!--/.nav-item-->
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="showtable.php">Show User</a>
                        </li>
                        <!--/.nav-item-->
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="logout.php">Logout</a>
                        </li>
                        <!--/.nav-item-->
                    </ul>
                    <!--/ul-->
                </div>
                <!--/.collapse-->
            </div>
            <!--/.container-->
        </nav>
        <!--/nav-->
    </section>
    <!--/.top-area-->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0xTflD2TcRSIu_bQzF1Sa2xLMKPsMZLA">
        // api//
    </script>

    &nbsp;
    </p>
    <div id="map">

        <div id="map_canvas">&nbsp;</div>
    </div>
    <div id="map"></div>

    <script>
        /**
         * Create new map
         */
        var infowindow;
        var map;
        var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var purple_icon = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
        var locations = <?php get_confirmed_locations() ?>;
        GGM=new Object(google.maps);
			directionShow=new  GGM.DirectionsRenderer({draggable:true});
			directionsService = new GGM.DirectionsService();
			geocoder = new GGM.Geocoder();

			navigator.geolocation.getCurrentPosition(function(position){

				var pos = new GGM.LatLng(position.coords.latitude,position.coords.longitude);

				my_Latlng  = new GGM.LatLng(position.coords.latitude,position.coords.longitude);

				initialTo=new GGM.LatLng(14.439424, 101.372485);
				var my_mapTypeId=GGM.MapTypeId.ROADMAP;
				var my_DivObj=$("#map_canvas")[0];

				var myOptions = {
					zoom: 13,
					center: my_Latlng ,
					mapTypeId:my_mapTypeId
				};

				map = new GGM.Map(my_DivObj,myOptions);
				directionShow.setMap(map);
				var infowindow = new GGM.InfoWindow({
					map: map,
					position: my_Latlng,
					content: 'คุณอยู่ที่นี่.'
				});

				var my_Point = infowindow.getPosition();
				map.panTo(my_Point);
				$("#lat_value").val(my_Point.lat());
				$("#lon_value").val(my_Point.lng());
				$("#zoom_value").val(map.getZoom());
				map.setCenter(my_Latlng);
				inputSearch = $("#pac-input")[0];
				map.controls[GGM.ControlPosition.TOP_LEFT].push(inputSearch);
				infowindow = new GGM.InfoWindow();
				my_Marker = new GGM.Marker({
					map: map,
					anchorPoint: new GGM.Point(0, -29)
				});
			});

			navigator.geolocation.watchPosition(function(position){

				var myPosition_lat=position.coords.latitude;
				var myPosition_lon=position.coords.longitude;
				var user = "<?php echo $_SESSION['username']?>";
				var name = "<?php echo $_SESSION['User']?>";
				var pos = new GGM.LatLng(myPosition_lat,myPosition_lon);
				$.post("addhelp.php", {
					lat: myPosition_lat,
					lon: myPosition_lon,
					user: user,
					name: name,
					action: 1
				});

				var pos = new GGM.LatLng(myPosition_lat,myPosition_lon);

				my_Marker.setPosition(pos);

				var my_Point = my_Marker.getPosition();
				$("#lat_value").val(my_Point.lat());
				$("#lon_value").val(my_Point.lng());
				$("#zoom_value").val(map.getZoom());

				map.panTo(pos);
				map.setCenter(pos);
				var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
				var locations = <?php get_confirmed_locations() ?>; /*marker*/
				var i ; var confirmed = 0;
				for (i = 0; i < locations.length; i++) {
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(locations[i][1], locations[i][2]),
						map: map,
						icon :   locations[i][4] === '1' ?  red_icon  : purple_icon,
						html: "<div>\n" +
						"<table class=\"map1\">\n" +
						"<tr>\n" +
						"<td><a>Description:</a></td>\n" +
						"<td><textarea disabled id='manual_description' placeholder='Description'>"+locations[i][3]+"</textarea></td></tr>\n" +
						"</table>\n" +
						"</div>"
					});

					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infowindow = new google.maps.InfoWindow();
							var  confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
							$("#confirmed").prop(confirmed,locations[i][4]);
							$("#id").val(locations[i][0]);
							$("#description").val(locations[i][3]);
							$("#form").show();
							infowindow.setContent(marker.html);
							infowindow.open(map, marker);
						}
					})(marker, i));
				}

				function downloadUrl(url, callback) {
					var request = window.ActiveXObject ?
					new ActiveXObject('Microsoft.XMLHTTP') :
					new XMLHttpRequest;
					request.onreadystatechange = function() {
						if (request.readyState == 4) {
							callback(request.responseText, request.status);
						}
					};
					request.open('GET', url, true);
					request.send(null);
				}
			});
        map = new google.maps.Map(document.getElementById('map'), myOptions);

        /**
         * Global marker object that holds all markers.
         * @type {Object.<string, google.maps.LatLng>}
         */
        var markers = {};

        /**
         * Concatenates given lat and lng with an underscore and returns it.
         * This id will be used as a key of marker to cache the marker in markers object.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {string} Concatenated marker id.
         */
        var getMarkerUniqueId = function(lat, lng) {
            return lat + '_' + lng;
        };

        /**
         * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
         * This function can be useful for getting new coordinates quickly.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {google.maps.LatLng} An instance of google.maps.LatLng object
         */
        var getLatLng = function(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        };

        /**
         * Binds click event to given map and invokes a callback that appends a new marker to clicked location.
         */
        var addMarker = google.maps.event.addListener(map, 'click', function(e) {
            var lat = e.latLng.lat(); // lat of clicked point
            var lng = e.latLng.lng(); // lng of clicked point
            var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
            var marker = new google.maps.Marker({
                position: getLatLng(lat, lng),
                map: map,
                animation: google.maps.Animation.DROP,
                id: 'marker_' + markerId,
                html: "    <div id='info_" + markerId + "'>\n" +
                    "         <table class=\"map1\">\n" +
                    "            <tr>\n" +
                    "                <td><a>Description:</a></td>\n" +
                    "                <td><textarea  id='manual_description' placeholder='Description'></textarea></td></tr>\n" +
                    "            <tr><td></td><td><input type='button' value='Save' onclick='saveData(" + lat + "," + lng + ")'/></td></tr>\n" +
                    "        </table>\n" +
                    "    </div>"
            });
            markers[markerId] = marker; // cache marker in markers object
            bindMarkerEvents(marker); // bind right click event to marker
            bindMarkerinfo(marker); // bind infowindow with click event to marker

        });

        /**
         * Binds  click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerinfo = function(marker) {
            google.maps.event.addListener(marker, "click", function(point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                infowindow = new google.maps.InfoWindow();
                infowindow.setContent(marker.html);
                infowindow.open(map, marker);
                // removeMarker(marker, markerId); // remove it
            });
        };

        /**
         * Binds right click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerEvents = function(marker) {
            google.maps.event.addListener(marker, "rightclick", function(point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                removeMarker(marker, markerId); // remove it
            });
        };

        /**
         * Removes given marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
         * @param {!string} markerId Id of marker.
         */
        var removeMarker = function(marker, markerId) {
            marker.setMap(null); // set markers setMap to null to remove it from map
            delete markers[markerId]; // delete marker instance from markers object
        };
        var a = <?php load_marker() ?>;
        var j;
            for (j = 0; j < a.length; j++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(a[j][1], a[j][2]),
                map: map,
                html: "<div>\n" +
                    "<table class=\"map1\">\n" +
                    "<tr>\n" +
                    "<td><a>รายละเอียด:</a></td>\n" +
                    "<td><textarea disabled id='manual_description' placeholder='Description'>" + locations[j][5] + "</textarea></td></tr>\n" +
                    "  </table>\n" +

                    "</div>"
            
                
            });

            google.maps.event.addListener(marker, 'click', (function(marker, j) {
                return function() {
                    infowindow = new google.maps.InfoWindow();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker,j));
        }
        // var marker, info;
        // $.getJSON("jsondata.php", function(jsonObj) {
        //     $.each(jsonObj, function(i, item) {
        //         marker = new google.maps.Marker({
        //             position: new google.maps.LatLng(item.latitude, item.longitude),
        //             map: map,
        //         });
        //         info = new google.maps.InfoWindow();
        //         google.maps.event.addListener(marker, 'click', (function(marker, i) {
        //             return function() {
        //                 info.setContent(item.name);
        //                 info.open(maps, marker);
        //             }
        //         })(marker, i));
        //     });
        // });


        /**
         * loop through (Mysql) dynamic locations to add markers to map.
         */
        var i;
        var confirmed = 0;
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: locations[i][4] === '1' ? red_icon : purple_icon,
                html: "<div>\n" +
                    "<table class=\"map1\">\n" +
                    "<tr>\n" +
                    "<td><a>รายละเอียด:</a></td>\n" +
                    "<td><textarea disabled id='manual_description' placeholder='Description'>" + locations[i][3] + "</textarea></td></tr>\n" +
                    "  <td><input type='button' value='Delete Point' onclick='delData(" + locations[i][0] + ")'/></td> </table>\n" +

                    "</div>"
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow = new google.maps.InfoWindow();
                    confirmed = locations[i][4] === '1' ? 'checked' : 0;
                    $("#confirmed").prop(confirmed, locations[i][4]);
                    $("#id").val(locations[i][0]);
                    $("#description").val(locations[i][3]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

        /**
         * SAVE save marker from map.
         * @param lat  A latitude of marker.
         * @param lng A longitude of marker.
         */
        function saveData(lat, lng) {
            var description = document.getElementById('manual_description').value;
            var url = 'locations_model.php?add_location&description=' + description + '&lat=' + lat + '&lng=' + lng;
            downloadUrl(url, function(data, responseCode) {
                if (responseCode === 200 && data.length > 1) {
                    var markerId = getMarkerUniqueId(lat, lng); // get marker id by using clicked point's coordinate
                    var manual_marker = markers[markerId]; // find marker
                    manual_marker.setIcon(purple_icon);
                    infowindow.close();
                    infowindow.setContent("<div style=' color: green; font-size: 25px;'> Insert Complete!!</div>");
                    infowindow.open(map, manual_marker);
                    location.reload();
                } else {
                    console.log(responseCode);
                    console.log(data);
                    infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
                }
            });
        }

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    callback(request.responseText, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }

        function delData(id) {
            $.post("delmap.php", {
                id: id
            }, function(data) {

                location.reload();


            });
        }
    </script>

    <script src="assets/js/jquery.js"></script>

    <!-- popper js -->
    <script src="assets/js/popper.min.js"></script>

    <!--bootstrap.min.js-->
    <script src="assets/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!--Custom JS-->
    <script src="assets/js/custom.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>