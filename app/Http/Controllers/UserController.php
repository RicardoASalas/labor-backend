<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Employee;
use App\Models\Company;


class UserController extends Controller {
	
    public function register(Request $request){
		
    	$body = $request->all();
		
		// var_dump($body);
		
		// dd($input); //con dd interumpimos flujo y vemos que hay en el obj
        // dump($input); //lo mismo que dd pero no interrumpe el flujo
        
		
		
        // $this->validate($request, [
			
        //     'user_name' => 'required|max:255',
        //     'email'  => 'required|email|max:255',
        //     // 'email'  => 'required|email|max:255|unique:users',
        //     'password' => 'required|min:4',
        //     'phone' => 'min:9',
        //     'isEnterprise' => 'required',
        //     'province' => 'required',
		// 	'city' => 'required',
			
		// ]);
		
        try {
			
			
			// Encripto la contraseña
			$body['password'] = bcrypt($body["password"]);
			
			
			// Compruebo si es empleado o empresa
			if ($body['is_company']) {
				
				// Genero un UID
				$body["uid"] = uniqid("c");	
				
				// Creo
				$body = Company::create($body);
				
				return response() -> json ([
					"haSalido" => "bien",
				]);
				
			} else {
				
				// Genero un UID
				$body["uid"] = uniqid("e");	
				
				// Creo
				$body = Employee::create($body);
				
				return response() -> json ([
					"haSalido" => "bien",
				]);
				
			};
			
			
        } catch (Exception $e) {
			
			// return response()->json(['error' => trans('api.something_went_wrong')], 500);
			
			return response()->json([
				'error' => "mal",
				'errorCode' => "user_register_1"
			], 500);
			
        }
	}
	
	
	
	public function login(Request $request) {
		
		$body = $request->all();
		
		$password = $body["password"];
		
		
		// Busco en empleados
		// $user = Employee::where("username", "=", $username) -> get();
		
		// if ( $user -> isEmpty() ) {
		// 	$user = Company::where("uid", "=", $uid) -> get();
		// };
		
		
		// $user = Employee::where("password", $body["password"])
		// ->where("username", "=", $body["username"] )
		// ->orWhere("email", $body["email"] )
		// ->get();
		
		
		
		// Busco
		$user = DB::table('employees')
		-> where('username', '=', $body["username"])
		-> orWhere('email', $body["username"])
		-> get();
		
		
		// Compruebo si encuentra algo
		if ($user -> isEmpty()) {
			
			return response() -> json([
				"errorCode" => "user_login_1",
				"error" => "Wrong username, email or password.",
			]);
			
		} else {
			
			$password = $user[0] -> password;
			
			// Compruebo la contraseña
			if (Hash::check($body["password"], $password)) {
				return response() -> json($user[0]);
			};
			
		};
		
		
	}
	
	
	
	public function getUser($uid) {
		
		$user = Employee::where("uid", "=", $uid) -> get();
		
		if ( $user -> isEmpty() ) {
			$user = Company::where("uid", "=", $uid) -> get();
		};
		
		
		if ( $user -> isEmpty() ) {
			return response() -> json([]);
		} else {
			return response() -> json($user[0]);
		};
		
		
	}
	
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::create($request->all());
        return ['created' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
