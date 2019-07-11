<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\folder;
use App\rootfolder;
use App\limage;
use App\Helpers\ImageHelper;
use App\Helpers\FolderHelper;


class HomeController extends Controller
{

  public function folder($id){
    $ih = new ImageHelper();
    $fh = new FolderHelper();
    $newfolder = new folder();
    $newimage = new limage();
    $folder = $newfolder->find($id);
    $ih->addchildimages($folder);
    $images =$newimage->where('folder','=', $id)->orderby('imageorder','ASC')->get();
    $fh->addchildfolders($folder);
    $childfolders=$newfolder->where('parent','=', $id)->orderby('folderorder','ASC')->get();
    $trail=$fh->trail($folder);
    $atts =array('folder'=>$folder,
		 'title'=>$folder->display_name,
		 'childfolders'=> $childfolders,
		 'trail'=> $trail,
		 'images'=>$images);

	
    return view('pages.folder', $atts);

  }

  public function RootFolder(Request $request){
    $fh = new FolderHelper();
    $rf = new rootfolder();
    $rf = $rf->first();
    if (empty($rf)){
      return view('pages.browseforroot',array('title'=>'Unknown root folder' ));
    }else{
      return redirect(url('/folder/'.$rf->folderid));
     }
  }

  public function setRootFolder(Request $req){
    $rootFolder =$req->input('rootFolder');
    $ih = new ImageHelper;
    $fh = new FolderHelper();
    $fdr = new folder();
    $exists = new folder();
    $fdr->path = $rootFolder;

    $backslash="\\";
    $parts =preg_split('/\//',$rootFolder);;
    $name =array_pop($parts);
    if(empty($name)){
      $name=array_pop($parts);
    }
    $fdr->name=$name;
    $fdr->display_name=$name;
    //check if exists
    $exists = $exists->where('name','=',$name)
      ->where('path','=',$rootFolder)->first();
    if(!empty($exists)){
      $fdr = $exists;
    }
    $fdr->parent=NULL;      
    $fdr->save();
    $id=$fdr->id;
    \DB::table('rootfolder')->truncate();
    $rf = new rootfolder();
    $rf->folderid = $id;
    $rf->save();
    $ih->addchildimages($fdr);
    $fh->addchildfolders($fdr);
    return redirect(url('/folder/'.$rf->folderid))->withErrors(['Thankyou' =>'Root folder updated']); 
    

  }
}


?>
