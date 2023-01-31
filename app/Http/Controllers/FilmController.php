<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Http\Controllers\FilmMapTagController;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    function store(){
        try{
            $result = Film::where('title', request('params')['title'])->first();
            if (is_null($result)) {
                $id = DB::transaction(function () {
                    $result = new Film();
                    $result->title = request('params')['title'];
                    $result->year = request('params')['year'];
                    $result->save();
                    
                    $id = $result->id;
                    FilmMapTagController::store($id, request('params')['tags']);
                    return $id;
                });
                return ['id'=>$id, 'success'=>true, 'message'=>''];
            }
            return ['id'=>0, 'success'=>false, 'message'=>'Фильм уже существует'];
        }catch(Exception $e){
            return ['id'=>0, 'success'=>false, 'message'=>$e->getMessage()];
        }
    }
    function update(){
        try{
            $result = Film::where([
                ['title', '=', request('title')],
                ['id', '<>', request('id')]
            ])->first();
            if (!is_null($result)) {
                return ['success'=>false, 'message'=>'Фильм уже существует'];
            }
            DB::transaction(function () {
                Film::where('id', request('id'))->update(['title' => request('title'), 'year' => request('year')]);
                FilmMapTagController::update(request('id'), request('tags'));
            });
            return ['success'=>true, 'message'=>''];
        }catch(Exception $e){
            return ['success'=>false, 'message'=>$e->getMessage()];
        }
    }

    function destroy(){
        try{
            Film::where('id', request('id'))->delete();
            return ['success'=>true, 'message'=>''];
        }catch(Exception $e){
            return ['success'=>false, 'message'=>$e->getMessage()];
        }
    }
}
