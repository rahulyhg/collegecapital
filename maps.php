<SCRIPT type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" language="javascript">
    function Location(lat, long){
        this.lat = lat;
        this.long = long;
    }
$(document).ready(function(){  
    var locations = new Array();
    locations.push(new Location(-37.995476, 145.215003));
    locations.push(new Location(-37.975476, 145.215003));
    locations.push(new Location(-37.851472, 144.980289));
    
    var mapOptions = {
                        zoom: 10,
                        center: new google.maps.LatLng(-37.800795, 144.946225),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                     }
                    /*var latD = -37.800795;
                    var lngD = 144.946225;                   

                    var location = {lat: latD, lng: lngD};
                    var marker;*/
                    //var map;
                    var mapDiv = document.getElementById('mapDiv');                                  
                    var map = new google.maps.Map(mapDiv, mapOptions);
                    var bounds = new google.maps.LatLngBounds();
                    //map.setCenter(location);
                    //if(marker)
                    //marker.setMap(null);
        for(var x = 0; x < locations.length; ++x)            
        {
                var latlng = new google.maps.LatLng(locations[x].lat, locations[x].long);           
                var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                //icon: 'http://localhost/images/ccb-marker.png',
                draggable: true,                    
                }); 
            }
                }
);
</script>


<div>
    <div id='mapDiv' style="width:100%;height:500px;">
        
    </div>
    
</div>

