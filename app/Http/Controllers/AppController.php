<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use App\Admin;
use App\Checks;
use Carbon\Carbon;

class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $apps = App::select('webapps.id as app_id', 'webapps.name', 'webapps.url', 'webapps.current_state', 'admins.id as id_admin', 'admins.email as email', 'admins.namelastname as namelastname')
        ->JOIN('admins', 'webapps.admin_id', '=', 'admins.id')
        ->ORDERBY('webapps.created_at', 'asc')
        ->get();
        $message="";

        return view('apps') 
        ->with('apps', $apps)
        ->with('message', $message);
    }


    public function store(Request $request)
	{
        $email =$request->input('email');
        $admin = Admin::where('email', '=', $email)->first();
        $domain = $request->input("url");
        $message ="";

        function isDomainAvailible($domain)
        {
                //check, if a valid url is provided
                if(!filter_var($domain, FILTER_VALIDATE_URL))
                {
                        return false;
                }
    
                //initialize curl
                $curlInit = curl_init($domain);
                curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
                curl_setopt($curlInit,CURLOPT_HEADER,true);
                curl_setopt($curlInit,CURLOPT_NOBODY,true);
                curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
    
                //get answer
                $response = curl_exec($curlInit);
    
                curl_close($curlInit);
    
                if ($response) return true;
    
                return false;
        }
    
        if (isDomainAvailible($domain))
        {
            if ($admin === null) {
                $admin = new Admin();
                $admin->namelastname=$request->input("namelastname");
                $admin->email = $request->input("email");
                $admin->save();
    
                $app = new App();
                $app->name = $request->input("name");
                $app->url = $request->input("url");
                $app->current_state = "Nije pregledano";
                $app->admin_id = $admin->id;
                $message="Uspješno ste dodali aplikaciju.";
                $app->save();
    
    
                $check = new Checks();
                $check->app_id = $app->id;
                $check->status = "Nije pregledano";
                $check->save();

                return redirect()->route('apps', [$message]);
            }

            else {
                $app = new App();
                $app->name = $request->input("name");
                $app->url = $request->input("url");
                $app->admin_id = $admin->id;
                $app->current_state = "Nije pregledano";
                $app->save();
                $check = new Checks();
                $check->app_id = $app->id;
                $check->status = "Nije pregledano";
                $check->save();
                $message="Uspješno ste dodali aplikaciju.";
    
                return redirect()->route('apps', [$message]);
            }
        
        }
        else
        {
            $message="Unijeli ste nepostojeći url.";
            return redirect()->route('apps', [$message]);
        }        
    }
    

    public function delete(Request $request, $id)
	{ 
        $app = App::find($id);
        $check = Checks::select('*')->where('app_id','=', $id);
        $check->delete();
        $app->delete();

        return redirect(route('apps'));
    }
    
    public function check(Request $request, $id)
    {
       
        $a = App::select('webapps.id as id_app', 'webapps.name', 'webapps.url','webapps.current_state','checks.status', 'checks.created_at as date','admins.id as id_admin', 'admins.email as email', 'admins.namelastname as namelastname')
        ->JOIN('admins', 'admin_id', '=', 'admins.id')
        ->JOIN('checks', 'checks.app_id', '=', 'webapps.id')
        ->WHERE('webapps.id', '=', $id)
        ->ORDERBY('checks.created_at', 'desc')
        ->first();

        $apps = App::select('webapps.id as id_app', 'webapps.name', 'webapps.url','checks.status', 'checks.created_at as date','admins.id as id_admin', 'admins.email as email', 'admins.namelastname as namelastname')
        ->JOIN('admins', 'admin_id', '=', 'admins.id')
        ->JOIN('checks', 'checks.app_id', '=', 'webapps.id')
        ->WHERE('webapps.id', '=', $id)
        ->ORDERBY('webapps.created_at', 'asc')
        ->get();

        
        $url = $a->url;

        function Visit($url){
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
    
            if (Visit($url))
                {
                    $message = "Website OK";
                    $check = new Checks();
                    $check->app_id = $id;
                    $check->status = "Sve u redu";
                    $check->save();
                    $app=App::select('*')->where('id','=',$id)->first();
                    $app->current_state="Sve u redu";
                    $app->save();
                    return $message;
                }
            else 
            {
                $message = "Website DOWN";
                $check = new Checks();
                $check->app_id = $id;
                $check->status = "Trenutno ne radi";
                $check->save();
                $app=App::select('*')->where('id','=',$id)->first();
                $app->current_state= "Trenutno ne radi";
                $app->save();
                return $message; 
            }

        return view('apps')
        ->with('apps', $apps)
        ->with('a', $a);
    }

    public function details(Request $request, $id)
    {
       
        $a = App::select('webapps.id as id_app', 'webapps.name', 'webapps.url','checks.status', 'checks.created_at as date','admins.id as id_admin', 'admins.email as email', 'admins.namelastname as namelastname')
        ->JOIN('admins', 'admin_id', '=', 'admins.id')
        ->JOIN('checks', 'checks.app_id', '=', 'webapps.id')
        ->WHERE('webapps.id', '=', $id)
        ->ORDERBY('checks.created_at', 'desc')
        ->first();

        $date = $a->date;
        $vrijeme =Carbon::parse($date)->format("d-m-Y H:i:s");

        $apps = App::select('webapps.id as id_app', 'webapps.name', 'webapps.url','checks.status', 'checks.created_at as date','admins.id as id_admin', 'admins.email as email', 'admins.namelastname as namelastname')
        ->JOIN('admins', 'admin_id', '=', 'admins.id')
        ->JOIN('checks', 'checks.app_id', '=', 'webapps.id')
        ->WHERE('webapps.id', '=', $id)
        ->ORDERBY('webapps.created_at', 'asc')
        ->get();

        $down = Checks::select('status')->where('app_id', '=', $id)->where('status', '=', 'Trenutno ne radi')->get();
        $down_count = count($down);
        $up = Checks::select('status')->where('app_id', '=', $id)->where('status', '=', 'Sve u redu')->get();
        $up_count = count($up);

        return view('app_details')
        ->with('apps', $apps)
        ->with('a', $a)
        ->with('vrijeme', $vrijeme)
        ->with('up_count', $up_count)
        ->with('down_count', $down_count);

    }

    public function googlePieChart() {
        $down = Checks::select('status')->where('status', '=', 'Trenutno ne radi')->get();
        $down_count = count($down);
        $up = Checks::select('status')->where('status', '=', 'Sve u redu')->get();
        $up_count = count($up);

        return view('chart')
        ->with('up_count', $up_count)
        ->with('down_count', $down_count);
    }

    public function chart()
    {
          $data['pieChart'] = Checks::select('status')->where('status', '=', 'Trenutno ne radi')->get();
    }
}
