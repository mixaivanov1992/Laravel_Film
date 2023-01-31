<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;

class TagController extends Controller
{
    function index(){
        try{
            $data = array();
            $result = DB::table('tags')
                ->select('id', 'title')
                ->orderBy('title', 'asc')
                ->get();

            foreach($result as $val){
                array_push($data, $val);
            }
            return ['genres'=>$data, 'success'=>true, 'message'=>''];
        }catch(Exception $e){
            return ['genres'=>[], 'success'=>false, 'message'=>$e->getMessage()];
        }
    }
    function store(){
        try{
            $result = Tag::where('title', request('title'))->first();
            if (is_null($result)) {
                $result = new Tag();
                $result->title = request('title');
                $result->save();
                
                return ['id'=>$result->id, 'success'=>true, 'message'=>''];
            }
            return ['id'=>0, 'success'=>false, 'message'=>'Жанр уже существует'];
        }catch(Exception $e){
            return ['id'=>0, 'success'=>false, 'message'=>$e->getMessage()];
        }
    }
    function update(){}

    
    function destroy(){}
}
