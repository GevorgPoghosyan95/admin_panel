<?php

namespace App\Factory\Page;

use App\Http\Requests\PageRequest;
use App\Page;
use App\VideoLink;

class VideoGalleryCreator implements PageCreator {

    protected $request;
    protected $page;
    public function __construct(PageRequest $request,Page $page = null)
    {
        $this->request = $request;
        $this->page = $page;
    }

    public function create() :void
    {
        if($this->request["folders"]){
            $this->request->validate([
                'galleryType' => 'required',
            ]);
        }
        $file = $this->request->file('photos')[0];
        if ($file) {
            $imagedata = file_get_contents($file);
            $image = base64_encode($imagedata);
        } else {
            $image = null;
        }
        $pageData = $this->request->all();
        $pageData['image'] = $image;
        $page = Page::create($pageData);
        $page->folders()->sync($this->request->get('folders'));
        $links = $this->request->get('links');
        foreach ($links as $link) {
            VideoLink::create(['name'=>json_decode($link)->name,'url'=>json_decode($link)->url,'page_id'=>$page->id]);
        }

    }

    public function update(){

        $pageData = $this->request->all();
        $file = $this->request->file('photos')[0];
        $base64 = '';
        if ($file !== null) {
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
        }
        if ($this->request->input('img') === null && $file !== null) {
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
        }
        if ($this->request->input('img') !== null) {
            $base64 = $this->page->image;
        }
        $pageData['img'] = $base64;
        $this->page->update($pageData);
        $this->page->videoLinks()->delete();
        $links = $this->request->get('links');
        foreach ($links as $link) {
            if(!VideoLink::where('url',json_decode($link)->url)->exists()){
                VideoLink::create(['name'=>json_decode($link)->name,'url'=>json_decode($link)->url,'page_id'=>$this->page->id]);
            }
        }
        if($this->request->get('folders')){
            $this->page->folders()->sync($this->request->get('folders'));
            foreach ($this->page->folders as $folder) {
                foreach ($folder->files as $file){
                    if(!VideoLink::where('url',$file->path)->exists()){
                        VideoLink::create(['name'=>"Folder_{$file->folder_id}",'url'=>$file->path,'page_id'=>$this->page->id]);
                    }
                }
            }
        }else{
            foreach ($this->page->folders as $folder) {
                foreach ($folder->files as $file){
                   VideoLink::where('name',"Folder_{$file->folder_id}")->delete();
                }
            }
        }
        $this->page->folders()->sync($this->request->get('folders'));
    }
}
