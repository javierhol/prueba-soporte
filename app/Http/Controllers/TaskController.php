<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index() {
        $task  = Task::with('user:id,email')->get();
        return response()->json( $task );

    }

    // Crear tarea

    public function store( Request $request )
 {
        $validated = $request->validate( [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'user' => 'required|max:500',
        ] );

        $task = new Task( $validated );
        $user = User::where( 'email', $validated[ 'user' ] )->first();
        $task->user_id = $user->id;
        $task->save();

        return response()->json( [ 'success' => 'Task added successfully.', 'task' => $task ], 200 );
    }

    // Actualizar tarea

    public function update( Request $request, $id )
 {

        $validated = $request->validate( [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
        ] );

        $task = Task::find( $id );

        if ( !$task ) {
            return response()->json( [ 'error' => 'Task not found.' ], 404 );
        }

        // Corrección: Se actualiza la tarea con datos validados.
        $task->update( array_merge( $validated, [ 'completed' => 1 ] ) );
        return response()->json( [ 'success' => 'Task updated successfully.' ], 200 );
    }

    // Eliminar tarea

    public function Filter( request $request ) {
        $completed = $request -> query( 'completed' );
        $query = Task::query();
        $query->where( 'completed', $completed );

        $tasks = $query->get();
        return response()->json( $tasks );
    }

    public function destroy( $id )
 {
        $task = Task::find( $id );
        if ( !$task ) {
            return response()->json( [ 'error' => 'Task not found.' ], 404 );
        }

        $task->delete();

        return response()->json( [ 'success' => 'Task deleted success.' ], 200 );
    }
}
