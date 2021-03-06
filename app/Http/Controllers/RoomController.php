<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreRoomPost;

use App\Models\Room;
use App\Models\Service;
use App\Models\Gender;
use App\Models\Characteristics;
use App\Models\Option;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{


  public function __construct()
  {
    $this->middleware('auth');
  }
  /**

   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    $room = Room::all();
    
    
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $genders = Gender::all();
    $services = Service::all();
    $characteristics = Characteristics::all();
    $types = RoomType::all();
    $options = Option::all();

    return view('Dashboard/Publication-create', compact(
      'genders',
      'services',
      'characteristics',
      'types',
      'options'
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRoomPost $request)
  {
    
    $room = Room::create($request->all());
    
    $room->services()->attach($request->services);
    $room->characteristics()->attach($request->characteristics);
    $room->options()->attach($request->options);

    if ($request->hasfile('file')) {
      $file = $request->file('file');
      $name = time() . $file->getClientOriginalName();
      $file->move(public_path().'/images/', $name);
      //\Storage::disk('local')->put($name, \File::get($file));

      $room->imagen = $name;
      $room->save();
    }

    return redirect('user/publication')->with('status', 'Publicación creada correctamente');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\room  $room
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\room  $room
   * @return \Illuminate\Http\Response
   */
  public function edit(room $room)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\room  $room
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, room $room)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\room  $room
   * @return \Illuminate\Http\Response
   */
  public function destroy(room $room)
  {
    //
  }
}
