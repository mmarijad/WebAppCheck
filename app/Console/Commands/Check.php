<?php
 
namespace App\Console\Commands;
 
use App\User;
use App\App;
use App\Admin;
use App\Checks;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
 
class Check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check';
     
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to the administrator of the web application every time it stops working';
     
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
        $a = App::select('webapps.id as id_app', 'webapps.name', 'webapps.url','admins.id as id_admin', 'admins.email as email', 'admins.namelastname as namelastname')
        ->JOIN('admins', 'admin_id', '=', 'admins.id')
        ->get();

        function CheckTheApp($url){

            if(filter_var($url,FILTER_VALIDATE_URL)){
                $handle = curl_init(urldecode($url));
                curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
                $response = curl_exec($handle);
                $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                if($httpCode >= 200 && $httpCode < 400){
                return true;
                }else{
                return false;
                }
                curl_close($handle);
                }
            }

        foreach ($a as $app) {
       
            $url = $app->url;
            $email = $app->email;
            
                if (CheckTheApp($url))
                    {
                        $id =$app->id_app;
                        $message = "Website is working";
                        $ap=App::select('*')->where('id','=',$id)->first();
                        $ap->current_state="Sve u redu";
                        $ap->save();
                        $chck = new Checks();
                        $chck->app_id = $id;
                        $chck->status = "Sve u redu";
                        $chck->save();
                    }

                else 
                {
                    $id =$app->id_app;
                    $message = "Website is down";
                    $ap=App::select('*')->where('id','=',$id)->first();
                        $ap->current_state="Trenutno ne radi";
                        $ap->save();
                        $chck = new Checks();
                        $chck->app_id = $id;
                        $chck->status = "Trenutno ne radi";
                        $chck->save();
                    Mail::raw("Hello ".$app->namelastname."! \r\n \r\nWe are sorry to inform you that your web application ".$app->name." has stopped working. \r\n \r\nYour Web App Check Team", function ($mail) use ($app) {
                        $mail->from('webappchck@gmail.com');
                        $mail->to($app->email)
                            ->subject('Web App Check for '.$app->name);
                    });
                }

            }
            
        $this->info('Dovršena je provjera.');
    }
}