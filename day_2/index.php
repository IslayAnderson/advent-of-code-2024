<?php
//$data = file("example.txt");
$data = file("input.txt");
$parsed = array();
$total_safe = 0;
$total_safe_corrected = 0;
$total_unsafe = 0;

function report_safety($data): array
{
    $last_value = "";
    $direction = "dsc";
    $bad_data = array();
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
                $bad_data[] = $index;
            }
        }
        $last_value = $current_value;
    }
    if (count($bad_data) > 0) {
        return array("unsafe", $bad_data);
    } else {
        return array("safe", $bad_data);
    }

}

function report_dampener($data, $indexes)
{
    foreach ($indexes as $index) {
        $new_data = $data;
        array_splice($new_data, $index, 1);
        $safety = report_safety($new_data);
        if ($safety[0] == "safe") return $new_data;
    }
    return false;
}


foreach ($data as $index => $line) {
    $line = str_replace("\n", "", $line);
    $data = explode(" ", $line);
    $safety = report_safety($data);
    $dampened = report_dampener($data, $safety[1]);
    $parsed[$index]["dampened_data"] = $dampened;
    $parsed[$index]["bad_data"] = $safety[1];
    $parsed[$index]["result"] = $safety[0];
    $parsed[$index]["data"] = $data;
    if ($safety[0] == "safe") $total_safe++;
    if (!empty($dampened)) $total_safe_corrected++;
    if ($safety[0] == "unsafe") $total_unsafe++;

//    print($line . " | " . $safety[0] . "\n");
}

$report = fopen('report.json', 'w');
fwrite($report, json_encode($parsed));
fclose($report);

print("\n=== PART ONE ===\n");
print("Total safe(uncorrected): " . $total_safe . "\n");
print("Total unsafe(uncorrected): " . $total_unsafe . "\n");


print("\n=== PART TWO ===\n");
print("Total safe(corrected): " . $total_safe + $total_safe_corrected . "\n");

