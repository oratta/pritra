<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutSetController extends Controller
{

    /**
     * @var User
     */
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if($this->__isRequestBestWorkoutSets($request)) return $this->indexBest();
    }

    protected function indexBest()
    {
        return $this->user->getBestWorkoutSets();
    }

    private function __isRequestBestWorkoutSets(Request $request)
    {
        $inputAll = $request->input();
        return key_exists('best', $inputAll);

    }
}
