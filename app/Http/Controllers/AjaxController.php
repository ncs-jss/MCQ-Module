<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Req;
use Auth;

class AjaxController extends Controller
{
    public function eventReq(Request $request)
    {
        $req = Req::select('status')->where('userid', Auth::id())->where('eventid', $request->id)->first();
        return json_encode(['status'=> $req->status]);
    }

    public function eventReqs(Request $request)
    {
        $req = Req::join('user', 'req.userid', '=', 'user.id')
            ->select('userid', 'name', 'admno', 'rollno', 'status')
            ->where('eventid', $request->id)
            ->get()
            ->toArray();
        return json_encode($req);
    }
}
