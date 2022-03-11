<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

/**
 * @group Movies
 *
 * APIs for managing movies
 */
class MoviesController extends Controller
{
    public function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|max:128',
            'description' => 'required|max:2048',
            'date' => 'required|date',
            'note' => 'required|between:1,5'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Movie::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @bodyParam name string required Example: Star Wars
     * @bodyParam description string required Example: La guerre des étoiles
     * @bodyParam date date required Example: 10/02/1989
     * @bodyParam note smallInt required Example: 5
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        return Movie::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id Example: 1
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Movie::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @bodyParam name string required Example: Star Wars
     * @bodyParam description string required Example: La guerre des étoiles
     * @bodyParam date date required Example: 10/02/1989
     * @bodyParam note smallInt required Example: 5
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $movie = Movie::find($id);
        $movie->update($request->all());
        return $movie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Movie::find($id)
            ->delete();
    }
}
