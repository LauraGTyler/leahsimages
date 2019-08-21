<li class="ui-sortable-handle" id="imageli{{$img->id}}">
  <span class="hidden imageatts">{{json_encode($img)}}</span>
  <img src="{{$img->thumbpath}}/thumb_{{$img->imagename}}?{{date("Y-m-d H:i:s")}}" alt="{{$img->caption}}" title="{{$img->caption}}"/>
  <div class="caption">{{$img->caption}}</div>
</li>
