<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'title' => 'required|string',
            'completed' => 'required|boolean',
        ]);

        // update the data in the database
        $todo->update($data);

        // return a json response
        // pass in in the todo and the status
        return response($todo, 200);
    }

    public function updateAll(Request $request)
    {
        // define the data to be received and validate it
        // in this case, to update the completed status of the task in the database based on whether the task is checked or not, we only need to pass in the completed status
        $data = $request->validate([
            'completed' => 'required|boolean',
        ]);

        // this is how you do a bulk update in Laravel
        Todo::query()->update($data);

        return response('Updated', 200);
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

    public function destroyCompleted(Request $request)
    {
        // define the data to be received and validate it
        $request->validate([
            // we are passing in an array of id's that are checked so we can mass-delete the corresponding todos
            'todos' => 'required|array',
        ]);

        // bulk delete in Laravel by passing in the array to the destroy() method
        // in this case the array is the array of todos from the request
        Todo::destroy($request->todos);

        return response('Deleted', 200);
    }
}
