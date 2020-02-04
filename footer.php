<?php if (isset($color)) {$footCol=$color; $textColor="white";} else {$footCol="white"; $textColor="black";}
	  if (isset($bgColor)) {$footBCol=$bgColor;} else {$footBCol="none";}
	  if (isset($count)) {$footCount=$count;} else {$footCount=1;}
	  if (isset($text)) {$footText=0;} else {$footText=1;}
?>	  

<footer style="right: 0; bottom: 0; left: 0; width:100%;">
	<?php echo '
	<svg viewBox="0 0 1366 35" style="background-color:'.$footBCol.'">		
		<polygon style="fill:'.$footCol.'" points="';
			$width=1366/30;
			for ($i=0;$i<=30;$i++)
			{	if ($i==30)
					echo strval($i*$width)." 35";		  
				else if ($i%2==0)
					echo strval($i*$width)." 35,";
				else
					echo strval($i*$width)." 0,";
			}
			echo '">
		</polygon>
		?>
	</svg>';
	if ($footText==1) 
		echo'
			<div style="width:90%; background-color:'.$footCol.'; padding:3% 5%; color:'.$textColor.';">
				<p style="font-size:4vw; margin-top:25px;">Secure Storage</p>
			</div>';
	?>
</footer>

<?php unset($color);
	  unset($bgColor);
	  unset($count);
	  unset($text);
	  unset($textColor);
	  unset($textWidth)?>