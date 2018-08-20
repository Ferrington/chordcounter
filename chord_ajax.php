<?php
require 'Chord_counter.php';

if (isset($_POST['input'])) {
	$input = $_POST['input'];
}

$chord_counter = new Chord_counter($input);

$changes = $chord_counter->get_changes();

echo json_encode($changes);
