<!-- javascripts -->
    <script src="<?= Config::get('URL'); ?>/js/jquery.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/jquery-ui-1.10.4.min.js"></script>
    <script src="<?= Config::get('URL'); ?>/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="<?= Config::get('URL'); ?>/js/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="<?= Config::get('URL'); ?>/js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="<?= Config::get('URL'); ?>/js/jquery.scrollTo.min.js"></script>
    <script src="<?= Config::get('URL'); ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->
    <script src="<?= Config::get('URL'); ?>/assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="<?= Config::get('URL'); ?>/js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="<?= Config::get('URL'); ?>/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="<?= Config::get('URL'); ?>/js/owl.carousel.js" ></script>
    <!-- jQuery full calendar -->
    <<script src="<?= Config::get('URL'); ?>/js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
	<script src="<?= Config::get('URL'); ?>/assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="<?= Config::get('URL'); ?>/js/calendar-custom.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="<?= Config::get('URL'); ?>/js/jquery.customSelect.min.js" ></script>
	<script src="<?= Config::get('URL'); ?>/assets/chart-master/Chart.js"></script>
   
    <!--custome script for all page-->
    <script src="<?= Config::get('URL'); ?>/js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="<?= Config::get('URL'); ?>/js/sparkline-chart.js"></script>
    <script src="<?= Config::get('URL'); ?>/js/easy-pie-chart.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/jquery-jvectormap-world-mill-en.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/xcharts.min.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/jquery.autosize.min.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/jquery.placeholder.min.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/gdp-data.js"></script>	
	<script src="<?= Config::get('URL'); ?>/js/morris.min.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/sparklines.js"></script>	
	<script src="<?= Config::get('URL'); ?>/js/charts.js"></script>
	<script src="<?= Config::get('URL'); ?>/js/jquery.slimscroll.min.js"></script>
  <script>

      //knob
      $(function() {
        $(".knob").knob({
          'draw' : function () { 
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
          $("#owl-slider").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
	  
	  /* ---------- Map ---------- */
	$(function(){
	  $('#map').vectorMap({
	    map: 'world_mill_en',
	    series: {
	      regions: [{
	        values: gdpData,
	        scale: ['#000', '#000'],
	        normalizeFunction: 'polynomial'
	      }]
	    },
		backgroundColor: '#eef3f7',
	    onLabelShow: function(e, el, code){
	      el.html(el.html()+' (GDP - '+gdpData[code]+')');
	    }
	  });
	});



  </script>

  </body>
</html>
