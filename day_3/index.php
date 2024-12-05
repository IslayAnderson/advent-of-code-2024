<?php
//$data = file_get_contents("example.txt");
$data = file_get_contents("input.txt");
$total = 0;
$total2 = 0;
$regex = '/mul\((\d{1,9}),(\d{1,9})\)/m';
//This regex only works in 8.4, and it still doesn't solve the problem
$regex2 = '/(?<!don\'t\(\).{1,248})(?<=do\(\).{1,248}|^.{1,248})mul\((\d{1,9}),(\d{1,9})\)/mi';
//if PCRE2 wasn't goofy, this would work (edit: it still won't work, but I applaud your enthusiasm)
//$regex2 = '/(?<!don\'t\(\).*)(?<=do\(\).*|^.*)mul\((\d{1,9}),(\d{1,9})\)/mi';
preg_match_all($regex, $data, $matches_p1, PREG_SET_ORDER, 0);
preg_match_all($regex2, $data, $matches_p2, PREG_SET_ORDER, 0);

foreach ($matches_p1 as $match) {
    $total = $total + ($match[1] * $match[2]);
}
foreach ($matches_p2 as $match) {
    $total2 = $total2 + ($match[1] * $match[2]);
}

print("\n=== PART ONE ===\n");
print("Total: " . $total . "\n");


print("\n=== PART TWO ===\n");
print("Total: " . $total2 . "\n");