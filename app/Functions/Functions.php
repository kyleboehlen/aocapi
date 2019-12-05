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
function minMaxDiff($line, $even){
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
