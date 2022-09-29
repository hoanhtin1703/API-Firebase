<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Firestore;
class TestController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = app('firebase.database');
    
    }
    public function create(){

            $data =[
                    'id'=>"4",
                    
            ];
           $this->database->getReference('data/')->set($data);
          
        
    }
    public function index(){
        return response()->json($this->database->getReference('data/')
        ->orderByChild('id')
        ->getValue());
    }
}
