<?php

namespace App\Http\Controllers;

class ArtistController extends Controller
{
  public function index($id)
  {
     return view('home');
  }
}
