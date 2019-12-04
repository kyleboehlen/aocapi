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