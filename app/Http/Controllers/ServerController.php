<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Image;

class ServerController extends Controller
{
  public function lauraistesting(){
    $img= Image::make(public_path('/images/folders/1/thumb_laura.jpg'));
      $img->opacity(50);
      $img->save(public_path('/images/folders/1/transparent_laura.png'));
  }
    
}
