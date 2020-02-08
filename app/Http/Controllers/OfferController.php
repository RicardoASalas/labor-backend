<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use App\Models\Offer;
use App\Models\Company;
use App\Models\Employee;

class OfferController extends Controller
{

    public function registerOffer(Request $request, $uid){
		
        $body = $request -> all();
        
        // Genero un UID
		$body["uid"] = uniqid("c");	
        
		
        try {
			
			// Busco id_company cotajando la uid recibida
			$company = Company::where("uid", "=", $uid) -> first();
			
			
			// Si no se encuentra la compañía con la uid devuelvo error
			if ( $company == null ) {
				return response() -> json ([
					"error" => "No se ha encontrado ninguna empresa con esa UID.",
					"errorCode" => "offer_registerOffer_1"
				]);
			};
			
			
			// Obtengo la id de la empresa
			$company_id = $company["id"];
			
			// Incorporo la id en el body recibido del front
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

    public function findOffer(Request $request){
		
		
        try {
            
			// if ($keyword == "") {
			// 	return  response()->json(Offer::get());
			// };
			
			// Busco en la tabla ofertas cotejando las columnas con la keyword introducida
			// var_dump($keyword);
            

            // Posibles filtros
            $uid = $request['uid'];
            $keyw = $request['keyword'];
            $prov = $request['province'];
            $city = $request['city'];
            $sort = $request['sort'];
            
			
			
            $result = Offer::query()
            -> when ( $uid, function ($q, $uid) {
                $q -> where("uid", "=", $uid);
            })
            -> when ( $keyw, function ($q, $keyw) {
                $q -> where("title", "LIKE", "%{$keyw}%")
                ->orWhere('description', 'LIKE', "%{$keyw}%")
                ->orWhere('uid', 'LIKE', "%{$keyw}%")
                ->orWhere('company_name', 'LIKE', "%{$keyw}%");
                
            })
            -> when ( $prov, function ($q, $prov) {
                $q -> where("province", "=", $prov);
            })
            -> when ( $city, function ($q, $city) {
                $q -> where("city", "=", $city);
            })
            -> when ( $sort == "new", function ($q, $sort) {
                $q -> orderBy('created_at', 'DESC');
            })
            -> when ( $sort == "old", function ($q, $sort) {
                $q -> orderBy('created_at', 'ASC');
            })   
            -> when ( $sort == "pop", function ($q, $sort) {
                $q -> orderBy('times_applied', 'DESC');
            })   
            -> when ( $sort == "unpop", function ($q, $sort) {
                $q -> orderBy('times_applied', 'ASC');
            })   
            

            -> get();

            foreach ($result as $offer) {
				
				$company_id = $offer->company_id;
				
				// Busco la empresa cotejando la id de la oferta
				$company = Company::where("id", "=", $company_id) -> get();
               
                // Incorporo el nombre de la empresa en el objeto de la oferta
               
                $offer['_companyName'] = $company[0]->name;
                $offer['_companyUid'] = $company[0]->uid;
                $offer['_companyAvatar'] = $company[0]->avatar_url;
				
            };
            
            unset($offer);
            

            return response() -> json($result);
            
            /*
				->where('title', 'LIKE', "%{$keyword}%")
				
				->orWhere('sector', 'LIKE', "%{$keyword}%")
				->orWhere('province', 'LIKE', "%{$keyword}%")
                ->orWhere('city', 'LIKE', "%{$keyword}%")->get();
              */  
                // Recorro el array de ofertas suscritas
				
			} catch(\Illuminate\Database\QueryException $e){
                
                $errorCode = $e->errorInfo[1];
                
                
                if ($errorCode == 1062) {
                    return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "offer_find_1"
                    ], 404);            
                };
                
                
                return $e->errorInfo;
			
		};

    }

    public function applyOffer($offerUid, $userUid){
	
		
        try {
               
                // Busco el employee cotejando la uid recibida

                $user = Employee::where("uid", "=", $userUid) -> first();
               

                // busco la oferta cotejando con la uid recibida

                $offer = Offer::where("uid", "=", $offerUid) -> first();
                
                // Me registro en la oferta añadiendo los id de usuario e id 
                // de oferta en la tabla intermedia

                $offer->candidates()->attach($user->id);
               
                
				
				
				return response() -> json([
                    "success" => "e",
                ]);
				
			} catch(\Illuminate\Database\QueryException $e){
                
                $errorCode = $e->errorInfo[1];
                
                
                if ($errorCode == 1062) {
                    return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "offer_find_1"
                    ], 404);            
                };
                
                
                return $e->errorInfo;
			
		};
	}
	
	public function getAppliedOffers($uid){
		
        try {
			
			// Busco el employee cotejando la uid recibida
			$user = Employee::where("uid", "=", $uid) -> first();
			
			
			// Si no encuentro el empleado
			if ($user == null) {
				return response()->json([
					'error' => "No se ha encontrado ningún empleado con esa UID.",
					'errorCode' => "offer_getAppliedOffers_1"
				], 404);
			};			
			
			
			// Busco todas las ofertas a las que se ha inscrito el employee
			$result = $user->offers;
			
			
			// Recorro el array de ofertas suscritas
			foreach ($result as $offer) {
				
				$company_id = $offer->company_id;
				
				// Busco la empresa cotejando la id de la oferta
				$company = Company::where("id", "=", $company_id) -> get();
				
				// Incorporo el nombre de la empresa en el objeto de la oferta
                $offer['_companyName'] = $company[0]->name;
                
                $offer['_companyUid'] = $company[0]->uid;

                $offer['_companyAvatar'] = $company[0]->avatar_url;
                    
                
            };
            
            unset($offer);
			
			return response() -> json($result);
			
		} catch(\Illuminate\Database\QueryException $e){
              
			$errorCode = $e->errorInfo[1];
			
			
			if ($errorCode == 1062) {
				return response()->json([
					'error' => "No se ha encontrado ningún usuario.",
					'errorCode' => "offer_getAppliedOffers_1"
				], 404);
			};
			
			
			return $e->errorInfo;
			
		};
    }

    public function getCreatedOffers($uid){
		
        try {
			
			// Busco la empresa cotejando la uid recibida
			$user = Company::where("uid", "=", $uid) -> first();
			
			// Busco todas las ofertas que ha creado la compañia
            $result = Offer::where("company_id", "=", $user->id)->get();

            foreach ($result as $offer) {
				
				$company_id = $offer->company_id;
				
				// Busco la empresa cotejando la id de la oferta
				$company = Company::where("id", "=", $company_id) -> get();
               
                // Incorporo el nombre de la empresa en el objeto de la oferta
               
                $offer['_companyName'] = $company[0]->name;
                $offer['_companyUid'] = $company[0]->uid;
                $offer['_companyAvatar'] = $company[0]->avatar_url;
				
			};
            
            unset($offer);
			
			return response() -> json($result);
			
		} catch(\Illuminate\Database\QueryException $e){
              
			$errorCode = $e->errorInfo[1];
			
			
			if ($errorCode == 1062) {
				return response()->json([
					'error' => "No se ha encontrado ninguna oferta.",
					'errorCode' => "offer_getCreatedOffers_1"
				], 404);
			};
			
			
			return $e->errorInfo;
			
		};
    }

    public function getCandidates($uid){
		
        try {
			
			// Busco la empresa cotejando la uid recibida
			$user = Company::where("uid", "=", $uid) -> first();
			
			// Busco todas las ofertas que ha creado la compañia
            $offers = Offer::where("company_id", "=", $user->id)->get();
            
            // Busco a los empleados que estan suscritos a mis ofertas

            
            $result=[];
            foreach ($offers as &$offer) {                       
                        
                        //Meto los candidatos en una variable
                        $hardcodeCandidates = $offer ->candidates;

                        //recorro el array de candidatos 

                        foreach ($hardcodeCandidates as &$hardcodeCandidate){
                            //asigno a cada uno de ellos el titulo y offerUid
                            //de la oferta a la que se han inscrito
                            $hardcodeCandidate['_offerTitle'] = $offer ->title;

                            $hardcodeCandidate['_offerUid'] = $offer ->uid;

                            $hardcodeCandidate['_status'] = $hardcodeCandidate->pivot->status;
                        }
                        //borro la referencia del for each
                        unset($hardcodeCandidate);

                        //meto en un array todos los candidatos hardcodeados
                        array_push($result, $hardcodeCandidates );

                    }

                    // borramos la referencia a cada elemento del array
                    unset($offer);

			
			
			return response() -> json($result);
			
		} catch(\Illuminate\Database\QueryException $e){
              
			$errorCode = $e->errorInfo[1];
			
			
			if ($errorCode == 1062) {
				return response()->json([
					'error' => "No se ha encontrado ninguna oferta.",
					'errorCode' => "offer_getCreatedOffers_1"
				], 404);
			};
			
			
			return $e->errorInfo;
			
		};
    }
    
    public function cancelOffer($offerUid, $userUid){
	
		
        try {
               
                // Busco el employee cotejando la uid recibida

                $user = Employee::where("uid", "=", $userUid) -> first();
               

                // busco la oferta cotejando con la uid recibida

                $offer = Offer::where("uid", "=", $offerUid) -> first();
                
                // Borro mi suscripcion a la oferta.
                
                $offer->candidates()->detach($user->id);
                		
				
				return response() -> json([
                    "success" => "e",
                ]);
				
			} catch(\Illuminate\Database\QueryException $e){
                
                $errorCode = $e->errorInfo[1];
                
                
                if ($errorCode == 1062) {
                    return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "offer_find_1"
                    ], 404);            
                };
                
                
                return $e->errorInfo;
			
		};
    }

    public function deleteOffer($offerUid){
	
		
        try {
               

                // busco la oferta cotejando con la uid recibida

                $offer = Offer::where("uid", "=", $offerUid) -> first();

                //borro las relaciones de esta oferta con usuarios
                $offer->candidates()->detach();
                
                // Borro mi la oferta.
                
                $offer->delete();
                		
				
				return response() -> json([
                    "success" => "e",
                ]);
				
			} catch(\Illuminate\Database\QueryException $e){
                
                $errorCode = $e->errorInfo[1];
                
                
                if ($errorCode == 1062) {
                    return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "offer_find_1"
                    ], 404);            
                };
                
                
                return $e->errorInfo;
			
		};
    }
    
    public function changeStatus($offerUid, $userUid, $status){
	
		
        try {
               
                // Busco el employee cotejando la uid recibida

                $user = Employee::where("uid", "=", $userUid) -> first();
               

                // busco la oferta cotejando con la uid recibida

                $offer = Offer::where("uid", "=", $offerUid) -> first();

                // cambio el status de la oferta en la tabla intermedia
                
                $offer->candidates()->updateExistingPivot($user, ['status' => $status]);
               
                // $user->relations()->attach($plan_id, ['child' => $childid]); con este comando
                //se crearia un registro nuevo con el campo pivot pasado por parametro
               
                
				
				
				return response() -> json([
                    "success" => "e",
                ]);
				
			} catch(\Illuminate\Database\QueryException $e){
                
                $errorCode = $e->errorInfo[1];
                
                
                if ($errorCode == 1062) {
                    return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "offer_find_1"
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
