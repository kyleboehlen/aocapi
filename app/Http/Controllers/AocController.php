<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AocController extends Controller
{
    private $rules = [
        'year' => 'required|integer|between:2017,2019',
        'day' =>  'required|integer|between:1,25',
        'part' => 'required|integer|between:1,2', 
        'input' => 'required',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // Set param array
        $this->params = [
            'year' => $request->route('year'),
            'day' => $request->route('day'),
            'part' => $request->route('part'),
        ];

        if($request->has('input'))
        {
            $this->params['input'] = $request->get('input');
        }
    }

    public function index()
    {
        // Verify params
        $validator = Validator::make($this->params, $this->rules);

        if($validator->fails())
        {
            return $this->buildResponse($validator->errors(), 400);
        }

        // Set vars from params array
        foreach($this->params as $key => $value)
        {
            $$key = $value;
        }

        // Find function by year and day
        switch($year)
        {
            case 2017:
                switch($day)
                {
                    case 1:
                        return $this->buildResponse(\inverseCaptcha($input, $part));
                        break;
                    case 2:
                        return $this->buildResponse(\corruptionChecksum($input, $part));
                        break;
                    case 3:
                        return $this->buildResponse(\spiralMemory($input, $part));
                        break;
                    case 5:
                        return $this->buildResponse(\twistyTrampolines($input, $part));
                        break;
                    default:
                        return $this->buildResponse("Day $day is not available for $year", 404);
                        break;
                }
                break;
            case 2018:
                switch($day)
                {
                    case 1:
                        return $this->buildResponse(\chronalCalibration($input, $part));
                        break;
                    default:
                        return $this->buildResponse("Day $day is not available for $year", 404);
                        break;
                }
                break;
            case 2019:
                switch($day)
                {
                    case 1:
                        return $this->buildResponse(\tyrannyRocketEquation($input, $part));
                        break;
                    case 2:
                        return $this->buildResponse(\programAlarm($input, $part));
                        break;
                    case 3:
                        return $this->buildResponse(\crossedWires($input, $part));
                        break;
                    case 4:
                        return $this->buildResponse(\secureContainer($input, $part));
                        break;
                    case 5:
                        return $this->buildResponse(\sunnyWithAChangeOfAstroids($input, $part));
                        break;
                    default:
                        return $this->buildResponse("Day $day is not available for $year", 404);
                        break;
                }
                break;
            default:
                return $this->buildResponse("Year $year is not available", 404);
                break;
        }
    }

    // Function to build response based on output
    private function buildResponse($output, $status = 200)
    {
        // Serialize array responses to json
        if(is_array($output))
        {
            return response()->json($output, $status);
        }
        else
        {
            return response($output, $status);
        }
    }
}
