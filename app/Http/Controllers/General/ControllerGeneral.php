<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\General\State;
use App\Models\General\City;



class ControllerGeneral extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function getStates(Request $request, $id)
	{
		if ($request->ajax( )){
			$state = State::getStates($id)->pluck('description', 'id');
			return response()->json($state);
		}
	}
	public function getCities(Request $request, $id){
		if ($request->ajax( )){
			$city = City::getCities($id)->pluck('description', 'id');
			return response()->json($city);
		}
	}
}
