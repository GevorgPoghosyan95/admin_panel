@include('layout.app')
<script src="/js/tinymce.min.js"></script>
<link href="/css/lang.css" rel="stylesheet" type="text/css"/>

<link href="/css/home/index.css" rel="stylesheet" type="text/css"/>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
    @include('layout.sidebar')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">

            <form action="{{route('home.page.update',['id'=>$page->id])}}" method="post">
                @csrf
                <input type="hidden" name="car_template" value="t1">
                <input type="hidden" name="video_block" value="{{$page->video_block}}">
                <input type="hidden" name="partners_carousel" value="{{$page->partners_carousel}}">
                <input type="text" name="title" value="{{$page->title}}" class="form-control">
                <label style="font-size: 26px">Title</label>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 style="text-align: center">select template type</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 link_m" data-val="t1">

                        <div class="row">
                            <div class="col-lg-8 template" style="height: 300px;">
                                <div class="bd">
                                    carousel
                                </div>
                            </div>
                            <div class="col-lg-4 template" style="height: 100px;">
                                <div class="sd">news</div>
                            </div>
                            <div class="col-lg-4 template" style="height: 100px;">
                                <div class="sd">news</div>
                            </div>
                            <div class="col-lg-4 template" style="height: 100px;">
                                <div class="sd">news</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 link_m" data-val="t2">

                        <div class="row">
                            <div class="col-lg-12 template">
                                <div class="bd1">carousel</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 template">
                                <div class="sd">news</div>
                            </div>
                            <div class="col-lg-4 template">
                                <div class="sd">news</div>
                            </div>
                            <div class="col-lg-4 template">
                                <div class="sd">news</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="path" style="font-size: 26px">Carousel type</label>
                        <br>
                        <div id="radios" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default {{$page->carouselType == 1 ? 'active' : ''}}" id="news_r">
                                <input type="radio" name="carouselType"
                                       value="1" {{$page->carouselType == 1 ? 'checked' : ''}} /> news
                            </label>
                            <label class="btn btn-default {{$page->carouselType == 2 ? 'active' : ''}}" for="gallery_r"
                                   id="gallery_r">
                                <input type="radio" name="carouselType"
                                       value="2" {{$page->carouselType == 2 ? 'checked' : ''}} /> gallery
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6" id="car_bl" style="{{$page->carouselType == 2 ? '' : 'display:none'}}">
                        <label for="path" style="font-size: 26px">Carousel folders</label>
                        <br>
                        {!! Form::select('mainCarouselID', $carousels, $page->mainCarouselID,['class' => 'form-control']); !!}
                    </div>
                    <div class="col-lg-6" id="cat_bl" style="{{$page->carouselType == 1 ? '' : 'display:none'}}">
                        <label for="path" style="font-size: 26px">News Categories</label>
                        <br>
                        {!! Form::select('carouselNewsCategory', $categories, $page->carouselNewsCategory,['class' => 'form-control']); !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="path" style="font-size: 26px">News Categories</label>
                        <br>
                        {!! Form::select('categoryID', $categories, $page->categoryID,['class' => 'form-control']); !!}
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <p style="font-size: 21px">Video block</p>
                    </div>
                    <div class="col-lg-3">
                        <br>
                        <div class="btn-group btn-toggle" onclick="toggleButton(this)" data-t="video_block">
                            <button type="button" class="{{$page->video_block == 'on' ? 'btn btn-primary active' : 'btn btn-default'}}" data-status="on">ON</button>
                            <button type="button" class="{{$page->video_block == 'off' ? 'btn btn-primary active' : 'btn btn-default'}}" data-status="off">OFF</button>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <p style="font-size: 21px">Partners carousel</p>
                    </div>
                    <div class="col-lg-3">
                        <br>
                        <div class="btn-group btn-toggle partners-toggle" onclick="toggleButton(this)" data-t="partners_carousel">
                            <button type="button" class="{{$page->partners_carousel == 'on' ? 'btn btn-primary active' : 'btn btn-default'}}" data-status="on">ON</button>
                            <button type="button" class="{{$page->partners_carousel == 'off' ? 'btn btn-primary active' : 'btn btn-default'}}" data-status="off">OFF</button>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bl_container">
                            <div class="block new_block" >
                                <i class="fa fa-plus" aria-hidden="true" style="font-size: 72px;color: #0b94ea"></i>
                            </div>
                        </div>
                        <div class="partner">
                            @foreach($partners as $partner)
                                <div class="partner_bl" style="float: left" data-id="{{$partner->id}}">
                                    <span aria-hidden="true" class="rem"><i class="fa fa-close img_del"></i></span>
{{--                                    <a href="#">--}}
                                        <img src="data:image/png;base64,{{$partner->image}}" width="280"
                                             height="90"
                                             alt="{{$partner->description}}">
{{--                                    </a>--}}
                                </div>
                            @endforeach
                        </div>
                        </div>

                    </div>
                <button type="submit" class="btn btn-success pull-right">Save</button>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="partnersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form  method="post" id="partners_from">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New partner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="url">Partner site url</label>
                        <input type="text" class="form-control" id="url" placeholder="url" name="url"/>
                        <input type="hidden" name="lang" value="hy">
                    </div>
                    <div class="form-group part_l" >
                        <label for="p_logo">Add partner logo<i class="fa fa-cloud-upload" aria-hidden="true"></i> </label>
                        <input type="file" name="p_logo" id="p_logo" style="display: none">
                        <div id="imagePreview" style="background-repeat: no-repeat;position: relative ">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                    <button type="submit" class="btn btn-primary save_part" >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="flash-modal">
    <p></p>
</div>
</body>
@include('layout.footer')

<script>
 let template = `{{isset($page->car_template) ? $page->car_template : "" }}`;
/*    $('.btn-toggle').click(function() {
        $(this).find('.btn').toggleClass('active');
        if ($(this).find('.btn-primary').size()>0) {
            $(this).find('.btn').toggleClass('btn-primary');
        }
        $(this).find('.btn').toggleClass('btn-default');
        $("input[name='video_block']").val($(this).find('.active').data('status'));
    });

    $(document).ready(function () {
        $("input[name = 'car_template']").val('{{$page->car_template}}');
        $("div.link_m[data-val={{$page->car_template}}]").find('.sd,.bd,.bd1').css('background-color', '#cdcdcd');
        $("#gallery_r").click(function () {
            $("#cat_bl").hide();
            $("#car_bl").show();
        });
        $("#news_r").click(function () {
            $("#cat_bl").show();
            $("#car_bl").hide();
        });
    });
    $(document).on('click', '.link_m', function () {
        let val = $(this).data('val');
        $("input[name = 'car_template']").val(val);
        $('.link_m').find('.sd,.bd,.bd1').css('background-color', '#fff');
        $(this).find('.sd,.bd,.bd1').css('background-color', '#cdcdcd');
    })*/
</script>
<script src="/js/flashMessage.js" ></script>
<script src="/js/pages/create.js"></script>
<script src="/js/home_page/index.js"></script>