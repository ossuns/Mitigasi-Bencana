<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\IncomingRequest;

class CollecterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $incomingRequest;

    public function __construct(Request $request)
    {
        //menerima request
        $this->incomingRequest = new IncomingRequest();
        $this->incomingRequest->tag = $request->input('tag');
        $this->incomingRequest->data = $request->input('data');
        
    }

    public function show($tag) {
        //ambil semua list dan tampilkan
        return response($this->stringToJson(app('redis')->lrange($tag,0,-1)))
            ->header('Content-Type', 'application/json');
    }
    public function showLatest($tag) {
        //ambil semua list dan tampilkan
        return response($this->stringToJson(app('redis')->lrange($tag,-1,-1)))
            ->header('Content-Type', 'application/json');
    }

    //method function tambah
    public function add(Request $request) {
        $this->validation($request);

        app('redis')->rpush($this->incomingRequest->tag, $this->getJson());
        return response($this->getJson(), 200);
    }

    //method function delete
    public function delete($tag) {
        return app('redis')->del($tag);
    }
    public function backup() {
        
    }

    private function validation($request) {
        $this->validate($request, [
            'tag' => 'required',
            'data' => 'required'
        ]);
    }

    private function getJson() {
        $arr = array();
            foreach($this->incomingRequest->data as $key => $value) {
                $arr[$key] = $value;
            }

        return json_encode($arr);
    }
    private function stringToJson($arr) {
        if(count($arr) > 0) {
            $str = '[';
            for($i = 0; $i < count($arr); $i++) {
                !($i == count($arr)-1) ? $str .= $arr[$i]."," : $str .= $arr[$i]."]" ;
            }
            return $str;
        } else return '[]';
    }
    
}
