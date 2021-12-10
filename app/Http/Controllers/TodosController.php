<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Todo::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodoRequest $request)
    {
        // define the data to be received and validate it
        $data = $request->validate([
            'title' => 'required',
            'completed' => 'required',
        ]);

        // store the data in the database. assign the data created to a variable because we want to return it once it is successful
        $todo = Todo::create($data);

        // return a json response
        // pass in in the todo and the status (201 is like a 200, but it means that the resource was created successfully)
        return response($todo, 201);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodoRequest  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        // define the data to be received and validate it
        $data = $request->validate([
            'title' => 'required',
            'completed' => 'required',
        ]);

        // update the data in the database
        $todo->update($data);

        // return a json response
        // pass in in the todo and the status
        return response($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response('Deleted todo item', 200);
    }
}
