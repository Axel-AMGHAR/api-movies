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
class MovieController extends Controller
{
    public function validateRequest($request)
    {
        $request->validate([
            'name' => 'required|max:128',
            'description' => 'required|max:2048',
            'date' => 'required|date',
            'note' => 'required|between:1,5',
            'categories_ids' => 'required|array',
            'categories_ids.*' => 'exists:App\Models\Category,id'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Movie::with('categories')->when(request()->has('name'), function ($query) {
            $query->where('name', 'like', '%'.request()->query('name').'%');
        })->when(request()->has('description'), function ($query) {
            $query->where('description', 'like', '%'.request()->query('description').'%');
        })->paginate(5);
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
        $movie = Movie::create($request->all());
        $movie->categories()->attach($request->input('categories_ids'));
        return $movie;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id Example: 1
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return Movie::with('categories')->find($id) ?? abort(404);
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
        $movie->categories()->sync($request->input('categories_ids'));
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
