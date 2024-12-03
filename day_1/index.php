<?php
//$list = file("example_list.txt");
$list = file("input.txt");
$left = array();
$right = array();
$total_distance = 0;
$total_similarity = 0;
$part_one = 0;
$part_two = 0;
foreach ($list as $line){
    $line = explode("   ", $line);
    $left[] = $line[0];
    $right[] = $line[1];
}
sort($left);
sort($right);
foreach ($left as $index => $left_val){
    $index_distance = abs($left_val - $right[$index]);
    $total_distance = $total_distance + $index_distance;
    print("Index distance: " . $index_distance . "\n");
    print("Total distance: " . $total_distance . "\n");
    print("\n");
}

$part_one = $total_distance;

print("\npart one: " . $part_one . "\n\n");

foreach ($left as $index => $left_val){
    $similarity = $left_val * count(array_keys($right, $left_val));
    $total_similarity = $total_similarity + $similarity;
    print("Index similarity: " . $similarity . "\n");
    print("Total similarity: " . $total_similarity . "\n");
    print("\n");
}

$part_two = $total_similarity;

print("\npart two: " . $part_two . "\n\n");