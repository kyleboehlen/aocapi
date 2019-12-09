<?php

// 2017-1
function inverseCaptcha($raw_input, $part)
{
    $part_one = ($part == 1);

    // Format input
    $input = '';
    for($i = 0; $i < strlen($raw_input); $i += 1)
    {
        $input .= substr($raw_input, $i, 1) . ',';
    }

    $input = substr($input, 0, (strlen($input) - 1));

    $input_array = explode(",", $input);

    // Calculate output
    $output = 0;
    foreach($input_array as $index => $num)
    {
        if($part_one)
        {
            if($index >= count($input_array) - 1)
            {
                if($num == $input_array[0])
                {
                    $output += $num;
                }
            }
            else
            {
                if($num == $input_array[$index + 1])
                {
                    $output += $num;
                }
            }
        }
        else
        {
            $alt_index = $index + (count($input_array) / 2);

            if($alt_index > count($input_array) - 1)
            {
                $alt_index -= count($input_array);
            }
            if($num == $input_array[$alt_index])
            {
                $output += $num;
            }
        }
    }
    
    return $output;
}

// 2017-2
function corruptionChecksum($input, $part)
{
    $even = ($part == 2);

    $checksum = 0;
    $input = explode(PHP_EOL, $input);
    foreach($input as $line)
    {
        $checksum += minMaxDiff($line, $even);
    }
    
    return $checksum;
}

// 2017-2
function minMaxDiff($line, $even)
{
    // Format line
    $line = trim($line);
    $line = preg_replace('/\s+/', ',', $line);
    $array = explode(",", $line);

    // Set loop vars
    $max = 0;
    $min = 0;
    $first = true;
    foreach($array as $num)
    {
        if($even)
        {
            foreach($array as $num2)
            {
                if($num % $num2 == 0 && $num / $num2 > 1)
                {
                    $diff = $num / $num2;
                }
                elseif($num2 % $num == 0 && $num2 / $num > 1)
                {
                    $diff = $num2 / $num;
                }
            }
        }
        else
        {
            if($first)
            {
                $min = $num;
                $first = false;
            }
            if($num < $min)
            {
                $min = $num;
            }
            if($num > $max)
            {
                $max = $num;
            }
        }
    }

    if(!$even)
    {
        $diff = $max - $min;
    }

	return $diff;
}

// 2017-3
function spiralMemory($input, $part)
{
    // logic for displaying which part
    if($part == 1)
    {
        // finds the biggest value that would be located in the bottom right corner of "grid"
        $width = ceil(sqrt($input));
        if(($width % 2) == 0) $width++;
        
        // finds the biggest value in a """""""row""""""" in a million quotation marks
        $max = $width * $width;
        for($int = 0; $int < 4; $int++)
        {
            if($max - ($width - 1) >= $input)
            {
                $max -= ($width - 1);
            }
        }
        
        // finds the middle value so that you can find the distance from the mid to the input
        $mid = $max - (floor($width / 2));
        
        // distance A is found by getting the absolute value of the middle value subtracted from the input
        $distA = abs($input - $mid);
        // distance B is found by rounding the down half of the width
        $distB = floor($width / 2);
        
        $distance = $distA + $distB;

        return $distance;
    }
    elseif($part == 2) // this might be a little overcomplicated but it simulates the whole process with a two dimensional array
    {
        $sum = 0;
        $x = 0;
        $y = 0;
        $grid[$x][$y] = 1;
        $dir = "R";
        $pos = 0;
        $len = 1;
        $even = 0;
        $partTwo = 0;
        do
        {
            if($dir == "R") $x++; // logic for incrementing in the correct direction
            else if($dir == "L") $x--;
            else if($dir == "U") $y++;
            else if($dir == "D") $y--;

            for($i = $x-1; $i <= $x+1; $i++) // logic that checks every value around the current x, y
            {      
                for($j = $y-1; $j <= $y+1; $j++)
                {
                    if(isset($grid[$i][$j])) 
                    {
                        $sum += $grid[$i][$j];
                    }
                }
            }
            $grid[$x][$y] = $sum;    
            $pos++;
            $partTwo = $sum;
            $sum = 0;
            if($pos >= $len)  // logic for changing direction if necessary
            {
                $even++;
                if(($even % 2) == 0) $len++;
                $pos = 0;
                switch($dir)
                {
                    case "R": $dir = "U";
                        break;
                    case "U": $dir = "L";
                        break;
                    case "L": $dir = "D";
                        break;
                    case "D": $dir = "R";
                        break;
                }
            }
        }while($grid[$x][$y] < $input);
        return $partTwo;
    }
}

// 2017-5
function twistyTrampolines($input, $part)
{
    $steps = 0;
    $current = 0;
    $input = explode(PHP_EOL, $input);

    while(isset($input[$current]))
    {
        $value = $input[$current];
        if($part == 1) // according to past me, all I had to do was this :)
        {
            $input[$current] = $value + 1;
        }
        elseif($part == 2)
        {
            // this is part 2, if you want part 1 take away the ifelse and leave what's in the else statement :)
            if($value >= 3)
            {
                $input[$current] = $value -1;
            }
            else
            {
                $input[$current] = $value + 1;
            }
        }        
        $current += $value;
        $steps++;
    }
    return $steps;
}

function chronalCalibration($input, $part)
{
    // take input and put it into an array
    $array = explode(PHP_EOL, $input);

    // determine whether this is part one or part two
    $part_two = ($part == 2);

    // inital var values
    $frequency = 0;
    $frequencies = array();
    $found_value = false;
    $output = '';

    //loop until correct value is found
    while(!$found_value)
    {
        // loop through input array
        foreach($array as $key => $value)
        {
            // calculate new frequency
            $frequency += intval(trim($value));
            if($part_two && !$found_value)
            {
                /*if part two and the value hasn't been found yet
                check if the current frequency has already occured
                in the past*/
                if(in_array($frequency, $frequencies))
                {
                    // set output to current frequency
                    $output = $frequency;
                    // value has been found, set flag
                    $found_value = true;
                }
            }elseif(!$part_two)
            {
                // if part one just assign the current frequency to the output
                $output = $frequency;
            }
        
            // add current frequency to array of historical frequencies
            array_push($frequencies, $frequency);
        }

        if(!$part_two)
        {
            // if part one, set flag after first input foreach
            $found_value = true;
        }
    }

    return $output;
}

// 2019-1
function tyrannyRocketEquation($input, $part)
{
    $ignore_fuel_mass = ($part == 1);

    $array = explode(PHP_EOL, $input);

    $output = 0;
    foreach($array as $value)
    {
        $output += fuelRequired($value, $ignore_fuel_mass);
    }

    return $output;
}

// 2019-1
function fuelRequired($mass, $ignore_fuel_mass)
{
    $fuel = floor(($mass / 3) - 2);

    if($ignore_fuel_mass)
    {
        return $fuel;
    }

    if($fuel > 0)
    {
        return ($fuel + fuelRequired($fuel, $ignore_fuel_mass));
    }

    return 0;
}

// 2019-2
function programAlarm($input, $part)
{
    $part_one = ($part == 1);

    $array = explode(',', $input);

    if($part_one)
    {
        $array[1] = 12;
        $array[2] = 2;

        return runIntcode($array);
    }

    $noun = 1;

    while(true)
    {
        for($verb = 1; $verb < count($array); $verb++)
        {
            $array[1] = $noun;
            $array[2] = $verb;

            if(runIntcode($array) == 19690720)
            {
                return (100 * $noun + $verb);
            }
        }

        $noun++;
    }
}

// 2019-2
function runIntcode($array, $diag = false, $input = 1)
{
    $mode1 = $mode2 = $mode3 = 0; // Position mode
    $i = 0;

    do
    {
        $str = str_pad($array[$i], 5, '0', STR_PAD_LEFT);

        $op_code = substr($str, 3);
        $mode1 = substr($str, 2, 1);
        $mode2 = substr($str, 1, 1);
        $mode3 = substr($str, 0, 1);

        $op_code = intval($op_code);

        switch($op_code)
        {
            case 1:
                $index = $array[$i + 3];

                switch($mode1)
                {
                    case 1:
                        $val1 = $array[$i + 1];
                        break;
                    default: // Position mode
                        $val1 = $array[$array[$i + 1]];
                        break;
                }

                switch($mode2)
                {
                    case 1:
                        $val2 = $array[$i + 2];
                        break;
                    default: // Position mode
                        $val2 = $array[$array[$i + 2]];
                        break;
                }

                $value = $val1 + $val2;
                changeValue($array, $index, $value);
                $i += 4;
                break;
            case 2:
                $index = $array[$i + 3];

                switch($mode1)
                {
                    case 1:
                        $val1 = $array[$i + 1];
                        break;
                    default: // Position mode
                        $val1 = $array[$array[$i + 1]];
                        break;
                }

                switch($mode2)
                {
                    case 1:
                        $val2 = $array[$i + 2];
                        break;
                    default:
                        $val2 = $array[$array[$i + 2]];
                        break;
                }
                
                $value = $val1 * $val2;
                changeValue($array, $index, $value);
                $i += 4;
                break;
            case 3:
                switch($mode1)
                {
                    case 1:
                        $index = $array[$array[$i + 1]];
                        break;
                    default:
                        $index = $array[$i + 1];
                        break;
                }

                changeValue($array, $index, $input);
                $i += 2;
                break;
            case 4:
                switch($mode1)
                {
                    case 1:
                        $diag_code = $array[$i+1];
                        break;
                    default:
                        $diag_code = $array[$array[$i+1]];
                    break;
                }

                $i += 2;
                break;
            case 5:
                switch($mode1)
                {
                    case 1:
                        $val = $array[$i+1];
                        break;
                    default: // position mode
                        $val = $array[$array[$i+1]];
                        break;
                }

                if($val != 0)
                {
                    switch($mode2)
                    {
                        case 1:
                            $i = $array[$i+2];
                            break;
                        default: // position mode
                            $i = $array[$array[$i+2]];
                            break;
                    }
                }
                else
                {
                    $i += 3;
                }

                break;
            case 6:
                switch($mode1)
                {
                    case 1:
                        $val = $array[$i+1];
                        break;
                    default: // position mode
                        $val = $array[$array[$i+1]];
                        break;
                }

                if($val == 0)
                {
                    switch($mode2)
                    {
                        case 1:
                            $i = $array[$i+2];
                            break;
                        default: // position mode
                            $i = $array[$array[$i+2]];
                            break;
                    }
                }
                else
                {
                    $i += 3;
                }
                break;
            case 7:
                switch($mode1)
                {
                    case 1:
                        $val1 = $array[$i+1];
                        break;
                    default: // position mode
                        $val1 = $array[$array[$i+1]];
                        break;
                }

                switch($mode2)
                {
                    case 1:
                        $val2 = $array[$i+2];
                        break;
                    default: // position mode
                        $val2 = $array[$array[$i+2]];
                        break;
                }

                $index = $array[$i+3];
                changeValue($array, $index, intval(($val1 < $val2)));

                $i += 4;
                break;
            case 8:
                switch($mode1)
                {
                    case 1:
                        $val1 = $array[$i+1];
                        break;
                    default: // position mode
                        $val1 = $array[$array[$i+1]];
                        break;
                }

                switch($mode2)
                {
                    case 1:
                        $val2 = $array[$i+2];
                        break;
                    default: // position mode
                        $val2 = $array[$array[$i+2]];
                        break;
                }

                $index = $array[$i+3];
                changeValue($array, $index, intval(($val1 == $val2)));

                $i += 4;
                break;
            case 99:
                // halt op code
                break 2;
            default:
                return "Op code $op_code not valid, ";
                break;
        }
    }while($op_code != 99);

    if($diag)
    {
        return $diag_code;
    }

    // Return first element
    return $array[0];
}

function changeValue(&$array, $index, $value)
{
    $array[$index] = $value;
}

// 2019-3
function crossedWires($input, $part)
{
    $part_one = ($part == 1);
    $parts = explode(PHP_EOL, $input);

    $first_wire_coordinates = mapWires(explode(',', $parts[0]));
    $second_wire_coordinates = mapWires(explode(',', $parts[1]));

    $intersections = array();

    for($j = 0; $j < count($first_wire_coordinates)-1; $j++)
    {
        for($k = 0; $k < count($second_wire_coordinates)-1; $k++)
        {
            // horizontal means y can't change
            // vertical mean x can't change
            $fc_x1 = $first_wire_coordinates[$j]['x'];
            $fc_x2 = $first_wire_coordinates[$j+1]['x'];
            $fc_y1 = $first_wire_coordinates[$j]['y'];
            $fc_y2 = $first_wire_coordinates[$j+1]['y'];

            $sc_x1 = $second_wire_coordinates[$k]['x'];
            $sc_x2 = $second_wire_coordinates[$k+1]['x'];
            $sc_y1 = $second_wire_coordinates[$k]['y'];
            $sc_y2 = $second_wire_coordinates[$k+1]['y'];

            if($fc_x1 == $fc_x2 && $sc_y1 == $sc_y2)
            {
                $x = $fc_x1;
                $y = $sc_y1;

                $top_x = ($sc_x1 > $sc_x2 ? $sc_x1 : $sc_x2);
                $bottom_x = ($sc_x1 < $sc_x2 ? $sc_x1 : $sc_x2);

                $top_y = ($fc_y1 > $fc_y2 ? $fc_y1 : $fc_y2);
                $bottom_y = ($fc_y1 < $fc_y2 ? $fc_y1 : $fc_y2);

                if(($x >= $bottom_x && $x <= $top_x) && ($y >= $bottom_y && $y <= $top_y))
                {
                    array_push($intersections, [
                        'x' => $x,
                        'y' => $y,
                    ]);
                }
            }
            elseif($sc_x1 == $sc_x2 && $fc_y1 == $fc_y2)
            {
                $x = $sc_x1;
                $y = $fc_y1;

                $top_x = ($fc_x1 > $fc_x2 ? $fc_x1 : $fc_x2);
                $bottom_x = ($fc_x1 < $fc_x2 ? $fc_x1 : $fc_x2);

                $top_y = ($sc_y1 > $sc_y2 ? $sc_y1 : $sc_y2);
                $bottom_y = ($sc_y1 < $sc_y2 ? $sc_y1 : $sc_y2);

                if(($x >= $bottom_x && $x <= $top_x) && ($y >= $bottom_y && $y <= $top_y))
                {
                    array_push($intersections, [
                        'x' => $x,
                        'y' => $y,
                    ]);
                }
            }
        }
    }

    foreach($intersections as $key => $intersection)
    {
        $intersections[$key]['manhattan_distance'] = manhattanDistance($intersection);
        $intersections[$key]['total_latency'] = totalLatency($intersection, $parts);
    }

    if($part_one)
    {
        return lowestManhattanDistance($intersections);
    }
    else
    {
        return lowestTotalLatency($intersections);
    }
}

// 2019-3
function mapWires($paths)
{
    $array = array();

    $x = $y = 0;
    foreach($paths as $path)
    {
        $direction = substr($path, 0, 1);
        $distance = substr($path, 1);
    
        switch($direction)
        {
            case 'R':
                array_push($array, [
                    'x' => $x += $distance,
                    'y' => $y,
                ]);
                break;
            case 'L':
                array_push($array, [
                    'x' => $x -= $distance,
                    'y' => $y,
                ]);
                break;
            case 'U':
                array_push($array, [
                    'x' => $x,
                    'y' => $y += $distance,
                ]);
                break;
            case 'D':
                array_push($array, [
                    'x' => $x,
                    'y' => $y -= $distance,
                ]);
                break;
        }
    }

    return $array;
}

// 2019-3
function manhattanDistance($intersection)
{
    return abs($intersection['x']) + abs($intersection['y']); 
}

// 2019-3
function totalLatency($intersection, $parts)
{
    $steps = 0;

    foreach($parts as $part)
    {
        $x = 0;
        $y = 0;

        $paths = explode(',', $part);
        $array = array();

        foreach($paths as $path)
        {
            $direction = substr($path, 0, 1);
            $distance = substr($path, 1);
    
            for($i = 0; $i < $distance; $i++)
            {
                switch($direction)
                {
                    case 'R':
                        array_push($array, [
                            'x' => ++$x,
                            'y' => $y,
                        ]);
                        break;
                    case 'L':
                        array_push($array, [
                            'x' => --$x,
                            'y' => $y,
                        ]);
                        break;
                    case 'U':
                        array_push($array, [
                            'x' => $x,
                            'y' => ++$y,
                        ]);
                        break;
                    case 'D':
                        array_push($array, [
                            'x' => $x,
                            'y' => --$y,
                        ]);
                        break;
                }
    
                $steps++;
    
                if($x == $intersection['x'] && $y == $intersection['y'])
                {
                    break 2;
                }
            }
        }
    }

    return $steps;
}

// 2019-3
function lowestManhattanDistance($intersections)
{
    $distance = 0;
    $first = true;

    foreach($intersections as $intersection)
    {
        if($first || $intersection['manhattan_distance'] < $distance)
        {
            $distance = $intersection['manhattan_distance'];
            $first = false;
        }
    }

    return $distance;
}

// 2019-3
function lowestTotalLatency($intersections)
{
    $total_latency = 0;
    $first = true;

    foreach($intersections as $intersection)
    {
        if($first || $intersection['total_latency'] < $total_latency)
        {
            $total_latency = $intersection['total_latency'];
            $first = false;
        }
    }

    return $total_latency;
}

// 2019-4
function secureContainer($input, $part)
{
    $part_two = ($part == 2);

    $parts = explode('-', $input);
    $range_start = $parts[0];
    $range_end = $parts[1];

    $count = 0;

    for($i = $range_start; $i <= $range_end; $i++)
    {
        if(validatePassword($i, $part_two))
        {
            $count++;
        }
    }

    return $count;
}

function validatePassword($password, $part_two)
{
    // Password is 6 digits
    if(!strlen($password) == 6)
    {
        return false;
    }

    $chars = str_split($password);

    for($i = 0; $i < count($chars)-1; $i++)
    {
        if($chars[$i] > $chars[$i+1])
        {
            return false;
        }
    }

    return adjacentDigits($chars, $part_two);
}

function adjacentDigits($chars, $part_two)
{
    for($i = 0; $i < count($chars)-1; $i++)
    {
        if($chars[$i] == $chars[$i+1])
        {
            if($part_two)
            {
                // 111123

                if($i == 0)
                {
                    if($chars[$i] != $chars[$i+2])
                    {
                        return true;
                    }
                }
                elseif($i >= 4)
                {   
                    if($chars[$i] != $chars[$i-1])
                    {
                        return true;
                    }
                }
                else
                {
                    if($chars[$i] != $chars[$i+2] && $chars[$i] != $chars[$i-1])
                    {
                        return true;
                    }
                }
            }
            else
            {
                return true;
            }
        }
    }

    return false;
}

// 2019-5
function sunnyWithAChangeOfAstroids($input, $part)
{
    $array = explode(',', $input);

    $diag_id = ($part == 1 ? 1 : 5);

    return runIntcode($array, true, $diag_id);
}