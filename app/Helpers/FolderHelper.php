<?php
namespace App\Helpers;

use App\folder;

//seperate mini spec: replacing recaptcha for this helper..

class FolderHelper
{
 public function addchildfolders(folder $folder){
     $pat = preg_quote($folder->path).'/*';
     $files=glob($pat,GLOB_ONLYDIR);
     //check for existing folders
    $existing = new folder;
    $existing = $existing->where('parent','=',$folder->id)->orderby('id','asc')->get();
    $lastid=0;
    $existnames=array();
    foreach ($existing as $exists){
      if (file_exists($folder->path.'/'.$exists->name)){
	$lastid=$exists->id;
	$existnames[]=strtolower($exists->name);
      }else{
	$exists->delete();
      }
    }
    foreach ($files as $file){
      $fdr = new folder();
      $parts =preg_split('/\//',$file);
      $fdr->name =array_pop($parts);
      if(empty($fdr->name)){
	$fdr->name=array_pop($parts);
      }
      if(in_array($fdr->name, $existnames)){
	continue;
      }
      $lastid++;
      $fdr->folderorder =$lastid;
      $fdr->path =$folder->path.'/'.$fdr->name;
      $fdr->parent=$folder->id;
      $fdr->display_name=$fdr->name;
      
      $fdr->save();
    }
 
 }


 public function trail($folder){
  $trail=[$folder];
  $fdr=$folder;
  $newfdr= new folder();
  while(!empty($fdr->parent)){
    $fdr=$newfdr->find($fdr->parent);
    $trail[]=$fdr;
  }
  
  return array_reverse($trail);

 }

   
}
?>