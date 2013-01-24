<?php

class SimController extends AppController {
	const MAX_UNIT = 16;
	
	private $HandsByAdv = array(
		"-4.5%" => 0.0,
		"-4.0%" => 0.0,
		"-3.5%" => 1.0,
		"-3.0%" => 2.0,
		"-2.5%" => 3.0,
		"-2.0%" => 4.0,
		"-1.5%" => 8.0,
		"-1.0%" => 13.0,
		"-0.5%" => 34.0,
		"0.0%" => 13.0,
		"0.5%" => 8.5,
		"1.0%" => 4.5,
		"1.5%" => 3.5,
		"2.0%" => 2.0,
		"2.5%" => 2.0,
		"3.0%" => 1.0,
		"3.5%" => 0.5,
		"4.0%" => 0.0,
		"4.5%" => 0.0,
		"5.0%" => 0.0,					
		"6.0%" => 0.0,
		"7.0%" => 0.0,
		"8.0%" => 0.0			
	);
	
	public $uses = array();
	
	public function index()	{
		$spread = array();
		foreach($this->HandsByAdv as $key => $value)	{
			$tc = strval(round(floatval(substr($key, 0, strlen($key)-1)) * 2.0));
			$spread[$key] = $tc;
		}
		$this->set('spread', $spread);		
	}
	
	public function Calc()	{
		$units = array();
		for ($i=1; $i <= self::MAX_UNIT; $i++)	
			$units[$i] = $i;
			
		//$spread = array_keys($this->init_spread);
		$this->set('spread', $this->spread);
		$this->set('units', $units);
			
		if (!empty($this->data))	{
			$ev = 0.0; $sd = 0.0;
			foreach ($this->distris as $key => $distri)	{
				$ev += $distri[0] * $distri[1] * $units[$this->data['Tools'][$key]] / 100.0;
				$sd += pow($units[$this->data['Tools'][$key]], 2) * $distri[0];  
			}
			$sd = 1.15 * sqrt($sd);
			$this->set('ev', $ev . ' unités (pour une heure)');
			$this->set('sd', $sd . ' unités (pour une heure)');
		} else	{
			$this->set('ev', '');
			$this->set('sd', '');
		}
	}
	
	public function Estimation()	{
		if (!empty($this->data))	{
			$ev = $this->data['Tools']['ev'];
			$ev = $this->data['Tools']['ev'];
			$sd = $this->data['Tools']['sd'];
			$unit = $this->data['Tools']['unit'];
			$hours = $this->data['Tools']['hours'];
			$ev *= $unit * $hours;
			$sd *= $unit * sqrt($hours);
			$min = $ev - $sd;
			$max = $ev + $sd; 
			$result = sprintf("Pour %d heure(s)) : entre %f et %f", $hours, $min, $max);
			$this->set('result', $result);
		} else	{
			$this->set('result', '');
		}
	}
	
	public function EstimationStrategieBase()	{
		if (!empty($this->data))	{
			$advantage = $this->data['Tools']['advantage'];
			$unit = $this->data['Tools']['unit'];
			$hours = $this->data['Tools']['hours'];
						
			$ev = 100.0 * $unit * $hours * ($advantage / 100.0);
			$sd = 11.5 * $unit * sqrt($hours);
			$min = $ev - $sd;
			$max = $ev + $sd; 
			$result = sprintf("Espérance : %f<br/>", $ev);
			$result .= sprintf("Ecart-type : %f<br/>", $sd);
			$result .= sprintf("Pour %d heure(s)) : entre %f et %f", $hours, $min, $max);
			//$result = "\$ev:$ev---\$sd:$sd";
			$this->set('result', $result);
		} else	{
			$this->set('result', '');
		}
	}
	
}