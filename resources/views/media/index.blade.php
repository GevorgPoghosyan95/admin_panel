<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

<link href="/css/lang.css" rel="stylesheet" type="text/css"/>
<style>
    img {
        display: block;
        max-width: 100%;
    }
    .preview {
        overflow: hidden;
        width: 100%;
        height: 200px;
        margin: 10px;
        border: 1px solid red;
    }
    .modal-lg{
        max-width: 1000px !important;
    }
    /*.cord {padding: 15px}*/
    .cord p {margin: 2px}
    .cord span {font-weight: 600 ;font-size: 14px}
</style>
@include('layout.app')
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('layout.sidebar')
    <div class="page-content-wrapper">
        <div id="lang-switch">
            <img src="/images/armenia.png" class="hy">
            <img src="/images/english.png" class="en">
            <img src="/images/russia.png" class="ru">
        </div>
        <div class="page-content media_content">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Media</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 m-toolbar">
                    <div class="col-lg-1">
{{--                        <input type="file" name="image" class="image">--}}
                        <input type="file" name="pic" id="med_pic" class="image" accept="image/x-png,image/gif,image/jpeg" >
                        <input type="hidden" name="fldr" id="fldr" value="0">
                        <label for="med_pic">
                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                            <span style="display: block;margin-top: 10px"> upload file</span>
                        </label>
                    </div>
                    <div class="col-lg-1">
                        <div class="toolbar_m">
                            <i class="fa fa-folder" aria-hidden="true"></i>
                            <span style="display: block;margin-top: 10px"> create folder</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                   <span><a href="javascript:void(0)" id="r_menu">media</a></span>
                </div>
            </div>
            <div class="f_level" style="display: none">
                <div class="row"></div>
                <div class="col-lg-12 f_data">
                </div>
            </div>
            <div class="row r_level">
                <div class="col-lg-12 folder_bl">
                    @foreach($folders as $folder)
                        <div class="f_box" data-id="{{$folder->id}}">
                            <div class="folder_box">
                                <span class="count">{{$folder->picture->count()}}</span>
                                <i class="fa fa-folder" aria-hidden="true"></i><span>{{$folder->name}}</span>
                            </div>
                            <div class="rem_fol">delete folder</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row r_level">
                <div class="col-lg-12 img_bl">
                    @foreach($data as $item)
                        <div class='img_box' data-id="{{$item->id}}">
                            <span aria-hidden="true" class="rem"><i class="fa fa-close img_del"></i></span>
                            <p class="vert"> {{humanFileSize(\File::size(public_path($item->path)))}} </p>
                            <img class='blah' src="{{$item->path}}" />
                            <a href="javascript:void(0) " style="margin-top: 1px" data-path="{{asset($item->path)}}">copy public path </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </div>
</body> <?php
function humanFileSize($size,$unit="") {
    if( (!$unit && $size >= 1<<30) || $unit == " GB")
        return number_format($size/(1<<30),2)." GB";
    if( (!$unit && $size >= 1<<20) || $unit == " MB")
        return number_format($size/(1<<20),2)." MB";
    if( (!$unit && $size >= 1<<10) || $unit == " KB")
        return number_format($size/(1<<10),2)." KB";
    return number_format($size)." bytes";
}
?>
<div class="flash-modal">
    <p></p>
</div>
<!-- Modal -->
<div class="modal fade" id="folder_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('create_folder')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="url">Folder name</label>
                        <input type="text" class="form-control" id="f_name" placeholder="name" name="f_name">
                        <input type="hidden" name="lang" value="hy">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_f">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--crop image--}}
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel" style="width: 65%;float: left">recomend size 600x600</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="cord" style="width: 35%;float: right;text-align: center">
                    <p class="height">width : <span class="w_value"></span></p>
                    <p class="width">height : <span class="h_value"></span></p>
                </div>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview" id="preview"></div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>


</body>
@include('layout.footer')

{{--<script src="/js/menus/index.js"></script>--}}

<script>

</script>

<script src="/js/media.js" type="text/javascript"></script>
