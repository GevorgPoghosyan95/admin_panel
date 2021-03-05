<label for="path" style="font-size: 26px">News Categories</label>
<select class="form-control form-control-lg" name="categoryID">
    <option value="" selected disabled>Choose here</option>
    @foreach($categories as  $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
    @endforeach
</select><br>
