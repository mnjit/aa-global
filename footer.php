

        <div class="section group black_background">
            <div class="col span_1_of_12 ">
                <!-- blank div -->
            </div>
            <div class="col span_2_of_12">
                <p class="white margin-bottom-zero">Legal Information</p>
            </div>


            <div class="col span_1_of_12">
                <!-- blank div -->
            </div>
            <div class="col span_3_of_12 opacity_high" style="opacity:1">
                <p class="white margin-bottom-zero" style="opacity:1">Global C - www.globalcinc.in 2014</p>
            </div>

            <div class="col span_5_of_12 socialmedia_icon">
                <!-- <p class="margin-bottom-zero"> Twitter Facebook Google </p> -->
                
                <p class="footer_social_text" style="color:white">Stay Connected:</p>
                &nbsp;
                
                <img src="images\ff.png" style="height:25px; margin-top:5px">
                <img src="images\twww.png" style="height:25px;">
                <img src="images\gogleplus.png" style="height:25px;">
                <img src="images\pin.png" style="height:25px;">
                
            

                <div>


                </div>
            </div>







        </div>

        



        </body>




    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/responsivegridsystem.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>

 <script type="text/javascript">
            // When the window has finished loading create our google map below
            google.maps.event.addDomListener(window, 'load', init);
        
            function init() {
                // Basic options for a simple Google Map
                // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
                var mapOptions = {
                    // How zoomed in you want the map to start at (always required)
                    zoom: 17,

                    // The latitude and longitude to center the map (always required)
                    center: new google.maps.LatLng(28.524098, 77.04328), // New York
                    zoomControl: false,

                    // How you would like to style the map. 
                    // This is where you would paste any style found on Snazzy Maps.
                    styles: [   {       "featureType":"landscape",      "stylers":[         {               "hue":"#F1FF00"         },          {               "saturation":-27.4          },          {               "lightness":9.4         },          {               "gamma":1           }       ]   },  {       "featureType":"road.highway",       "stylers":[         {               "hue":"#0099FF"         },          {               "saturation":-20            },          {               "lightness":36.4            },          {               "gamma":1           }       ]   },  {       "featureType":"road.arterial",      "stylers":[         {               "hue":"#00FF4F"         },          {               "saturation":0          },          {               "lightness":0           },          {               "gamma":1           }       ]   },  {       "featureType":"road.local",     "stylers":[         {               "hue":"#FFB300"         },          {               "saturation":-38            },          {               "lightness":11.2            },          {               "gamma":1           }       ]   },  {       "featureType":"water",      "stylers":[         {               "hue":"#00B6FF"         },          {               "saturation":4.2            },          {               "lightness":-63.4           },          {               "gamma":1           }       ]   },  {       "featureType":"poi",        "stylers":[         {               "hue":"#9FFF00"         },          {               "saturation":0          },          {               "lightness":0           },          {               "gamma":1           }       ]   }]
                };

                // Get the HTML DOM element that will contain your map 
                // We are using a div with id="map" seen below in the <body>
                var mapElement = document.getElementById('map');
                // Create the Google Map using out element and options defined above
                var map = new google.maps.Map(mapElement, mapOptions);
            }
        </script>


  


    <script src="js/script.js"></script>


    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

    <script>
        (function($){
            $(window).load(function(){

                $("#content-1").mCustomScrollbar({
                    theme:"minimal"
                });
                
            });
        })(jQuery);
    </script>








    </html>