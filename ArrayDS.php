<?php
/**
 * Array data structure realated functions and problems
 * @author Bishwanath Jha <bishwanathkj@gmail.com>
 */
class ArrayDS
{
	public function GetMajorityCandidate(array $input) {
		$majIndex = 0;
		$count = 1;
		$length = count($input);
		for ($i=1; $i < $length ; $i++) { 
			if ($input[$majIndex] == $input[$i])
				$count++;
			else
				$count--;

			if ($count == 0) {
				$majIndex = $i;
				$count = 1;
			}
		}

		return $input[$majIndex];
	}

	public function FindOddOccurence(array $input) {
		$result = 0;
		$length = count($input);
		for ($i=0; $i < $length; $i++) { 
			$result = $result ^ $input[$i];
		}

		return $result;
	}

	public function Reverse(array $input) {
		$start = 0;
		$end = count($input) - 1;
		while ($start < $end) {
			$temp = $input[$start];
			$input[$start] = $input[$end];
			$input[$end] = $temp;
			$start++;
			$end--;
		}

		return $input;
	}

	// See http://www.geeksforgeeks.org/array-rotation/
	public function RotateFrom(array $input, $from) {
		$length = count($input);
		for($i=0; $i < $from; $i++) {
			$temp = $input[$i];
			// Move j+1 to j
			for ($j=0; $j < $length-1; $j++) { 
				$input[$j] = $input[$j+1];
			}

			// Now set the left most element into right most
			$input[$j] = $temp;
		}

		return $input;
	}

	// Write a program to print all the LEADERS in the array. An element is leader if it is greater than all the elements to its right side. And the rightmost element is always a leader. For example int the array {16, 17, 4, 3, 5, 2}, leaders are 17, 5 and 2
	public function FindLeaders1($input) {
		$length = count($input);
		for ($i = 0; $i < $length; $i++) {
			for($j = $i+1; $j < $length; $j++) {
				if ($input[$i] <= $input[$j]) {
					break;
				}
			}

			if ($j == $length) {
				echo $input[$i] . ' ';
			}
		}
	}

	public function FindLeaders2($input) {
		$length = count($input);
		$max = $input[$length-1];
		echo $max . ' ';
		for ($i = $length-2; $i >= 0; $i--) {
			if ($max < $input[$i]) {
				$max = $input[$i];
				echo $max . ' ';
			}
		}
	}

	/**
	 * Given an array A[] of n numbers and another number x, determine whether or not there exist two elements in A whose sum is exactly x.
	 */
	public function KeyPairSumIsSame($input, $pairSum) {

		$length = count($input);

		for($i = 0; $i < $length; $i++) {
			for($j = $i+1; $j < $length; $j++) {
				if ($input[$i] + $input[$j] == $pairSum) {
					echo "The pair are $input[$i] and $input[$j]";
					return;
				}
			}
		}

		echo "No such pair found";
	}

	/* Given an array of positive numbers, find the maximum sum of a subsequence with the constraint that no 2 numbers in the sequence should be adjacent in the array. So 3 2 7 10 should return 13 (sum of 3 and 10) or 3 2 5 10 7 should return 15 (sum of 3, 5 and 7). 
	Input -- 3 2 7 10
	Output -- 10+3 = 13
	*/
	public function GetMaxSumWithoutAdjacent($input) {
		$length = count($input);
		$sumEvens = $sumOdds = 0;
		
		for ($i=0 ; $i < $length; $i = $i+2) { 
			$sumEvens += $input[$i];
			isset($input[$i+1]) && $sumOdds += $input[$i+1];
		}

		echo $sumEvens > $sumOdds ? $sumEvens : $sumOdds;
	}

	// Find subarray with given sum | Set 1 (Nonnegative Numbers)
	// Input: arr[] = {1, 4, 20, 3, 10, 5}, sum = 33
	// Ouptut: Sum found between indexes 2 and 4
	public function GetSubarrayOfSum($input, $netSum) {
		$length = count($input);

		$sum = $input[0];
		$start = 0;
		for ($i=1; $i < $length; $i++) { 
			
			while ($sum > $netSum && $start < $length - 1) {
				$sum = $sum - $input[$start];
				$start++;
			}

			if ($sum == $netSum) {
			 	echo "The array key starts from $start till " . ($i -1);
			 	return;
			}

			$sum += $input[$i];			
		}

		echo "No net sum subarray found";
		return;

	}
}

$ADS = new ArrayDS();
// print_r($ADS->GetMajorityCandidate([2,3,3,3,9,9,9]));
// print_r($ADS->FindOddOccurence([1,1,2,2,3,3,4,4,4]));
// print_r($ADS->Reverse([1,2,3,4,5]));
// print_r($ADS->RotateFrom([1,2,3,4,5], 2));
// print_r($ADS->FindLeaders2([16,17,4,3,5,2]));
// $ADS->KeyPairSumIsSame([1,2,3,4,5], 9);
// $ADS->GetMaxSumWithoutAdjacent([1,2,3,4]);
$ADS->GetSubarrayOfSum([1, 4, 20, 3, 10, 5], 33);