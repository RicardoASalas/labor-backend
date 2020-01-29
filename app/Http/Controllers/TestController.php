<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;



class TestController extends Controller
{
    public function test(Request $request){
		
		return response() -> json ([
			"key1" => "value1",
			"key2" => "value2",
			"key3" => "value3",
		]);
		
	}
	
}
