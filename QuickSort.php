<?php

class QuickSort
{
	public function sort(&$array, $start, $end) {
		if ($start < $end) {
			$pivot = $this->partition($array, $start, $end);
			$this->sort($array, 0, $pivot - 1);
			$this->sort($array, $pivot + 1, $end);
		}
	}

	public function partition(&$array, $start, $end) {
		$pivot = $array[$end];
		$p_index = $start;

		for ($i = $start; $i < $end; $i++) { 
			if($array[$i] <= $pivot) {
				$this->swap($array, $i, $p_index);
				$p_index++;
			}
		}

		$this->swap($array, $p_index, $end);

		return $p_index;
	}

	public function swap(&$array, $from, $to) {
		$temp = $array[$from];
		$array[$from] = $array[$to];
		$array[$to] = $temp;
	}
}

$QS = new QuickSort;

$array = [2,3,1,6,8,5];
$QS->sort($array, 0, 5);

echo "<pre>";
print_r($array);