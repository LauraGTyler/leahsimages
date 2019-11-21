@extends('layouts.leahsimages')

@section('titlenav')
@include('partials.titlenav')
@endsection


@section('content')
<div id="directoryimage">
@if(!empty($folder->imagename))
<div class="center">
<img src="{{$folder->thumbpath}}/thumb_{{$folder->imagename}}" alt="{{$title}}" title="{{$title}}" />
</div>
  <?php $imagetext='Change associated folder image';?>
@else
<?php $imagetext='Accossiate folder image';?>
@endif
</div>
<br />  
  <div class="center" id="addimagediv"><a id="addimage" data-toggle="modal" data-target="#imageAssocModal">{{$imagetext}}</a></div>  

<form id="folderatts">
  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  <input type="hidden" name="folderid" value="{{$folder->id}}" />
   <div class="form-group row">
    <label for="display_name" class="col-sm-2 control-label">Folder display name:</label>
    <div class="col-sm-8">
       <input type="text" class="form-control" name="display_name" id="display_name" value="{{$folder->display_name}}" />
  </div>
  </div>
  <div class="form-group row">
  <label for="description" class="col-sm-2 control-label">Folder description:</label>
   <div class="col-sm-8">
  <textarea id="summernote" name="description">{{$folder->description}}</textarea>
  </div>
  </div>
  <div class="form-group row">
  <div class="col-sm-2"></div>
  <div class="col-sm-4"><button type="button" class="btn btn-info" id="savefolderatts">Save</button></div>
  </div>
</form>

<h2 class="center">Folders</h2>
<div class="center"><a class="button btn btn-info" id="reorderfolders">reorder folders</a><a class="hidden button btn btn-info" id="savefolderorder"></a></div>
<ul id="folders" class="clickable">
  @foreach($childfolders as $cf)
  <li><a href="/folder/{{$cf->id}}" alt="{{$cf->display_name}}" title="{{$cf->display_name}}">
  @if(!empty($cf->imagename))
  <?php
   $filename = pathinfo($cf->imagename, PATHINFO_FILENAME);
  ?>
  <img src="{{$cf->thumbpath}}/transparent_{{$filename}}.png" alt="{{$cf->display_name}}" title="{{$cf->display_name}}"/>
  <br />
   {{$cf->display_name}}
  @else
  <br />
  <br />
   {{$cf->display_name}}
  @endif
  </a></li>
  @endforeach
</ul>
<h2 class="center">Images</h2>
  <div class="center"><a class="button btn btn-info" id="reorderimages">reorder images</a><a class="button btn btn-info hidden" id="saveimageorder"></a></div>
    {{-- //do do here lauraistesting again --}}
  	  <input type="file" name="file" id="file">
	  @csrf
         <input type="hidden" name="folder" value="{{$folder->id}}" >   
            <!-- Drag and Drop container-->
            <div class="upload-area"  id="uploadfile">
                <p>Add an Image:<br><small>Drag and Drop file here<br>Or<br>Click to select file</small></p>
            </div>
        </div>


<ul id="images" class="clickable">
  @foreach($images as $img)
  <li id="imageli{{$img->id}}">
  <span class="hidden imageatts">{{json_encode($img)}}</span>
  <img src="{{$img->thumbpath}}/thumb_{{$img->imagename}}?{{date("Y-m-d H:i:s")}}" alt="{{$img->caption}}" title="{{$img->caption}}"/>
  <div class="caption">{{$img->caption}}</div>
  </li>
  @endforeach
</ul>

 
 <!--begin modal window-->
<div class="modal fade" id="imageAssocModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h3>Directory Images</h3>
<button type="button" class="close" data-dismiss="modal" title="Close"> <span class="glyphicon glyphicon-remove"></span></button>
</div>
<div class="modal-body">

<!--CAROUSEL CODE GOES HERE-->
<div id="myGallery" class="carousel slide" data-interval="false">
<div class="carousel-inner">
   <?php
  $imagechunks=array_chunk($images->all(),9);
  $i=1;
  ?>
  @foreach($imagechunks as $chunk)
  @if ($i==1)
    <div class="item active">
  <?php $i++;?>
  @else
  <div class="item">
  @endif
  <ul class="grid">
  @foreach($chunk as $img)
  <li><img src="{{$img->thumbpath}}/thumb_{{$img->imagename}}" width="150px" id="image{{$img->id}}" class="caroselimage" /></li>
  @endforeach
  </ul>
</div>
  @endforeach
<!--end carousel-inner--></div>

<!--end carousel--></div>
  
<!--end modal-body--></div>
<div class="modal-footer">
<!--Begin Previous and Next buttons-->
<button type="button" id="caroselleft" style="clear:left;float:left;"><span class="glyphicon glyphicon-chevron-left"></span></button>
<button type="button" id="caroselright"><span class="glyphicon glyphicon-chevron-right"></span></button>
<!--end modal-footer--></div>
<!--end modal-content--></div>
<!--end modal-dialoge--></div>
<!--end myModal--></div>

<div class="modal fade" id="imageDescModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h3>Image Attributes</h3>
<button type="button" class="close" data-dismiss="modal" title="Close"> <span class="glyphicon glyphicon-remove"></span></button>

<button type="button" title="Rotate clockways" id="imgrotate"> Rotate <span class="glyphicon glyphicon-refresh"></span></button>
</div>
<div class="modal-body">

<form class="form" id="imgatts">
  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  <input type="hidden" name="angle" id="imgangle" value="0" />
<div class="form-group row">
    <label for="caption" class="col-sm-2 control-label">Caption:</label>
    <div class="col-sm-8">
       <input type="text" class="form-control" name="caption" id="caption" value="" />
  </div>
  </div>
  <div class="form-group row">
  <label for="notes" class="col-sm-2 control-label">Notes:</label>
   <div class="col-sm-8">
  <textarea id="imagenotes" name="note"></textarea>
  </div>
  </div>
  <div class="form-group row">
  <div class="col-sm-2"></div>
  <div class="col-sm-4"><button type="button" id="saveimgatts">Save</button></div>
  </div>
</form>
<!--end modal-footer--></div>
<!--end modal-content--></div>
<!--end modal-dialoge--></div>
<!--end myModal--></div>
    


  
@endsection