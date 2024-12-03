<?php
//$list = file("example_list.txt");
$list = file("input.txt");
$left = array();
$right = array();
$total_distance = 0;
foreach ($list as $line){
    $line = explode("   ", $line);
    $left[] = $line[0];
    $right[] = $line[1];
}
sort($left);
sort($right);
foreach ($left as $index => $left_val){
    $index_distance = abs($left[$index] - $right[$index]);
    $total_distance = $total_distance + $index_distance;
    print("Index distance: " . $index_distance . "\n");
    print("Total distance: " . $total_distance . "\n");
    print("\n");
}
