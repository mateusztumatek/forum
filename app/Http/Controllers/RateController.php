<?php

namespace App\Http\Controllers;

use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class RateController extends Controller
{
    public function index(Request $request){
        $request->validate([
            'table' => 'required',
            'id' => 'required',
        ]);
        $rates = Rate::where('table', $request->table)->where('foreign_key', $request->id)->get();
        return response()->json($rates);
    }
    public function store(Request $request){
        if(!Auth::check()) throw new UnauthorizedException();
        $request->validate([
            'table' => 'required',
            'type' => 'required',
            'foreign_key' => 'required',
        ]);
        $request->request->set('user_id', Auth::id());
        Rate::where('table', $request->table)->where('user_id', $request->user()->id)->delete();
        $rate = Rate::create($request->all());
        $rates = Rate::where('table', $request->table)->where('foreign_key', $request->foreign_key)->get();
        return response()->json($rates);
    }
    public function destroy(Request $request, $id){
        $rate = Rate::find($id);
        if(!$rate) return response()->json(['message' => 'Nie znaleziono oceny'], 400);
        if(!Auth::check() || Auth::id() != $rate->user_id) throw new UnauthorizedException();
        $rate->delete();
        return response()->json(true);
    }
}
