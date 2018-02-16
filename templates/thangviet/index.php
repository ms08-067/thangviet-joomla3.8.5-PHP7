<?php
$app = JFactory::getApplication(); 
$temp_path = JURI::base() . 'templates/' . $app->getTemplate();
JHtml::_('bootstrap.framework');
ini_set('display_errors', 'on');
ini_set('error_reporting', E_ALL & ~E_NOTICE);
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <jdoc:include type="head" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="robots" content="index, follow">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->

	<link href='http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo $temp_path; ?>/css/1140.css">
	<link rel="stylesheet" href="<?php echo $temp_path; ?>/css/my-style.css">
	<link rel="stylesheet" href="<?php echo $temp_path; ?>/css/template.css">
   <!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
	
</head>
<body>
<?php if ($this->countModules('divAdLeft')) : ?>
<div id="divAdLeft" style="position: absolute; top: 200px; left: 0px;">
	<jdoc:include type="modules" name="divAdLeft" />
</div>
<?php endif; ?>

<?php if ($this->countModules('divAdRight')) : ?>
<div id="divAdRight" style="position: absolute; top: 200px;right: 0px;">
	<jdoc:include type="modules" name="divAdRight" />
</div>
<?php endif; ?>	
<div class="top">
			<div class="container12">
			<div class="column12">
                <div class="banner">
					<a href="./"><img class="logo" src="./images/thangviet/logo.png" alt="CÔNG TY TNHH DỊCH VỤ THĂNG VIỆT" /></a>
				</div>
				<!--<img style="width: 100%;" src="<?php echo $temp_path; ?>/images/banner.png" />-->
				<div class="mainmenu">
					<jdoc:include type="modules" name="menutop" style="none" />
				 </div>
            </div>
			</div>
	</div>
    <div class="container12">
        <div class="row header">
			<div class="column12">
			<?php if ($this->countModules('slideshow')) : ?>
				<jdoc:include type="modules" name="slideshow" style="none" />
			<?php endif; ?>
			</div>
        </div>
		
        <div class="row wrap_content">
			<?php if ($this->countModules('left')) : ?>
				<div class="column3 left"><jdoc:include type="modules" name="left" style="xhtml" /></div>
			<?php endif; ?>
            
            <div class="column6 center">
				<jdoc:include type="message" />
				<jdoc:include type="component" />
			</div>
            <?php if ($this->countModules('right')) : ?>
				<div class="column3 right"><jdoc:include type="modules" name="right" style="xhtml" /></div>
			<?php endif; ?>
			<div class="info_footer">
				<jdoc:include type="modules" name="footer" />
				<p class="joomlavi">Design & Developer at <a target="_blank" href="http://www.mwebs.vn">www.mwebs.vn</a></p>
			</div>
        </div>
	</div>	

<script>
MainContentW = 980;
LeftBannerW = 150;
RightBannerW = 0;
LeftAdjust = 0;
RightAdjust = 0;
TopAdjust = 130;
ShowAdDiv();
window.onresize=ShowAdDiv;
function FloatTopDiv()
{
	startLX = ((jQuery(window).width() -MainContentW)/2)-LeftBannerW-LeftAdjust , startLY = TopAdjust+80;
	startRX = ((jQuery(window).width() -MainContentW)/2)+MainContentW+RightAdjust , startRY = TopAdjust+80;

	var d = document;
	function ml(id)
	{
		var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
		el.sP=function(x,y){this.style.left=x + 'px';this.style.top=y + 'px';};
		el.x = startRX;
		el.y = startRY;
		return el;
	}
	function m2(id)
	{
		var e2=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
		e2.sP=function(x,y){this.style.left=x + 'px';this.style.top=y + 'px';};
		e2.x = startLX;
		e2.y = startLY;
		return e2;
	}
	window.stayTopLeft=function()
	{
		if (document.documentElement && document.documentElement.scrollTop)
			var pY =  document.documentElement.scrollTop;
		else if (document.body)
			var pY =  document.body.scrollTop;
		if (document.body.scrollTop > 30){startLY = 3;startRY = 3;} 
		else {startLY = TopAdjust;startRY = TopAdjust;};
		
		ftlObj.y += (pY+startRY-ftlObj.y)/16;
		
		ftlObj.sP(ftlObj.x, ftlObj.y);
		
		ftlObj2.y += (pY+startLY-ftlObj2.y)/16;
		
		ftlObj2.sP(ftlObj2.x, ftlObj2.y);
		
		setTimeout("stayTopLeft()", 1);
	}
	
	
	ftlObj = ml("divAdRight");
	ftlObj2 = m2("divAdLeft");
	stayTopLeft();

}
function ShowAdDiv()
{
	var objAdDivRight = document.getElementById("divAdRight");
	var objAdDivLeft = document.getElementById("divAdLeft");        
	
	if (document.body.clientWidth <= 980)
	{
		objAdDivRight.style.display = "none";
		objAdDivLeft.style.display = "none";
	}
	else
	{
		
		objAdDivRight.style.display = "block";
		
		objAdDivLeft.style.display = "block";
		
		FloatTopDiv();
	}
}

</script>	
</body>
</html>