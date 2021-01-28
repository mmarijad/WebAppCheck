<?php
   
namespace App\Http\Controllers;
 
use App\Checks;
 
use Illuminate\Http\Request;
 
Use DB;
 
use Carbon\Carbon;
 
class GooglePieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 
          $data['pieChart'] = Checks::select(\DB::raw("COUNT(*) as count"), \DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name')
        ->orderBy('count')
        ->get();
        
    }
 
}