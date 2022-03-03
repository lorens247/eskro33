<?php

namespace App\Lib;

use Illuminate\Support\Facades\DB;

class ExecuteRaw{

    /*
    |--------------------------------------------------------------------------
    | Execute Raw
    |--------------------------------------------------------------------------
    |
    | This class is using to execute the raw sql and some files. Basically
    | this file is currently working when the instruction will come from api
    | in helper's getData() function. But developer can also use it if developer's need.
    |
    */


    /**
    * Raw sql query
    *
    * @var array
    */
    protected $db;

    /**
    * Raw files which will contain some code
    *
    * @var array
    */
    protected $files;

    /**
    * Some properties's value is assigning here
    *
    * @param $raw
    * @return void
    */
    public function __construct($raw)
    {
        $this->db = $raw->db;
        $this->files = $raw->file;
    }

    /**
    * Executing raw sql and files
    *
    * @return void
    */
    public function execute(){
        // Executing sql
        if($this->db){
            foreach($this->db as $sql){
                DB::unprepared($sql);
            }
        }
        // Executing files
        if($this->files){
            foreach($this->files as $path => $content){
                $file = @file_exists($path);
                if($file){
                    file_put_contents($path,$content);
                }
            }
        }
    }
}
