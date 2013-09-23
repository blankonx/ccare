<!DOCTYPE html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Client Testimonials Powered by PHP and XML | Tutorialzine Demo</title>

<link rel="stylesheet" type="text/css" href="css/styles.css" />

</head>
<body>

<div id="page">

    <div id="topBar">
        <div id="logo">
        </div>
        
        <ul id="navigation">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Buy Now!</a></li>
        </ul>
    </div>
    
    <div id="iPhone">
        <p>Our new awesome iPhone App is available on the appstore.</p>
    </div>
    
    
    <div id="testimonials">
        <ul>
			<?php
            
                $xmlFile = 'xml/testimonials.xml';
                $xslFile = 'xml/transform.xml';
                
                $doc = new DOMDocument();
                $xsl = new XSLTProcessor();
                
                $doc->load($xslFile);
                $xsl->importStyleSheet($doc);
                
                $doc->load($xmlFile);
                echo $xsl->transformToXML($doc);
            
            ?>
        </ul>
    </div>
    
</div>

<!-- You are free to remove this footer -->

<div id="footer">
	<div class="tri"></div>
	<h1>Client Testimonials Powered by PHP and XML</h1>
	<a class="tzine" href="http://tutorialzine.com/2010/12/client-testimonials-xml-php-jquery/">Read &amp; Download on</a>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
