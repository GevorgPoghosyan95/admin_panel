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
        <div id="lang-switch">
            <img src="/images/armenia.png" class="hy">
            <img src="/images/english.png" class="en">
            <img src="/images/russia.png" class="ru">
        </div>
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
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
            <form action="{{route('home.page.store')}}" method="post">
                @csrf
                <input type="hidden" name="lang" value="hy">
                <input type="hidden" name="car_template" value="t1">
                <input type="hidden" name="video_block" value="on">
                <input type="hidden" name="partners_carousel" value="on">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="path" style="font-size: 26px">Carousel type</label>
                        <br>
                        <div id="radios" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default active" id="news_r">
                                <input type="radio" name="carouselType"  value="1"  checked /> news
                            </label>
                            <label class="btn btn-default" for="gallery_r" id="gallery_r">
                                <input type="radio" name="carouselType"  value="2"  /> gallery
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6" id="car_bl" style="display: none">
                        <label for="path" style="font-size: 26px">Carousel folders</label>
                        <br>
                        <select class="form-control" name="carouselId">
                            @foreach($carousels as $carousel)
                                <option value="{{$carousel->id}}">{{$carousel->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6" id="cat_bl" >
                        <label for="path" style="font-size: 26px">News Categories</label>
                        <br>
                        <select class="form-control form-control-lg" name="carouselNewsCategory">
                            @foreach($categories as  $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                    <label for="path" style="font-size: 26px">News Categories</label>
                    <br>
                    <select class="form-control form-control-lg" name="categoryID">
                        @foreach($categories as  $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1">
                        <p style="font-size: 21px">Video block</p>
                    </div>
                    <div class="col-lg-3">
                        <br>
                        <div class="btn-group btn-toggle video-toggle" onclick="toggleButton(this)" data-t="video_block">
                            <button type="button" class="btn btn-primary active" data-status="on">ON</button>
                            <button type="button" class="btn btn-default " data-status="off">OFF</button>
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
                            <button type="button" class="btn btn-primary active" data-status="on">ON</button>
                            <button type="button" class="btn btn-default " data-status="off">OFF</button>
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
                                    <a href="{{$partner->url}}">
                                        <img src="data:image/png;base64,{{$partner->image}}" width="280"
                                                                           height="90"
                                                                           alt="{{$partner->description}}">
                                    </a>
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
            <form action="#" method="post" id="partners_from">
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
                    <button type="button" class="btn btn-primary save_part" >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

@include('layout.footer')
<script src="/js/pages/create.js"></script>
<script src="/js/home_page/index.js"></script>