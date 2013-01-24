<?php
	echo $this->Form->create("Sim", array('action' => 'index'));

	foreach($spread as $key => $tc)	{
		echo $this->Form->input($key, array('type' => 'text', 'label' => $tc, 'div' => true, 'size' => 3));
	}
	echo $this->Form->end('Calculer');
	
	if (!is_null($this->data['Tools']))	{
		e('<div class="boxCalcResult">');
		e("<p><b>Résultats</b></p>");
		e("<p>Espérance : $ev</p>");
		e("<p>Ecart-type : $sd</p>");
		e("</div>");
	}
?>