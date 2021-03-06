<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Lang;

class RateController extends Controller
{
    public function getTarget($id){
        if(\Auth::guest()){
            return redirect('/login');
        }
        else{
            return view('/rate/target', ['seq' => $id]);
        }
        return view('/rate/target', ['seq' => $id]);
    }
    public function getRate($id){
        if(\Auth::guest()){
            return redirect('/login');
        } else{
            return view('/rate/rate', ['target' => \App\Target::find($id)]);
        }
    }
    public function getView($id){
        return view('/rate/view', [
            'target' => \App\Target::find($id),
            'type' => DB::table('v_rate_main')->select('rate_type', 'name')->where('target_seq', $id)->groupBy('rate_type')->get(),
            'main' => DB::table('v_rate_main')->where('target_seq', $id)->get(),
            'score' => DB::table('v_rate_main')->where('target_seq', $id)->avg('rate_score')]);
    }

    public function getType($id){
        $data = \App\Rateitem::where('rate_type', $id)->orderBy('idx', 'ASC')->get();
        if($data->count() > 0)
        {
            return json_decode($data->toJson(), true);
        }
        else{
            return null;
        }
    }
    
    public  function postData($id){
        $scores = explode('|', $_POST['scores']);
        $items = explode('|', $_POST['items']);
        $rate_id = strtotime(date("Y-m-d H:i:s"));

        $main = \App\RateMain::where('user_seq', \Auth::user()->seq)
            ->where('target_seq', $_POST['target_seq'])
            ->where('rate_type', $id)->first();
        $score = null;

        if($main){
            \App\RateScore::where('target_seq', $_POST['target_seq'])->where('rate_id', $main->rate_id)->delete();
        }else{
            $main = new \App\RateMain;
            $main->target_seq = $_POST['target_seq'];
            $main->rate_id = $rate_id;
            $main->user_seq =  \Auth::user()->seq;
            $main->dt_create = date("Y-m-d H:i:s");
            $main->rate_type = $id;
        }
        $main->user_ip = $_SERVER['REMOTE_ADDR'];
        $main->rate_score = array_sum($scores)/count($scores);
        $main->knew_year = $_POST['year'];
        $main->comment = $_POST['comment'];
        $main->dt_update = date("Y-m-d H:i:s");
        $main->save();

        $idx = 0;
        foreach ($items as $item) {
            $score = new \App\RateScore;
            $score->target_seq = $_POST['target_seq'];
            $score->rate_id = $rate_id;
            $score->rate_item = $item;
            $score->score = $scores[$idx++];
            $score->save();
        }
    }

    public function postTarget($id){
        $target = null;
        if($id == -1){
            $target = new \App\Target;
            $target->dt_create = date("Y-m-d H:i:s");
        }else{
            $target = \App\Target::find($id);
        }
        $target->dt_update = date("Y-m-d H:i:s");
        $target->user_seq = \Auth::user()->seq;
        $target->user_ip = $_SERVER['REMOTE_ADDR'];
        $target->first_name = $_POST['first_name'];
        $target->last_name = $_POST['last_name'];
        $target->nick_name = $_POST['nick_name'];
        $target->photo = $_POST['photo'];
        $target->birth = $_POST['birth'];
        $target->gender = $_POST['gender'];
        $target->job = $_POST['job'];
        $target->locale = $_POST['locale'];
        $target->locale_cd = $_POST['locale_cd'];
        $target->country = $_POST['country'];
        $target->lat = $_POST['lat'];
        $target->lng = $_POST['lng'];
        $target->save();

        return $target->seq;
    }



//    public function postSearch() {
//        $data = DB::table('v_target');
//        if($_POST['type'] != '')
//        {
//            $type = explode('|', $_POST['type']);
//            $data = $data->where('rate_type', $type[0]);
//            if(count($type)>0)
//            {
//                for($i=1; $i<count($type); $i++){
//                    $data = $data->orWhere('rate_type', $type[$i]);
//                }
//            }
//        }
//
//        if($_POST['query2'] != '')
//        {
//            $data = $data->where(function($query){
//                return $query->Where('country', 'like', $_POST['query2']);
//            });
//        }
//
//
//        $data = $data->where(function($query){
//                    return $query->Where('first_name', 'like', $_POST['query1'])
//                        ->orWhere('last_name', 'like', $_POST['query1'])
//                        ->orWhere('nick_name', 'like', $_POST['query1'])
//                        ->orWhere('birth', 'like', $_POST['query1']);
//                });
//
//
//
//        if($data->count() > 0)
//        {
//            return $data->groupBy('seq')->get();
//        }
//        else{
//            return null;
//        }
//    }

    public function postSearch() {
        $res = $_POST['res'];
        $country = $_POST['country'];

        $data = DB::table('v_target');
        if($country != ''){
            $data = $data->where('country', $country);
        }

        switch ($_POST['typ']){
            case 'all':
                $data = $data->where(function($query){
                    $val = '%'.$_POST['val'].'%';
                    return $query->where('v_target.first_name', 'like', $val)
                        ->orWhere('v_target.last_name', 'like', $val)
                        ->orWhere('v_target.nick_name', 'like', $val)
                        ->orWhere('v_target.job', 'like', $val);
                });
                break;
            case 'name':
                $data = $data->where(function($query){
                    $val = '%'.$_POST['val'].'%';
                    return $query->where('v_target.first_name','like', $val)
                        ->orWhere('v_target.last_name','like', $val)
                        ->orWhere('v_target.nick_name','like', $val);
                });
                break;
            case 'job':
                $data = $data->where(function($query){
                    $val = '%'.$_POST['val'].'%';
                    return $query->where('v_target.job', 'like', $val);
                });
                break;
            default:
                $data = $data->where(function($query){
                    return $query->where('v_target.rate_type', $_POST['typ']);
                });
                $data = $data->where(function($query){
                    $val = '%'.$_POST['val'].'%';
                    return $query->where('v_target.first_name', 'like', $val)
                        ->orWhere('v_target.last_name', 'like', $val)
                        ->orWhere('v_target.nick_name', 'like', $val)
                        ->orWhere('v_target.job', 'like', $val);
                });
                break;
        }

        if($res == 'target'){
            return $data->get();
        } else if($res == 'reply') {
            $reply = $data
                    ->join('reply', 'reply.target_seq', '=', 'seq')
                    ->join('user', 'reply.user_seq', '=', 'user.seq');
            return $reply
                ->select('reply.comment', 'user.nick_name as u_nick', 'user.photo as u_photo',
                    'v_target.seq', 'v_target.nick_name as nick_name', 'v_target.photo as photo', 'v_target.name as name',
                    'v_target.lat', 'v_target.lng', 'v_target.score')
                ->get();
            //return $reply->get();
        } else {
            $val = '%'.$_POST['val'].'%';
            $writer = DB::table('target')
                      ->join('user', 'target.user_seq','=','user.seq')
                      ->where('target.first_name', 'like', $val)
                          ->orWhere('target.last_name', 'like', $val)
                          ->orWhere('target.nick_name', 'like', $val)
                          ->orWhere('target.job', 'like', $val);
            return $writer
                ->select('user.nick_name as u_nick', 'user.photo as u_photo',
                    'target.seq', 'target.nick_name as nick_name', 'target.photo as photo',
                    'target.lat', 'target.lng')
                ->get();
        }



    }

    public function postSearchall(){
        $val = '%'.$_POST['val'].'%';

        $nameTarget = DB::table('v_target')->where('first_name','like', $val)
                    ->orWhere('last_name','like', $val)
                    ->orWhere('nick_name','like', $val)->groupBy('seq')->get();
        $jobTarget = DB::table('v_target')->where('job', 'like', $val)->get();
        $nameUser = DB::table('user')->where('nick_name', 'like', $val)->get();
        $jobUser = DB::table('user')->where('job', 'like', $val)->get();
        $reply = DB::table('reply')
            ->select('target.seq', 'user.photo', 'user.nick_name', 'reply.comment', 'reply.create_dt')
            ->join('target', 'reply.target_seq', '=', 'target.seq')
            ->join('user', 'reply.user_seq', '=', 'user.seq')
            ->where('comment', 'like' ,$val)->get();

        return [$nameTarget, $jobTarget, $nameUser, $jobUser, $reply];
    }

    public function postSearchdetail(){
        $job = '%'.$_POST['job'].'%';
        $type = $_POST['type'];
        $birth = $_POST['birth'].'%';

        $target = DB::table('v_target')->Where('job', 'like', $job);
        if($type != '')
            $target = $target->Where('rate_type', $type);
        if($birth != '')
            $target = $target->Where('birth', 'like', $birth);
        $target = $target->where(function($query){
            $name = '%'.$_POST['name'].'%';
            return $query->where('first_name','like', $name)
                ->orWhere('last_name','like', $name)
                ->orWhere('nick_name','like', $name);
        });
        return $target->groupBy('seq')->get();
    }

    public function postSearchmap(){
        $target = DB::table('target')->where('country', $_POST['country'])->get();
        return $target;
    }

    public function getReply($id) {
        $reply = DB::table('reply')
            ->select('reply.id', 'user.photo','user.seq', 'user.nick_name', 'reply.comment', 'reply.update_dt')
            ->join('user', 'reply.user_seq', '=', 'user.seq')
            ->where('target_seq', $id)->orderBy('create_dt', 'desc')->get();

        return $reply;
    }
    public function postReply($id) {
        $data = null;

        if($id == -1){
            $data = new \App\Reply;
            $data->create_dt = date("Y-m-d H:i:s");
        } else {
            $data = \App\Reply::find($id);
        }
        $data->target_seq = $_POST['target_seq'];
        $data->user_seq = \Auth::user()->seq;
        $data->comment = $_POST['comment'];
        $data->user_ip = $_SERVER['REMOTE_ADDR'];
        $data->update_dt = date("Y-m-d H:i:s");
        $data->save();
    }

    public  function putReply($id){
        $data = \App\Reply::find($id);
        $data->delete();
    }

    public function getChart(){
        $data = DB::table('v_rate_score')
            ->select('name', 'score')
            ->where('target_seq', $_GET['target_seq'])->where('rate_id', $_GET['rate_id'])->get();
        return $data;
    }
}
