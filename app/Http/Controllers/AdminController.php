<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getRatetype(){
        return view('/admin/ratetype');
    }
    public function getRateitem(){
        return view('/admin/rateitem');
    }
    
    public function getData($id, $idx){
        switch ($id){
            case 'ratetype':
                $data = \App\Ratetype::orderBy('idx', 'ASC')->get();
                return json_decode($data->toJson(), true);
                break;
            case 'rateitem':
                $data = \App\Rateitem::where('rate_type', $idx)->orderBy('idx', 'ASC')->get();
                if($data->count() > 0)
                {
                    return json_decode($data->toJson(), true);
                }
                else{
                    return null;
                }
        }
    }
    
    public function postData($id){
        $data = null;
        switch($id){
            case 'ratetype':
                if($_POST['query'] == 'create'){
                    $data = new \App\Ratetype;
                    $data->name = $_POST['name'];
                    $data->use_yn = $_POST['use_yn'];
                    $data->idx = $_POST['idx'];
                } else if($_POST['query'] == 'update_name') {
                    $data = \App\Ratetype::find($_POST['rate_type']);
                    $data->name = $_POST['name'];
                } else if($_POST['query'] == 'update_use'){
                    $data = \App\Ratetype::find($_POST['rate_type']);
                    $data->use_yn = $_POST['use_yn'];
                } else{
                    $data = \App\Ratetype::find($_POST['rate_type']);
                    $idx = $_POST['query']=='up'?($data->idx -1) : ($data->idx + 1);
                    $data_tmp = \App\Ratetype::where('idx', $idx)->first();

                    $data_tmp->idx = $data->idx;
                    $data_tmp->save();
                    $data->idx = $idx;
                }
                $data->save();

                break;

            case 'rateitem':
                if($_POST['query'] == 'create'){
                    $data = new \App\Rateitem;
                    $data->rate_type = $_POST['rate_type'];
                    $data->name = $_POST['name'];
                    $data->use_yn = $_POST['use_yn'];
                    $data->idx = $_POST['idx'];
                } else if($_POST['query'] == 'update_name') {
                    $data = \App\Rateitem::where('rate_type', $_POST['rate_type'])->where('rate_item', $_POST['rate_item'])->first();
                    $data->name = $_POST['name'];
                } else if($_POST['query'] == 'update_use') {
                    $data = \App\Rateitem::where('rate_type', $_POST['rate_type'])->where('rate_item', $_POST['rate_item'])->first();
                    $data->use_yn = $_POST['use_yn'];
                } else{
                    $data = \App\Rateitem::where('rate_type', $_POST['rate_type'])->where('rate_item', $_POST['rate_item'])->first();
                    $idx = $_POST['query']=='up'?($data->idx -1) : ($data->idx + 1);
                    $data_tmp = \App\Rateitem::where('rate_type', $_POST['rate_type'])->where('idx', $idx)->first();

                    $data_tmp->idx = $data->idx;
                    $data->idx = $idx;
                    $data_tmp->save();
                }
                $data->save();

                break;
        }
    }
}
