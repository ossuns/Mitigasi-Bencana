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

        $this->incomingRequest = new IncomingRequest();
        $this->incomingRequest->tag = $request->input('tag');
        $this->incomingRequest->data = $request->input('data');

        
    }

    public function show($tag) {
        return response()->json(app('redis')->lrange($tag, 0, -1));
    }
    public function add(Request $request) {
        $this->validation($request);
        return app('redis')->rpush($this->incomingRequest->tag, $this->incomingRequest->data);
    }
    public function delete($tag) {
        return app('redis')->del($tag);
    }
    public function backup() {
        
    }

    protected function validation($request) {
        $this->validate($request, [
            'tag' => 'required',
            'data' => 'required'
        ]);
    }
}
