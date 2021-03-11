@include('layout.app')
{{--<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
<script src="/js/tinymce.min.js"></script>
{{--<script src="/js/tiny.js"></script>--}}
<style>

    textarea {
        height: 400px;
    }

    input.btn {
        margin-top: 10px;
        float: right;
    }

    .image-uploader .uploaded .uploaded-image {
        width: calc(100% - 1rem);
        padding-bottom: calc(100% - 1rem);
    }

    .image-uploader .uploaded .uploaded-image img {
        object-fit: contain
    }
</style>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('layout.sidebar')
<!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            {!! Form::model($page, ['method' => 'PUT','route' => ['pages.update', $page->id], 'files' => true]) !!}
            <input type="hidden" name="pageID" value="{{$page->id}}">
            <label for="title" style="font-size: 26px">Title</label>
            <input type="text" class="form-control" name="title" id="title"
                   value="{!! !empty($page->title) ? $page->title : '' !!}"><br>
            <label for="path" style="font-size: 26px">Path</label>
            <input type="text" class="form-control" name="path" id="path"
                   value="{!! !empty($page->path) ? $page->path : '' !!}"><br>
            <label for="path" style="font-size: 26px">Left Sidebar Menu</label>

            <select class="form-control form-control-lg" name="menuID">
                <option value="">Without menu</option>
                @foreach($menus as  $menu)
                    @if($page->menuID == $menu->id)
                        <option value="{{$menu->id}}" selected>{{$menu->name}}</option>
                    @else
                        <option value="{{$menu->id}}">{{$menu->name}}</option>
                    @endif
                @endforeach
            </select><br>

            <label for="path" style="font-size: 26px">Page Type</label>
            <select class="form-control form-control-lg" name="type">
                @foreach($pageTypes as  $type)
                    @if($type == $page->type)
                        <option value="{{$type}}" selected>{{$type}}</option>
                    @else
                        <option value="{{$type}}">{{$type}}</option>
                    @endif
                @endforeach
            </select><br>
            @if($page->type == 'Content')
                <div class="news" style="display: none">
                    @include('pages.type.news',['categories'=>$categories->get()])
                </div>
                <label for="" style="font-size: 26px">Page Content</label>
                <textarea class="tiny_area" name="body"></textarea> <br>
                <div class="input-images" style="width: 10%"></div>
                <div class="img-alert" style="color: red;padding-left: 5px;font-size: 12px"></div> <br>
                {{--                <input type="file" name="doc" >--}}
                <input type="hidden" name="img" value="{{$page->image}}" id="img">
            @elseif($page->type == 'News')
                <label for="" style="font-size: 26px">Page News Category</label>
                {!! Form::select('categoryID', $categories->pluck('name','id'), $page->categoryID,['class' => 'form-control']); !!}
                <br>
                <div class="content" style="display: none">
                    @include('pages.type.content')
                </div>
            @elseif($page->type == 'Faq')
                <div class="news" style="display: none">
                    @include('pages.type.news',['categories'=>$categories->get()])
                </div>
                <div class="content" style="display: none">
                    @include('pages.type.content')
                </div>
            @endif

            <input type="submit" value="Save" class="btn btn-success"/>
            <div class="clearfix"></div>
            {!! Form::close() !!}
        </div>

    </div>
</div>

</body>
<script>  let myImg = '{{($page->image)}}' ? 'data:image/png;base64,{{($page->image)}}' : '',
        pre = myImg !== '' ? [{id: 1, src: myImg}] : [];
    let page_content = `{!! !empty($page->body) ? $page->body : '' !!}`
</script>
<script src="/js/pages/edit.js"></script>
@include('layout.footer')
