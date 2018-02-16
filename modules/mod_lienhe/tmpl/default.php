<?php
/**
 * $Id: default.php 11917 2009-05-29 19:37:05Z ian $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
$lang = JFactory::getLanguage();
$tag = $lang->getTag();
?>
<?php 
  if($tag == 'vi-VN'){
	
	$add = "<div  style='width: 380px; height: 110px;font-family: arial;'><strong>Phòng Khánh tiết, lầu 7, Khách sạn Windsor </strong><br />18 An Dương Vương - Quận 5 - TP.HCM, Việt Nam  <br />Tel: (84.8) 3833 6688<br />Fax: (84.8) 3833 6888<br />E-mail: <a href='mailto:info@oktoberfestvietnam.com'>info@oktoberfestvietnam.com</a><br />Website: <a href='http://www.oktoberfestvietnam.com/'>www.oktoberfestvietnam.com</a></div>";
  }
  else{
	
	$add = "<div  style='width: 380px; height: 110px;font-family: arial;'><strong>Jade Ballroom, 7th floor - Windsor Plaza Hotel </strong><br />18 An Duong Vuong, Dist.5, HCMC, Vietnam <br />Tel: (84.8) 3833 6688<br />Fax: (84.8) 3833 6888<br />E-mail: <a href='mailto:info@oktoberfestvietnam.com'>info@oktoberfestvietnam.com</a><br />Website: <a href='http://www.oktoberfestvietnam.com/'>www.oktoberfestvietnam.com</a></div>";
	
  }	
 // if($mobile == "phone"){$add="";}
?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBafo8dipw1uoD4NvCaupjCeJ2nJzmRdF4&sensor=true"></script>
		
	    <script type="text/javascript">
	    
		  var map;
		  var image = "<?php echo JURI::root(); ?>"+'images/thangviet/lg_map.png';
		  function initialize() {
	        var myLatlng = new google.maps.LatLng(10.7606955,106.67193);
			var myOptions = {
	          	
				center: new google.maps.LatLng(10.7606955,106.67193),
	         
			  zoom: 15,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
			
	        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	      
		  
		  var imgString = "<div class='iglr'>CÔNG TY TNHH DỊCH VỤ BẢO VỆ THĂNG VIỆT<br/>ĐC: 37B, Nguyễn Chí Thanh, P.9, Q.5, TP.HCM<br/>ĐT : 086 2646719 – 0650 3777518 <br/>Fax : 0862646719 – 0650 377751<br/>Website: <a href='http://thangvietsecurity.com' target='_blank'>www.thangvietsecurity.com</a></div>";
		
		var marker = new google.maps.Marker({
			    position: myLatlng,
			    map: map,
				animation: google.maps.Animation.DROP,
			    title:"CÔNG TY TNHH DỊCH VỤ BẢO VỆ THĂNG VIỆT ",
				icon: image
			});
		var contentString = imgString ;
		infowindow0 = new google.maps.InfoWindow({
			content: contentString
		});
		  infowindow0.open(map,marker);
		  
		  
		  }
		  
		  
	    </script>
	<script>
		jQuery(function(){
			jQuery(window).load(function() {
				initialize();
			});
		});
	</script>
<hr />	
<div class="fleft" id="map_canvas"></div> 
<style>
	div#map_canvas .iglr {
		
	}
	div#map_canvas {
		width: 100%; 
		height:366px; 
		float: left;
		border: 2px solid #AAD4DD;
		border-radius: 5px;
		margin-bottom: 40px;
	}
	div#map_canvas {
		color: #000000;
		text-align: left;	
	}		
</style>