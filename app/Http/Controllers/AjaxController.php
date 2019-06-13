<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\folder;
use App\limage;
use App\Helpers\ImageHelper;

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
    //make transparent image
    $ih = new ImageHelper();
    $ih->make_transparent_image(public_path($limg->thumbpath.'/thumb_'.$limg->imagename));
    $return=new \stdClass();
    $return->success=true;
    return json_encode($return);
    

  }


   public function savefolderatts(Request $request){

     $folderid=$request->query('folderid');
     $folder=new folder;
     $folder= $folder->find($folderid);
  
     $return = new \stdClass();

     if(empty($folder)){
       $return->success=false;
       $return->error='Could not find that folder';
        return json_encode($return);
     }
     
     $folder->display_name=$request->query('display_name');
     $folder->description=$request->query('description');
     $folder->save();
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
			      
  public function imageorder(Request $request){
    $order=json_decode($request->query('order'));
    $lastorderid=0;
    foreach($order as $imageid){
      $image=new limage();
      $image= $image->find($imageid);
      $lastorderid++;
      $image->imageorder=$lastorderid;
      $image->save();
    }
    $return=new \stdClass();
    $return->success=true;
    return json_encode($return);
      
  }
  
 public function saveimageatts(Request $request){

     $imageid=$request->query('imageid');
     $image=new limage;
     $image= $image->find($imageid);
  
     $return = new \stdClass();

     if(empty($image)){
       $return->success=false;
       $return->error='Could not find that image';
        return json_encode($return);
     }
     
     $image->caption=$request->query('caption');
     $image->notes=$request->query('note');
     $image->save();
    $return->success=true;
    return json_encode($return);
    

  }
  

}
