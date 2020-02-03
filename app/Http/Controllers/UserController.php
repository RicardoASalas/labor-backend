<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Employee;
use App\Models\Company;
use App\Models\Offer;



class UserController extends Controller {
	
    public function register(Request $request){
		
    	$body = $request -> all();
		
		
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
			
			// var_dump($body);
			
			
			// Encripto la contraseña
			$body['password'] = bcrypt($body["password"]);
			
			
			// Compruebo si es empleado o empresa
			if ($body['is_company']) {
				
				// Genero un UID
				$body["uid"] = uniqid("c");	
				
				// Creo
				// $body = Company::create($body) -> save();
				$body = Company::create($body);
				
				
				return response() -> json ([
					"success" => "c",
				]);
				
			} else {
				
				// Genero un UID
				$body["uid"] = uniqid("e");	
				
				// Creo
				$body = Employee::create($body);
				
				
				return response() -> json ([
					"success" => "e",
				]);
				
			};
			
        } catch(\Illuminate\Database\QueryException $e){
			
			$errorCode = $e->errorInfo[1];
			
			
            if ($errorCode == 1062) {
				return response()->json([
					'error' => "El usuario, el email o el nif/cif ya existen.",
					'errorCode' => "user_register_1"
				], 400);            
			};
			
			
			return $e->errorInfo;
			
		};

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
				
				$response = [
					'name' => $user[0] -> name,
					'username' => $user[0] -> username,
					'uid' => $user[0] -> uid,
					'is_company' => $user[0] -> is_company
				];
				
				// var_dump($response);
				
				return response() -> json($response);
			};
			
		};
		
		
	}
	
	
	
	public function getUser($uid) {
		
		// Busco empleados
		$user = Employee::where("uid", "=", $uid) -> get();
		
		
		// Si no encuentro, busco empresas
		if ( $user -> isEmpty() ) {
			$user = Company::where("uid", "=", $uid) -> get();
		};
		
		
		// Si encuentro algo, lo devuelvo
		if ( $user -> isEmpty() ) {
			return response() -> json([]);
		} else {
			
			
			// Selecciono el primer user
			$user = $user[0];
			
			// Elimino el campo de la contraseña
			unset($user["password"]);
			
			return response() -> json($user);
			
		};
		
		
	}

	public function editUser(Request $request, $uid) {

		$body = $request->all();

		// Busco empleados
		$user = Employee::where("uid", "=", $uid) -> first();
		$user->update($body);
		$user->save();
		return response() -> json ([
			"success" => "e",
		]);
		
		
		// Si no encuentro, busco empresas
		if ( $user -> isEmpty() ) {
			$user = Company::where("uid", "=", $uid) -> first();
			$user->update($body);
			$user->save();
			return response() -> json ([
				"success" => "e",
			]);
		};
		
		
		// Si encuentro algo, lo edito
		if ( $user -> isEmpty() ) {

			return response() -> json([]);
		} else {
			
						
			return response() -> json ($user);
			
		};
		
		
	}

	public function findCompany(Request $request){
		
		$keyword = $request;
		
		var_dump($keyword);
	
		
    //     try {
				
               
    //             // Busco en la tabla ofertas cotejando las columnas con la keyword introducida
    //             var_dump($keyword);

    //             $result = Company::query()
    //             -> where('name', 'LIKE', "%{$keyword}%")
    //             ->orWhere('description', 'LIKE', "%{$keyword}%") 
    //             ->orWhere('sector', 'LIKE', "%{$keyword}%") 
    //             ->orWhere('province', 'LIKE', "%{$keyword}%") 
    //             ->orWhere('city', 'LIKE', "%{$keyword}%")  -> get();
               
    //             var_dump($result);
				
				
	// 			return response() -> json($result);
				
	// 		} catch(\Illuminate\Database\QueryException $e){
                
    //             $errorCode = $e->errorInfo[1];
                
                
    //             if ($errorCode == 1062) {
    //                 return response()->json([
    //                     'error' => "no se encontro ningun resultado",
    //                     'errorCode' => "company_find_1"
    //                 ], 404);            
    //             };
                
                
    //             return $e->errorInfo;
			
	// 	};

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
