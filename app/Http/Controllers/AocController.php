<?php

namespace App\Http\Controllers;

class AocController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index($year, $day, $part)
    {
        return $year . '-' . $day . '-' . $part;
    }
}
