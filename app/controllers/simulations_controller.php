<?php

class SimulationsController extends AppController {
	const MAX_UNIT = 16;
	
	private $distris = array(
		1 => array("adv" => "-4.5%", "hands" => 0.0),
		2 => array("adv" => "-4.0%", "hands" => 0.0),
		3 => array("adv" => "-3.5%", "hands" => 1.0),
		4 => array("adv" => "-3.0%", "hands" => 2.0),
		5 => array("adv" => "-2.5%", "hands" => 3.0),
		6 => array("adv" => "-2.0%", "hands" => 4.0),
		7 => array("adv" => "-1.5%", "hands" => 8.0),
		8 => array("adv" => "-1.0%", "hands" => 13.0),
		9 => array("adv" => "-0.5%", "hands" => 34.0),
		10 => array("adv" => "0.0%", "hands" => 13.0),
		11 => array("adv" => "0.5%", "hands" => 8.5),
		12 => array("adv" => "1.0%", "hands" => 4.5),
		13 => array("adv" => "1.5%", "hands" => 3.5),
		14 => array("adv" => "2.0%", "hands" => 2.0),
		15 => array("adv" => "2.5%", "hands" => 2.0),
		16 => array("adv" => "3.0%", "hands" => 1.0),
		17 => array("adv" => "3.5%", "hands" => 0.5),
		18 => array("adv" => "4.0%", "hands" => 0.0),
		19 => array("adv" => "4.5%", "hands" => 0.0),
		20 => array("adv" => "5.0%", "hands" => 0.0),
		21 => array("adv" => "6.0%", "hands" => 0.0),
		22 => array("adv" => "7.0%", "hands" => 0.0),
		23 => array("adv" => "8.0%", "hands" => 0.0)
	);
		
	public $uses = array();
	
	public function index()	{
		$units = array();
		for ($i=0; $i <= self::MAX_UNIT; $i++)	
			$units[$i] = $i;
				
		$spread = array();
		$defaultValues = array();
		foreach($this->distris as $key => $distri)	{
			$adv = $distri["adv"];
			$tc = strval(round(floatval(substr($distri["adv"], 0, strlen($distri["adv"])-1)) * 2.0));
			$spread[$key] = "TC = $tc";
			if ($key <= 10)
				$defaultValues[$key] = 1;
			elseif ($key == 11) 
				$defaultValues[$key] = 2;
			elseif ($key == 12) 
				$defaultValues[$key] = 4;
			elseif ($key == 13) 
				$defaultValues[$key] = 6;
			elseif ($key >= 14) 
				$defaultValues[$key] = 8;
		}
		
		$this->set('spread', $spread);	
		$this->set('units', $units);	
		$this->set('defaultValues', $defaultValues);
		
		if (!empty($this->data))	{
			$tnohp = 0.0; 
			$g = 0.0;
			$tub = 0.0;
			$sdx = 0.0;
			foreach($this->distris as $key => $distri)	{ 
				$bp = floatval($this->data["Simulations"][$key]);
				$nohp = $bp > 0.0 ? floatval($distri["hands"]) : 0.0;
				$tnohp += $nohp;
				$ub = $nohp * $bp;
				$tub += $ub;   
				$adv = floatval(substr($distri["adv"], 0, strlen($distri["adv"])-1)) / 100.0;
				$g += $ub * $adv;
				$sdx += pow($bp, 2) * $nohp;
			}
			 
			$abph = $tub / $tnohp;
			$gph = $g / $tnohp;
			$wr = $gph / $abph;
			$sd = (sqrt($sdx) * 1.1) / sqrt($tnohp); 
						
			$resultPerHours = array();
			foreach(array(1,5,10,100,1000,10000) as $hours)	{
				$tmpEV = round($gph * floatval($hours) * $tnohp, 2);
				$tmpSD = round($sd * sqrt(floatval($hours) * $tnohp), 2);
				$tmpResult = sprintf("Entre %d u et %d u", round($tmpEV - $tmpSD), round($tmpEV + $tmpSD));
				$resultPerHours[$hours] = array(
					'EV' => $tmpEV,
					'SD' => $tmpSD,
					'RSL' => $tmpResult 
				);  		
			}
			
			$results = array(
				'TNOHP' => $tnohp, 
				'ABph' => round($abph,2),
				'GPH' => round($gph,3),
				'WR' => round($wr * 100.0, 2) . '%',
				'ResultsPerHour' => $resultPerHours
			);
			
			$this->set('results', $results);
		}
	}
		
}