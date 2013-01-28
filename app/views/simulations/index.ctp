<?php
	echo $this->Form->create("Simulations", array('action' => 'index'));

	foreach($spread as $key => $tc)	{
		echo $this->Form->input($key,
			array(
				'type' => 'select',
				'label' => $tc,
				'options' => $units,
				'div' => true,
				'selected' => !is_null($this->data['Simulations']) ? $this->data['Simulations'][$key] : $defaultValues[$key]
			)
		);
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