<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Offer;
use App\Models\Skill;
use App\Models\Employee;


class SkillController extends Controller
{
    public function findSkills(){

            return  response()->json(Skill::get());
        
    }

    public function applySkill($skillId, $uid){
	
		
        try {

                // busco la skill cotejando con su id 

                $skill = Skill::find($skillId);

                // Busco el employee cotejando la uid recibida

                $skillTaker = Employee::where("uid", "=", $uid) -> get();

                // si no existe el employee busca la uid en offer

               if ( $skillTaker -> isEmpty() ) {

                    //$skillTaker = Offer::where("uid", "=", $uid) -> get();
                    $skillTaker = Offer::where("uid", "=", $uid) -> get();

                    // Me registro en la oferta añadiendo los id de oferta e id 
                    // de skill en la tabla intermedia

                    $skill->ownerOffer()->attach($skillTaker[0]->id);
                    
                    
		        }else{

                    // Me registro en la oferta añadiendo los id de employee e id 
                    // de oferta en la tabla intermedia
                    
                    $skill->ownerEmployee()->attach($skillTaker[0]->id);
                }
             
                
				
				
				return response() -> json([
                    "success" => "e",
                ]);
				
			} catch(\Illuminate\Database\QueryException $e){
                
                $errorCode = $e->errorInfo[1];
                
                
                if ($errorCode == 1062) {
                    return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "skill_find_1"
                    ], 404);            
                };
                
                
                return $e->errorInfo;
			
		};
	}
	
	public function getAppliedSkills($uid){

		
        try {
				
               
                 // Busco el employee cotejando la uid recibida

                 $skillTaker = Employee::where("uid", "=", $uid) -> first();

                 // si no existe el employee busca la uid en offer
                
                if ( $skillTaker == null ) {
                    
                    $skillTaker = Offer::where("uid", "=", $uid) -> first();
                }
               
                // Busco todas las skills a las que se ha inscrito el employee u offer


                $result = $skillTaker ->skills; 
                
				
				return response() -> json($result);
				
			} catch(\Illuminate\Database\QueryException $e){
                
                $errorCode = $e->errorInfo[1];
                
                
                if ($errorCode == 1062) {
                    return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "company_find_1"
                    ], 404);            
                };
                
                
                return $e->errorInfo;
			
		};
	}
}
