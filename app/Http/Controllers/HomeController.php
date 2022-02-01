<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appoinment;
class HomeController extends Controller
{
    function redirect(){

        if(Auth::id()){

            if (Auth::user()->usertype == '0') {
                $doctor = Doctor::all();
                return view('user.home',compact('doctor'));
            }else{
                return view('admin.home');
            }

        }else{
            return redirect()->back();
        }
    }

    public function index(){
        if (Auth::id()) {
            return redirect('home');
        }else{
        $doctor = Doctor::all();
        return view('user.home', compact('doctor'));
        }
    }
    public function appoinment(Request $request){
        
        $data = new Appoinment;

        $data->name = $request->name;
        $data->email = $request->email;
        $data->date = $request->date;
        $data->date = $request->date;
        $data->phone = $request->number;
        $data->message = $request->message;
        $data->doctor = $request->doctor;
        $data->status = 'In Progress';
        if (Auth::id()) {
            
        $data->user_id = Auth::user()->id;
        }
        $data->save();
        return redirect()->back()->with('message','Appoinment Request Successful. We will Contact with you soon');
    }

    public function myappoinment(){

        if (Auth::id()) {
            
            $userid = Auth::user()->id;

            $appoint = Appoinment::where('user_id',$userid)->get();
            // return view('user.my_appoinment', compact('appoint'));
            return view('user.my_appoinment', compact('appoint'));
        }else{
            return redirect()->back();
        }
    }

    public function cancel_appoint($id){

        $data = Appoinment::find($id);

        $data->delete();

        return redirect()->back();
    }
}
