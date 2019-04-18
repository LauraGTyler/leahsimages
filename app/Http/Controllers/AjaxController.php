<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\folder;
use App\limage;

class AjaxController extends Controller
{

  public function savedirectoryimage(Request $request){

    $imageid=$request->imageid;
    $limg=new limage();
    $limg = $limg->find($imageid);
    $imagename=$limg->imagename;
    $folderid= $limg->folder;
    $folder = new folder;
    $folder =$folder->find($folderid);
    $folder->imagename=$imagename;
    $folder->imageid=$imageid;
    $folder->thumbpath=$limg->thumbpath;
    $folder->save();
    $return=new \stdClass();
    $return->success=true;
    return json_encode($return);
    

  }

  public function folderorder(Request $request){
    $order=json_decode($request->query('order'));
    $lastorderid=0;
    foreach($order as $folderid){
      $folder=new folder();
      $folder= $folder->find($folderid);
      $lastorderid++;
      $folder->folderorder=$lastorderid;
      $folder->save();
    }
    $return=new \stdClass();
    $return->success=true;
    return json_encode($return);
      
  }
			      


}
