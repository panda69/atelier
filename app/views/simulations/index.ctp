<?php
	echo "<ul>";
	foreach($penetrations as $penetration)	{
		echo "<li>";
		echo $this->Html->link($penetration, array(
			'controller' => 'Simulations',
			'action' => 'calc',
			substr($penetration, 0, strlen($penetration) - 1)
		));			
		echo "</li>";		
	}
	echo "</ul>";
?>