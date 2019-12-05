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

    if(!$even){
        $diff = $max - $min;
    }

	return $diff;
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