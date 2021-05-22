<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Queans;
use App\Option;
use App\Req;
use App\User;
use App\Response;

class ResultController extends Controller
{
    public function view($id)
    {
        $event = Event::select('name', 'correctmark', 'wrongmark', 'isactive')->where('id', $id)->first()->toArray();
        if ($event['isactive'] == 0) {
            return back()->with(['msg' => 'You can view result of launched event only.', 'class' => 'alert-danger']);
        }
        $que = Queans::select('id')->where('eventid', $id)->get()->toArray();
        $que = array_column($que, 'id');

        $option = Option::select('id', 'iscorrect', 'queid')->whereIn('queid', $que)->get()->toArray();

        $response = Response::whereIn('queid', $que)->whereIn('queid', $que)->get()->toArray();

        $userid = array_unique(array_column($response, 'userid'));

        $user = User::select('id', 'name', 'admno', 'rollno')->whereIn('id', $userid)->get()->toArray();

        $correct = [];
        foreach ($que as $q) {
            $correct[$q] = [];
            foreach ($option as $o) {
                if ($o['queid'] == $q && $o['iscorrect'] == 1) {
                    array_push($correct[$q], $o['id']);
                }
            }
            sort($correct[$q]);
        }

        $result = [];
        $i = 0;
        foreach ($userid as $u) {
            $result[$i]['userid'] = $u;
            $result[$i]['marks'] = 0;
            $result[$i]['correct'] = 0;
            $result[$i]['wrong'] = 0;

            $k = array_search($u, array_column($user, 'id'));
            $result[$i]['name'] = $user[$k]['name'];
            $result[$i]['admno'] = $user[$k]['admno'];
            $result[$i]['rollno'] = $user[$k]['rollno'];

            $keys = array_keys(array_column($response, 'userid'), $u);
            foreach ($keys as $key) {
                $ans = explode(",", $response[$key]['ans']);
                sort($ans);
                $queid = $response[$key]['queid'];
                if ($correct[$queid] == $ans) {
                    $result[$i]['marks'] += $event['correctmark'];
                    $result[$i]['correct']++;
                } else {
                    $result[$i]['marks'] += $event['wrongmark'];
                    $result[$i]['wrong']++;
                }
            }

            $i++;
        }
        usort(
            $result,
            function ($a, $b) {
                return $b['marks'] - $a['marks'];
            }
        );

        return view('teacher.result', ['name' => $event['name'], 'result' => $result]);
    }

    public function score($id)
    {
        $event = Event::select('name', 'correctmark', 'wrongmark', 'isactive')->where('id', $id)->first()->toArray();
        if ($event['isactive'] == 0) {
            return back()->with(['msg' => 'You can view result of launched event only.', 'class' => 'alert-danger']);
        }
        $que = Queans::select('id')->where('eventid', $id)->get()->toArray();
        $que = array_column($que, 'id');

        $option = Option::select('id', 'iscorrect', 'queid')->whereIn('queid', $que)->get()->toArray();

        $response = Response::whereIn('queid', $que)->whereIn('queid', $que)->get()->toArray();

        $userid = array_unique(array_column($response, 'userid'));

        $user = User::select('id', 'name', 'admno', 'rollno')->whereIn('id', $userid)->get()->toArray();

        $correct = [];
        foreach ($que as $q) {
            $correct[$q] = [];
            foreach ($option as $o) {
                if ($o['queid'] == $q && $o['iscorrect'] == 1) {
                    array_push($correct[$q], $o['id']);
                }
            }
            sort($correct[$q]);
        }

        $result = [];
        $i = 0;
        foreach ($userid as $u) {
            $result[$i]['userid'] = $u;
            $result[$i]['marks'] = 0;
            $result[$i]['correct'] = 0;
            $result[$i]['wrong'] = 0;

            $k = array_search($u, array_column($user, 'id'));
            $result[$i]['name'] = $user[$k]['name'];
            $result[$i]['admno'] = $user[$k]['admno'];
            $result[$i]['rollno'] = $user[$k]['rollno'];

            $keys = array_keys(array_column($response, 'userid'), $u);
            foreach ($keys as $key) {
                $ans = explode(",", $response[$key]['ans']);
                sort($ans);
                $queid = $response[$key]['queid'];
                if ($correct[$queid] == $ans) {
                    $result[$i]['marks'] += $event['correctmark'];
                    $result[$i]['correct']++;
                } else {
                    $result[$i]['marks'] += $event['wrongmark'];
                    $result[$i]['wrong']++;
                }
            }

            $i++;
        }
        usort(
            $result,
            function ($a, $b) {
                return $b['marks'] - $a['marks'];
            }
        );

        return view('teacher.score', ['name' => $event['name'], 'result' => $result]);
    }
}
