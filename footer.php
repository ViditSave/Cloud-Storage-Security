<?php if (isset($color)) {$footCol=$color; $textColor="white";} else {$footCol="white"; $textColor="black";}
	  if (isset($bgColor)) {$footBCol=$bgColor;} else {$footBCol="none";}
	  if (isset($count)) {$footCount=$count;} else {$footCount=1;}
	  if (isset($text)) {$footText=0;} else {$footText=1;}
?>	  
<footer style="right: 0; bottom: 0; left: 0; width:100%;">
	<div id="Mobile<?php echo $footCount; ?>">
	<svg viewBox="0 0 1440 100" style="background-color:<?php echo $footBCol; ?>">
		<polygon style="fill:<?php echo $footCol; ?>;" points="1440 100, 0 100, 0 100, 72 0, 144 100, 216 0, 288 100, 360 0, 432 100, 504 0, 576 100, 648 0, 720 100, 792 0, 864 100,936 0, 1008 100, 1080 0, 1152 100, 1224 0, 1296 100, 1368 0, 1440 100">
		</polygon>
	</svg>
	</div>
	<div id="Laptop<?php echo $footCount; ?>">
	<svg viewBox="0 0 1440 50" style="background-color:<?php echo $footBCol; ?>">
		<polygon style="fill:<?php echo $footCol; ?>;" points="0 50, 0 50, 50 0, 100 50, 150 0, 200 50, 250 0, 300 50, 350 0, 400 50, 450 0, 500 50, 550 0, 600 50, 650 0, 700 50, 750 0, 800 50, 850 0, 900 50, 950 0, 1000 50, 1050 0, 1100 50, 1150 0, 1200 50, 1250 0, 1300 50, 1350 0, 1400 50, 1440 0, 1440 50">
		</polygon>
	</svg>
	</div>
	<?php 
		if ($footText==1) 
			echo'
				<div style="width:90%; background-color:'.$footCol.'; padding:3% 5%; color:'.$textColor.';">
					<p style="font-size:4vw; margin-top:25px;">Secure Storage</p>
				</div>';
	?>
</footer>
<script>
	if (screen.width < 550 )
		document.getElementById("Laptop<?php echo $footCount; ?>").style.display = "none";
	else 
		document.getElementById("Mobile<?php echo $footCount; ?>").style.display = "none";
</script>
<?php unset($color);
	  unset($bgColor);
	  unset($count);
	  unset($text);
	  unset($textColor);
	  unset($textWidth)?>