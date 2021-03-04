<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layout.app')
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('layout.sidebar')
    <div class="page-content-wrapper">
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
                        <input type="file" name="pic" id="med_pic">
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
</body>
@include('layout.footer')

{{--<script src="/js/menus/index.js"></script>--}}
<script src="/js/media.js" type="text/javascript"></script>
