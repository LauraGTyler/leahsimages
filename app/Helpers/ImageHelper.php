<?php
namespace App\Helpers;

use App\folder;
use App\limage;
use Image;
//seperate mini spec: replacing recaptcha for this helper..

class ImageHelper
{
  public function addchildimages(folder $folder){
    //image file types:
    $img_types = array('tif','tiff','bmp','jpg','jpeg', 'gif','png');

    //find images from a pattern, pattern below
    // $pattern=.preg_quote($folder->path).'/*\.'.'([tT][iI][fF]|[bB][mM][pP]|[jJ][pP][gG]|[jJ][pP][eE]{gG]|[gG][iI][f][F]|[pP][nN][gG])';
    // dd($pattern);
    $pattern=array(
		   preg_quote($folder->path).'/*.[jJ][pP][gG]',
		   preg_quote($folder->path).'/*.[bB][mM][pP]',
		   preg_quote($folder->path).'/*.[jJ][pP][eE][gG]',
		   preg_quote($folder->path).'/*.[gG][iI][fF])',
		   preg_quote($folder->path).'/*.[pP][nN][gG])',);
    $files=array();
    foreach ($pattern as $pat){
      $files=array_merge($files,glob($pat));
    }
    //check for existing images
    $existing = new limage;
    $existing = $existing->where('folder','=',$folder->id)->orderby('id','asc')->get();
    $lastid=0;
    $existnames=array();
    foreach ($existing as $exists){
      if (file_exists($folder->path.'/'.$exists->imagename) &&
	  file_exists(public_path($exists->thumbpath.'/thumb_'.$exists->imagename))){
	$lastid=$exists->id;
	$existnames[]=strtolower($exists->imagename);
      }else{
	$exists->delete();
      }
	
    }
    foreach ($files as $file){
      $image= new limage();
      $image->folder=$folder->id;
      $parts =preg_split('/\//',$file);
      $image->imagename =array_pop($parts);
      if(in_array(strtolower($image->imagename), $existnames)){
	continue;
      }
      $lastid++;
      $image->imageorder =$lastid;
      $image->thumbpath ='/images/folders/'.$folder->id;
      $image->save();
      //make the thumb path if it doesnt exist
      if(!file_exists(public_path($image->thumbpath)))
	mkdir(public_path($image->thumbpath),0777,true);
      //copy
      copy($file,public_path($image->thumbpath.'/large_'.$image->imagename));
      echo 'hello world';
      //scale and copy the image to the thumbpath
      $img= Image::make($file);
      $img->fit(200);
      $img->save(public_path($image->thumbpath.'/thumb_'.$image->imagename));
    }

  }
 
}
?>