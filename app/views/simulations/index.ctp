<?php	
	if (!empty($this->data) && array_key_exists('defaultValues', $this->data['Simulations']) === false)	{
		e('<div class="boxCalcResult">');
		e("<table cols=\"2\" border>");
		e("<caption>Résultats</caption>");
		foreach($results as $key => $value)	{
			if (is_array($value))	{
				foreach($value as $key2 => $value2)	{
					e("
<tr><td rowspan=\"2\">For $key2 Hour(s)</td><td>EV = {$value2['EV']} and SD = {$value2['SD']}</td></tr>
<tr><td>Rsl : {$value2['RSL']}</td></tr>
");
				}
			} else	
				e("<tr><td>$key</td><td>$value</td></tr>");
		}
		e("</table");
		e('</div>');

		echo $this->Form->create("Simulations", array('action' => 'index'));
		print $form->hidden('defaultValues', array('value' => serialize($this->data['Simulations'])));
		echo $this->Form->end('Back to simulation');
	} else	{
		echo $this->Form->create("Simulations", array('action' => 'index'));
	
		foreach($spread as $key => $tc)	{
			echo $this->Form->input($key,
				array(
					'type' => 'select',
					'label' => $tc,
					'options' => $units,
					'selected' => $defaultValues[$key]
				)
			);
		}

		echo $this->Form->end('Calculer');
	}
?>