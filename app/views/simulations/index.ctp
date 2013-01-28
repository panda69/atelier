<?php
	echo $this->Form->create("Simulations", array('action' => 'index'));

	foreach($spread as $key => $tc)	{
		$defaultValue = 0;
		if (!empty($this->data))
			$defaultValue = $this->data['Simulations'][$key]; 		
		elseif (intval($key) >= 8 && intval($key) <= 10)
			$defaultValue = 2;
		elseif (intval($key) == 11)
			$defaultValue = 7;
		elseif (intval($key) >= 12)
			$defaultValue = 12;
		 
		echo $this->Form->input($key, 
			array('type' => 'text', 'label' => $tc, 'default' => $defaultValue, 'div' => true, 'class' => 'txtInput'));
	}
	echo $this->Form->end('Calculer');
	
	if (!empty($this->data))	{
		e('<div class="boxCalcResult">');
		e("<p><b>Résultats</b></p>");
		e("<p>---------------------------</p>");
		foreach($results as $key => $value)	{
			if (is_array($value))	{
				e("<p>---------------------------</p>");
				foreach($value as $key2 => $value2)	{
					e("
<p>
For $key2 H(s) : EV = {$value2['EV']} and SD = {$value2['SD']}
<br/>Result : {$value2['RSL']}<br/>
</p>
");
				}
			} else	
				e("<p>$key : $value</p>");
		}
		e("<p>---------------------------</p>");
		e('</div>');
	}
?>