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

class MediaController extends Controller
{
    public function index(){
        $data = Media::where('folder_id','0')->get();
        $folders = Folder::all();
        return view('media.index',compact('data','folders'));
    }

    public function upload(Request $request){

        if($request->hasFile('file')){
            $validator = Validator::make($request->all(),[
                'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'error' => $validator->getMessageBag()->toArray()]);
            }
            $file = $request->file('file');
            if($request->input('folder') == '0'){
                Storage::disk('files')->put($file->getClientOriginalName(),File::get($file));
                $path = '/uploads/files/' . $file->getClientOriginalName();
            } else {
                $p = Folder::where('id',$request->input('folder'))->first();
                Storage::disk('files')->put($p->name.'/'.$file->getClientOriginalName(),File::get($file));
                $path = '/uploads/files/'.$p->name.'/'. $file->getClientOriginalName();
//                dd('/uploads/files/'.$p->name.'/'.$file->getClientOriginalName(),File::get($file));
            }
            $data = new Media;
            $data->path = $path;
            $data->folder_id = $request->input('folder');
            $data->created_at = Carbon::now();
            $data->save();
            $cnt = Media::where('folder_id',$request->input('folder'))->count();
            return response()->json(['status' => 'success','size' => \File::size(public_path($data->path)),'path' => $data->path,'id' => $data->id,'message' => 'uploaded successfully','cnt' => $cnt,'public_url' => asset($data->path)]);
        } else {
            return 0;
        }

    }
    public function delete_file(Request $request)
    {
        $path = Media::find($request->input('id'));
        Media::where('id',$request->input('id'))->delete();
        File::delete(public_path($path->path));
        if($request->input('folder')){
            $cnt = Media::where('folder_id',$request->input('folder'))->count();
        } else {
            $cnt = null;
        }
        return response()->json(['status' => 'success','id' => $request->input('id'),'message' => 'delete successfully','cnt' => $cnt]);
    }

    public function create_folder(Request $request){
        $path = public_path('/uploads/files/'.$request->input('name'));
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
        $path = public_path('/uploads/files/'.$name->name);
        File::deleteDirectory($path);
        Folder::where('id',$request->input('id'))->delete();
        Media::where('folder_id',$request->input('id'))->delete();
        return response()->json(['status' => 'success','id' => $request->input('id'),'message' => 'deleted successfully']);
    }

    public function open_folder(Request $request){
        $images = Media::with('folder')->where('folder_id',$request->input('id'))->get();
        $images1 = [];
        $img = [];
        $folder = Folder::find($request->input('id'));
        foreach ($images as $image){
           $img['path'] = asset($image->path);
           $img['image'] = $image;
           $img['size'] = \File::size(public_path($image->path));
           array_push($images1,$img);
        }
        return response()->json(['status' => 'success','id' =>$request->input('id'),'images' => $images1,'f_name' => $folder->name]);
    }



}
