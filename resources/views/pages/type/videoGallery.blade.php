<div class="portlet-body" id="videoLinks" style="margin-top: 50px">
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <button id="sample_editable_1_new" class="btn green"> Add New Video Links
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
        <thead>
        <tr>
            <th> Name</th>
            <th> Url</th>
            <th> Edit</th>
            <th> Delete</th>
            <th> Params</th>
        </tr>
        </thead>
        <tbody>
        @if($videoLinks)
            @foreach ($videoLinks as $video)
                <tr>
                    <td>{{$video->name}}</td>
                    <td>{{$video->url}}</td>
                    <td>
                        <a class="edit" href="javascript:;"> Edit </a>
                    </td>
                    <td>
                        <a class="deleteLink" href="javascript:;"> Delete </a>
                    </td>

                    <td>
                        <input type="text" class="form-control" readonly name="links[]"
                               value="{{json_encode($video)}}">
                    </td>

                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
    <br>
    <label for="" style="font-size: 26px">Page Content</label>
    <textarea class="tiny_area" name="body"></textarea> <br>
</div>
