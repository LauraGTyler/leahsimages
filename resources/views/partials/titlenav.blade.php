<h1 id="leasimagestitle" class="center">Leahs Images:{{$title}}</h1>
@if(!empty($folder))
<nav>
  <?php $i=0;?>
   @foreach($trail as $folder)
@if ($i)
 /
@endif
<?php $i++?>
    <a href="/folder/{{$folder->id}}">{{$folder->display_name}}</a>
    @endforeach
</nav>
@endif