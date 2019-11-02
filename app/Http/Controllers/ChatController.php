<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $Messages = \App\Message::all();
        $Users = \App\User::all();
        return view('chat', compact('Messages', 'Users'));
    }

    public function postMessage(Request $req) {
        \App\Message::create(['message' => $req->message, 'user_name' => $req->user_name]);
    }
}
