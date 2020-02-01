<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use App\Models\Offer;
use App\Models\Company;

class OfferController extends Controller
{

    public function registerOffer(Request $request, $uid){
		
    	$body = $request -> all();
	
		
        try {
				
               
                // Busco id_company cotajando la uid recibida

                $company = Company::where("uid", "=", $uid) -> get();
               
                $company_id = $company[0]->id;

                // Incorporo el id en el body recibido del front

                $body['company_id'] = $company_id;

                // Creo la oferta de trabajo
                
				$body = Offer::create($body);
				
				
				return response() -> json ([
					"success" => "e",
				]);
				
			} catch(\Illuminate\Database\QueryException $e){
                
                $errorCode = $e->errorInfo[1];
                
                
                if ($errorCode == 1062) {
                    return response()->json([
                        'error' => "Error al crear la oferta de trabajo",
                        'errorCode' => "offer_register_1"
                    ], 404);            
                };
                
                
                return $e->errorInfo;
			
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
        //
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
