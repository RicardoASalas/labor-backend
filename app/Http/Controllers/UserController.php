<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;



class UserController extends Controller
{
    public function insert(Request $request){

    // $input = $request->all();
    //     // dd($input);//con dd interumpimos flujo y vemos que hay en el obj
    //     // dump($input);//lo mismo que dd pero no interrumpe el flujo
        
    
        $this->validate($request, [
			
            'user_name' => 'required|max:255',
            'email'  => 'required|email|max:255|unique:users',
            'password' => 'required|min:4',
            'phone' => 'min:9',
            'isEnterprise' => 'required',
            'province' => 'required',
			'city' => 'required',
			
		]);
		
        try{

            $user = $request->all();
            
            $user['password'] = bcrypt($request->password);
        
            $user = User::create($user);
    
            return $user;

        } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
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
