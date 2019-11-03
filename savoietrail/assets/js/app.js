/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import 'bootstrap' ;
// import  initMap  from './initMap' ; 


// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// var map = require('./map');
// var geo = require('./geo');
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

// console.log(initMap());

// $(document).ready(function() {
//     $('[data-toggle="popover"]').popover();
// });

// window.onload = initMap;


 function test() {
    
    var trackpoints = "{{ trails.gpx }}".contentDocument.getElementsByTagName('wpt');
    
    for (trackpoint of trackpoints) {
        console.log(trackpoint.getAttribute('lat'));
        console.log(trackpoint.getAttribute('lon'));
    }    
}

console.log(test);

    


document.addEventListener("DOMContentLoaded", function () {
    "use strict";
   
    var button = document.querySelector("button.geolocation");
    button.addEventListener("click", function () {
        currentLocation();
    });
  });


    let iconGeo = new L.Icon({
       iconUrl: '/images/professional.png',
       shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
       iconSize: [25, 35],
       iconAnchor: [12, 41],
       popupAnchor: [1, -34],
       shadowSize: [41, 41]
     });
   // Geolocation
   function currentLocation() {
       let p = document.getElementById("geolocalisation");
       p.onclick = currentLocation;
         if (navigator.geolocation) {
             navigator.geolocation.getCurrentPosition((function (position) {
                 let marker = L.marker([position.coords.latitude, position.coords.longitude], {
                     icon: iconGeo
    }).addTo(mymap);
                 marker.bindPopup("Ma position :<br> Latitude : " + position.coords.latitude + ',<br>Longitude ' + position.coords.longitude).openPopup();
                 //center: new google.maps.latLng(lat, lng)
             }));
         } else {
             alert("La géolocalisation n'est pas supportée par ce navigateur.");
         }
     }




    //  document.addEventListener("DOMContentLoaded", function () {
    //     "use strict";
       
    //     var button = document.querySelector("button.itinerary");
    //     button.addEventListener("click", function () {
    //         itinerary();
    //     });
    //   });



    
     // itinéraire
// let routeLayer, dir;

// function itinerary() {
// dir = MQ.routing.directions();

// routeLayer = MQ.routing.routeLayer({
// directions: dir,
// fitBounds: true,
// ribbonOptions: {
//   draggable: false,
//   ribbonDisplay: { color: '#5882FA', opacity: 0.7 },
//   widths: [ 10, 15, 10, 15, 10, 13, 10, 12, 10, 11, 10, 11, 10, 12, 10, 14, 10 ]
// },

// altRibbonOptions: {
//   show: true,
//   ribbonDisplay: { color: '#F78181', opacity: 0.7},
//   hoverDisplay: { color: 'red', opacity: 0.6 }
// }
// });

// dir.route({
// maxRoutes: 5,
// timeOverage: 25,
// locations: [
//   'chambery',
//   ' St Alban de Montbel'
// ]
// });

// mymap.addLayer(routeLayer);
// }



     

     