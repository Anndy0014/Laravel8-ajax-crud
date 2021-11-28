<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Yajra\DataTables\DataTables;

class CountriesController extends Controller
{
    //
    use ValidatesRequests;
    public function index(){
        return view('countries-list');
    }

    //ADD NEW COUNTRY
    public function addCountry(Request $request){
        $validator = Validator::make($request->all(), [
            'country_name'=>'required|unique:countries',
             'capital_city'=>'required',
        ]);

        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add(
                    'field', 'Something is wrong with this field!'
                );
            }
        });

        if ($validator->fails()) {
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $country = new Country();
            $country->country_name = $request->country_name;
            $country->capital_city = $request->capital_city;
            $query = $country->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Something went wrong']);
            }else{
                return response()->json(['code'=>1,'msg'=>'New Country has been successfully saved']);
            }
        }
   }

   
}
