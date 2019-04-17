@extends('layouts.leahsimages')

@section('titlenav')
@include('partials.titlenav')
@endsection


@section('content')
<h2>The root folder</h2>
<p>The root folder is currently unknown. Please put in the absolute path to the root forlder of the pictures.</p>
<form method="POST" action="/setRootFolder">
  @csrf
   <div class="form-group">
      <label for="rootfolder" class="col-sm-2 control-label">Root Folder:</label>
      <div class="col-sm-4">
          <input type="text" name="rootFolder" size="80" required="required" />
      </div>
    </div>
  <div class="form-group">
      <div class="col-sm-2">
      <div class="col-sm-4">
       <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>


</form>
<?php /*this does a folder brows, but uploads all of the files, which is unnecessary
<form action="POST" action="setRootFolder">
  @csrf
  <input type="file" name="rootFolder" onchange="selectFolder(event);" webkitdirectory multiple >

</form>
      */?>
@endsection