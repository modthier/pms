<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Log;
use Session;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
     public function index(){
        $disk = Storage::disk('backup');
        $files = $disk->files('/');
        $backups = [];
        foreach ($files as $k => $f) {

           if (substr($f, -4) == '.zip') {
               $backups[] = [
               'file_path' => $f,
               'file_name' => $f,
               'file_size' => $disk->size($f),
               'last_modified' => $disk->lastModified($f),
                ];
           }
        }
	    $backups = array_reverse($backups);
	    
        return view("backup.index")->with(compact('backups'));
    }


    public static function humanFileSize($size,$unit="") {
          if( (!$unit && $size >= 1<<30) || $unit == "GB")
               return number_format($size/(1<<30),2)."GB";
          if( (!$unit && $size >= 1<<20) || $unit == "MB")
               return number_format($size/(1<<20),2)."MB";
          if( (!$unit && $size >= 1<<10) || $unit == "KB")
               return number_format($size/(1<<10),2)."KB";
          return number_format($size)." bytes";
    }


    public function create()
    {
          try {
               /* only database backup*/
	          Artisan::call('backup:run --only-db');
               /* all backup */
               /* Artisan::call('backup:run'); */
               $output = Artisan::output();
               Log::info("Backpack\BackupManager -- new backup started \r\n" . $output);
               session()->flash('success', 'Successfully created backup!');
               return redirect()->back();
          } catch (Exception $e) {
               session()->flash('danger', $e->getMessage());
               return redirect()->back();
          }
    }

    public function download($file_name) {
        
        return response()->download(storage_path('backup/PMS/' . $file_name));
       
    }


    public function delete($file_name){
          $s = Storage::disk('backup')->delete($file_name);

          dd($s);
          //return redirect()->back();
     }
}
