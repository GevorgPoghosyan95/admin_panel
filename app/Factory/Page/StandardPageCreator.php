<?php

namespace App\Factory\Page;

use App\Http\Requests\PageRequest;
use App\Page;

class StandardPageCreator implements PageCreator {

    protected $request;
    protected $page;
    public function __construct(PageRequest $request,Page $page = null)
    {
        $this->request = $request;
        $this->page = $page;
    }

    /**
     * create pages with type ("News or Content)
     */

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
    }

    /**
     * update pages with type ("News or Content)
     */

    public function update(){
        if ($this->request->get("type") == "News") {
            $this->request->validate([
                'categoryID' => 'required',
            ]);
        }
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
        $pageData['image'] = $base64;
        $this->page->update($pageData);
        $this->page->folders()->sync($this->request->get('folders'));
    }
}
