<?php

namespace App\Http\Controllers;

class EventController extends Controller
{
  public function index($id)
  {
     return view('home');
  }
}
