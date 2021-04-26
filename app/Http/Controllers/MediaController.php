<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Media;
use App\MenuItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class MediaController extends Controller
{
    public function index(){
        $data = Media::where('folder_id','0')->get();
        $folders = Folder::all();
        return view('media.index',compact('data','folders'));
    }

    public function upload(Request $request){

        $validator = Validator::make($request->all(),[
            'file' => 'required|max:10000|mimes:jpeg,jpg,png'
        ]);
        if($validator->fails()){
            return 0;
        }

        $cord = json_decode($request->input('prop'));
        if($request->hasFile('file')){
            $validator = Validator::make($request->all(),[
                'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'error' => $validator->getMessageBag()->toArray()]);
            }
            $file = $request->file('file');
            if($request->input('param')){
               $name = preg_replace('/\?[^?]*$/', '',$file->getClientOriginalName());
                if($request->input('folder') == '0'){
                    $path= 'site/uploads/files/'.$name;
                    Image::make(public_path($path))->crop(intval($cord->w), intval($cord->h), intval($cord->x), intval($cord->y))->save(public_path($path));
                }else{
                    $p = Folder::where('id',$request->input('folder'))->first();
                    $path= 'site/uploads/files/'.$p->name.'/'.$name;
                    Image::make(public_path($path))->crop(intval($cord->w), intval($cord->h), intval($cord->x), intval($cord->y))->save(public_path($path));
                }
             return response()->json(['status' => 'success','size' => filesize($path),'path' => $path,'message' => 'edited successfully','public_url' => asset($path),'edited' => true]);
            }/*else {
            if($request->input('folder') == '0'){
//                dd(public_path('uploads/files/'.$file->getClientOriginalName()));
                Storage::disk('files')->put($file->getClientOriginalName(),File::get($file));
                $path = '/uploads/files/' . $file->getClientOriginalName();
                $img = Image::make(public_path($path));
                $img->crop(intval($cord->w), intval($cord->h), intval($cord->x), intval($cord->y));
                $img->save(public_path($path));
            } else {
                $p = Folder::where('id',$request->input('folder'))->first();
                Storage::disk('files')->put($p->name.'/'.$file->getClientOriginalName(),File::get($file));
                $path = '/uploads/files/'.$p->name.'/'. $file->getClientOriginalName();
                $img = Image::make(public_path($path));
                $img->crop(intval($cord->w), intval($cord->h), intval($cord->x), intval($cord->y));
                $img->save(public_path($path));
            }
            $data = new Media;
            $data->path = $path;
            $data->type = 'image';
            $data->folder_id = $request->input('folder');
            $data->created_at = Carbon::now();
            $data->save();
            $cnt = Media::where('folder_id',$request->input('folder'))->count();

            }
            return response()->json(['status' => 'success','size' => \File::size(public_path($data->path)),'path' => $data->path,'id' => $data->id,'message' => 'uploaded successfully','cnt' => $cnt,'public_url' => asset($data->path)]);
            */
        } else {
            return 0;
        }

    }
    public function delete_file(Request $request)
    {
        $path = Media::find($request->input('id'));
        try {
        Media::where('id',$request->input('id'))->delete();
        File::delete(public_path($path->path));
        if($request->input('folder')){
            $cnt = Media::where('folder_id',$request->input('folder'))->count();
        } else {
            $cnt = null;
        }
        return response()->json(['status' => 'success','id' => $request->input('id'),'message' => 'delete successfully','cnt' => $cnt]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Deleting problem!']);
        }
    }

    public function create_folder(Request $request){
        $path = public_path('/site/uploads/files/'.$request->input('name'));
        if(!File::exists($path)){
           Storage::disk('files')->makeDirectory( $request->input('name'));
           $data = new Folder;
           $data->name = $request->input('name');
           $data->created_at = Carbon::now() ;
           $data->save();
            return response()->json(['status' => 'success','id' => $data->id,'name' => $data->name,'message' => 'created successfully']);
        } else{
            return response()->json(['status' => 'fail']);
        }
    }

    public function delete_folder(Request $request)
    {
        $name = Folder::where('id',$request->input('id'))->first();
        $path = public_path('/site/uploads/files/'.$name->name);
        File::deleteDirectory($path);
        try {
            Folder::where('id', $request->input('id'))->delete();
            Media::where('folder_id', $request->input('id'))->delete();
            return response()->json(['status' => 'success', 'id' => $request->input('id'), 'message' => 'deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Deleting problem!']);
        }
    }

    public function open_folder(Request $request){
        $images = Media::with('folder')->where('folder_id',$request->input('id'))->get();
        $images1 = [];
        $img = [];
        $folder = Folder::find($request->input('id'));
//        dd('ok');
        foreach ($images as $image){
           $img['path'] = asset($image->path);
           $img['image'] = $image;
           if(is_file(public_path($image->path))){
               $img['size'] = \File::size(public_path($image->path));
           }
            array_push($images1,$img);
        }

        return response()->json(['status' => 'success','id' =>$request->input('id'),'images' => $images1,'f_name' => $folder->name]);
    }

    public function file_upload(Request $request){
        $data = $request->all();
        $x = $data['fol'];
        $return_array = [];
       foreach($request['file'] as $file){
           if($file->extension() == 'jpeg' || $file->extension() == 'jpg' || $file->extension() == 'png'  || $file->extension() == 'gif'){
                $ext = 'image';
           } else {
               $ext = $file->extension();
           }

           if($x == '0'){
                $path = '/site/uploads/files/'. $file->getClientOriginalName();
                Storage::disk('files')->put($file->getClientOriginalName(),File::get($file));
            }else{
                $p = Folder::where('id',$x)->first();
                $path = '/site/uploads/files/'.$p->name.'/'. $file->getClientOriginalName();
                Storage::disk('files')->put($p->name.'/'.$file->getClientOriginalName(),File::get($file));
            }
            $copy = Media::where('path',$path)->first();
            if($copy){
                continue;
            }
            $data = new Media;
            $data->path = $path;
            $data->folder_id = $x;
            $data->type = $ext;
            $data->created_at = Carbon::now();
            $data->save();
            $cnt = Media::where('folder_id',$x)->count();
            $return_array[] = ['status' => 'success','size' => \File::size(public_path($data->path)),
                'path' => $data->path,'id' => $data->id,'message' => 'uploaded successfully','cnt' => $cnt,'public_url' => asset($data->path),'type' => $ext];

       }
        return response()->json($return_array);
    }

}
