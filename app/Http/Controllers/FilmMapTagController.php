<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FilmMapTag;

class FilmMapTagController extends Controller
{
    function index(){
        try{
            $data = array();
            $result = DB::table('tags AS t')
                ->select('f.id', 'f.title', 'f.year', 't.id as tid')
                ->join('film_map_tags AS fmt', 't.id', '=', 'fmt.tag_id')
                ->join('films AS f', 'fmt.film_id', '=', 'f.id')
                ->orderBy('t.title', 'asc')
                ->orderBy('f.title', 'asc')
                ->get();

            foreach($result as $val){
                if(!array_key_exists($val->id, $data)){
                    $data[$val->id]['title'] = $val->title;
                    $data[$val->id]['year'] = $val->year;
                    $data[$val->id]['tags'] = array();
                }
                array_push($data[$val->id]['tags'], $val->tid);
            }
            return ['films'=>$data, 'success'=>true, 'message'=>''];
        }catch(Exception $e){
            return ['films'=>[], 'success'=>false, 'message'=>$e->getMessage()];
        }
    }
    static function store($id, $tags){
        try{
            foreach($tags as $tag_id){
                $result = new FilmMapTag();
                $result->film_id = $id;
                $result->tag_id = $tag_id;
                $result->save();
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    static function update($id, $tags){
        try{
            FilmMapTag::where('film_id', $id)->delete();
            foreach($tags as $tag_id){
                $result = new FilmMapTag();
                $result->film_id = $id;
                $result->tag_id = $tag_id;
                $result->save();
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
