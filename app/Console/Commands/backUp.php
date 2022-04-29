<?php

namespace App\Console\Commands;
use Storage;
use File;

use Illuminate\Console\Command;

class backUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     protected $signature = 'command:backup';

     /**
      * The console command description.
      *
      * @var string
      */
     protected $description = 'backUp 12 horas.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $name = "SYS-PE-CONDUCTORES-PRODUCION-".date("Y").date("m").date("d").date("H").date("i").date("s").'.backup';
$path = '/var/www/win-system/storage/logs/';
     $salida = shell_exec('PGPASSWORD="yjlcofok2vb7hobl" pg_dump -Fc -v -h db-peru-do-user-4438451-0.a.db.ondigitalocean.com -p 25060 -U doadmin > '.$path.$name.' FQEey57yDu');



  $fileData = File::get($path.$name);

  Storage::cloud()->put($name , $fileData);
unlink('storage/logs/'.$name);

    }
}
