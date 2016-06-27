<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function () {
    var map;
    var elevator;
    var myOptions = {
        zoom: 5,
        center: new google.maps.LatLng(0, 0),
        mapTypeId: 'terrain'
    };
    var myDiv = document.getElementById('map_canvas');
    map = new google.maps.Map(myDiv, myOptions);

    var addresses = ['Norway', 'Africa', 'Asia','North America','South America'];

    for (var x = 0; x < addresses.length; x++) {
        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function (data) {
            var p = data.results[0].geometry.location
            var latlng = new google.maps.LatLng(p.lat, p.lng);
            new google.maps.Marker({
                position: latlng,
                map: map
            });

        });
    }

});
</script>
<div id="map_canvas"></div>