<label for="path" style="font-size: 26px">News Categories</label>
<select class="form-control form-control-lg" name="categoryID">
    <option value="" selected disabled>Choose here</option>
    @foreach($categories as  $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
    @endforeach
</select><br>

<label for="path" style="font-size: 26px">News Style</label>
<select class="form-control form-control-lg" name="style">
        <option value="classic">Classic News</option>
        <option value="accordion">Accordion</option>
</select><br>
