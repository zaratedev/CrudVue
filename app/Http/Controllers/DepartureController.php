<?php

namespace App\Http\Controllers;

use App\Departure;
use Illuminate\Http\Request;

class DepartureController extends Controller
{
  public function create(Request $request)
  {
    $departure = new Departure();
    $departure->title = $request->title;
    $departure->save();
  }
}
