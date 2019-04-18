<h1 id="leasimagestitle" class="center">Leahs Images:{{$title}}</h1>
@if(!empty($folder))
<nav>
   @foreach($trail as $folder)
    <a href="/folder/{{$folder->id}}">{{$folder->name}}</a>
    @endforeach
</nav>
@endif