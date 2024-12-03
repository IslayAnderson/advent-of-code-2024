<?php
//$data = file("example.txt");
$data = file("input.txt");
$parsed = array();
$total_safe = 0;
$total_unsafe = 0;

function report_safety($data): string
{
    $last_value = "";
    $direction = "dsc";
    foreach ($data as $index => $current_value) {
        if (!empty($last_value)) {
            $asc = false;
            $dsc = false;
            if ($index == 1) {
                if ($last_value < $current_value) {
                    $direction = "asc";
                }
            }
            if ($index + 1 < count($data) - 1) {
                $next_value = $data[$index + 1];
                switch ($direction) {
                    case "asc":
                        if ($last_value < $current_value) {
                            if ($current_value - $last_value < 4) {
                                if ($current_value < $next_value) {
                                    if ($next_value - $current_value < 4) {
                                        $asc = true;
                                    }
                                }
                            }
                        }
                        break;
                    default:
                        if ($last_value > $current_value) {
                            if ($last_value - $current_value < 4) {
                                if ($current_value > $next_value) {
                                    if ($current_value - $next_value < 4) {
                                        $dsc = true;
                                    }
                                }
                            }
                        }
                        break;
                }
            } else { //this else is because I originally assumed I could skip the first and last value
                if ($direction == "asc") {
                    if ($last_value < $current_value) {
                        if ($current_value - $last_value < 4) {
                            $asc = true;
                        }
                    }
                } else {
                    if ($last_value > $current_value) {
                        if ($last_value - $current_value < 4) {
                            $dsc = true;
                        }
                    }
                }
            }
            if (!$asc && !$dsc) {
                return "unsafe";
            }
        }
        $last_value = $current_value;
    }
    return "safe";
}


foreach ($data as $index => $line) {
    $line = str_replace("\n", "", $line);
    $data = explode(" ", $line);
    $safety = report_safety($data);
    $parsed[$index]["result"] = $safety;
    $parsed[$index]["data"] = $data;
    if ($safety == "safe") $total_safe++;
    if ($safety == "unsafe") $total_unsafe++;

    print($line . " | " . $safety . "\n");
}

$report = fopen('report.json', 'w');
fwrite($report, json_encode($parsed));
fclose($report);

print("\n=== PART ONE ===\n");
print("Total safe(uncorrected): " . $total_safe . "\n");
print("Total unsafe(uncorrected): " . $total_unsafe . "\n");

