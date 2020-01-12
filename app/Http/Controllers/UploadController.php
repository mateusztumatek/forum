<?php

namespace App\Http\Controllers;

use App\FileOwner;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Intervention\Image\ImageManagerStatic as Image;
class UploadController extends Controller
{
    public function upload(Request $request, $p){
        $files = [];
        if($request->allFiles()){
            if(array_key_exists('files', $request->allFiles())){
                $fs = $request->allFiles()['files'];
            }else{
                $fs = $request->allFiles();
            }
            foreach ($fs as $file){
                if(@is_array(getimagesize($file))){
                    $date = Carbon::now();
                    $image = $file;
                    $extension = $file->getClientOriginalExtension();
                    $filename = Str::random(4).$file->getClientOriginalName();

                    $path = $p.'/'.$date->format('F').$date->format('Y').'/';
                    if(!file_exists(public_path('/storage/'.$p))) mkdir(public_path('/storage/'.$p));
                    if(!file_exists(public_path('/storage/'.$path))) mkdir(public_path('/storage/'.$path));
                    $file->storeAs('/public/'.$path, $filename);
                    $to_save = $p.'/'.$date->format('F').$date->format('Y').'/'.$filename;
                    array_push($files, $to_save);
                }
            }
        }
        return response()->json(['data' => $files]);
    }
    public function remove(Request $request){
        $request->validate([
            'path' => ['required', function($field, $data, $fail){
                if(!file_exists(storage_path('/app/public/'.$data))) $fail('Plik nie istnieje');
            }]
        ]);
        if(!FileOwner::where('user_id', $request->user('api')->id)->where('path', $request->path)->first()) throw new UnauthorizedException();
        if($request->path){
            if(!is_array($request->path)){
                if(file_exists(public_path('/storage/'.$request->path))){
                    unlink(public_path('/storage/'.$request->path));
                }
            }else{
                foreach ($request->path as $path){
                    if(file_exists(public_path('/storage/'.$path))){
                        unlink(public_path('/storage/'.$path));
                    }
                }
            }

        }else{
            return response()->json(['message' => 'Path not defined']);
        }


        return response()->json(true);
    }
    public function update(Request $request){
        $request->validate([
            'file' => 'required|image',
            'path' => ['required', function($field, $data, $fail)use($request){
                if(!file_exists(storage_path('/app/public/'.$data))) $fail('Plik nie istnieje');
                if(!($user = $request->user('api'))) $fail('Unauthorized');
                $temp = FileOwner::where('user_id', $user->id)->where('path', $data)->first();
                if(!FileOwner::where('user_id', $user->id)->where('path', $data)->first()) $fail('Nie jestes właścicielem pliku');
            }]
        ]);
        $img = Image::make($request->file->getRealPath());
        $img->save(public_path('storage/'.$request->path));
        return response()->json(true);
    }
    public function userUploads(Request $request){
        $files = FileOwner::where('user_id', $request->user('api')->id)->get();
        foreach ($files as $key => $file){
            if(!file_exists(storage_path('/app/public/'.$file->path))) $files->forget($key);
        }
        return response()->json($files);
    }
}
