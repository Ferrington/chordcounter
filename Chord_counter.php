<?php

class Chord_counter {
	
	private $chords;
	private $changes;

	public function __construct($input_string) 
	{
		$this->get_chords($input_string);
		$this->calc_percentages();
	}

	public function get_changes() {
		return $this->changes;
	}	

	private function calc_percentages()
	{
		$percentages = array();
		$changes = $this->count_changes();

		$total = array_sum($changes);

		foreach ($changes as $key => $change) {
			$percent = number_format(100 * $change / $total,2);
			$changes[$key] = array("count" => $change, "percentage" => $percent);
		}

		$this->changes = $changes;
	}

	private function get_chords($string)
	{
		$chord_arr = array();

		$lines = preg_split('/\r\n|\n|\r/', $string);

		foreach ($lines as $line) {
			$parts = preg_split('/\s+/', $line);

			$chord_frag = array();
			foreach ($parts as $part) {
				if (!$part) continue;
				if (strlen($part) > 2) {
					$chord_frag = array();
					break;
				}
				if (ord($part[0]) >= 65 and ord($part[0]) <= 71) {
					$chord_frag[] = $part;
				} elseif (strtolower($part[0]) == 'x' and is_numeric($part[1])) {
					$chord_mult = array();
					for ($i = 0; $i < $part[1]; $i++) {
						$chord_mult = array_merge($chord_mult, $chord_frag);
					}
					$chord_frag = $chord_mult;
				} else {
					$chord_frag = array();
					break;
				}
			}
			$chord_arr = array_merge($chord_arr, $chord_frag);
		}

		$this->chords = $chord_arr;
	}

	private function count_changes()
	{
		$changes = array();

		for ($i = 0; $i < (count($this->chords) - 1); $i++) {
			$key = $this->chords[$i]."-".$this->chords[$i+1];
			if (isset($changes[$key])) {
				$changes[$key]++;
			} else {
				$changes[$key] = 1;
			}
		}

		return $changes;
	}

}
