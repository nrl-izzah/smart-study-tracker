<?php

namespace App\Http\Controllers;

use App\Mail\TaskCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\StudyTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // SHOW ALL TASKS + STREAK
    public function index()
    {
        $tasks = StudyTask::where('user_id', Auth::id())
            ->orderBy('deadline','asc')
            ->get();

        // ---- STREAK LOGIC ----
        $dates = StudyTask::where('user_id', Auth::id())
            ->where('status','completed')
            ->orderBy('updated_at','desc')
            ->pluck('updated_at')
            ->map(function($date){
                return $date->format('Y-m-d');
            })
            ->unique()
            ->toArray();

        $streak = 0;
        $today = now()->format('Y-m-d');

        foreach($dates as $date){
            if($date == $today || 
               $date == now()->subDays($streak)->format('Y-m-d')){
                $streak++;
            } else {
                break;
            }
        }

        return view('tasks.index', compact('tasks','streak'))
       ->with('calendarTasks', $tasks->groupBy('deadline'));
    }

    // SAVE NEW TASK
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        StudyTask::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'deadline' => $request->deadline,
            'status' => 'pending',
        ]);
        // SEND EMAIL NOTIFICATION
        Mail::to(Auth::user()->email)->send(new TaskCreatedMail(
            StudyTask::latest()->first()
        ));
        return redirect()->route('dashboard');
    }

    // MARK COMPLETE
    public function complete(StudyTask $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);

        $task->update(['status' => 'completed']);

        return redirect()->back();
    }

    // DELETE
    public function destroy(StudyTask $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);

        $task->delete();

        return redirect()->back();
    }

    // EDIT FORM
    public function edit(StudyTask $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);

        return view('tasks.edit', compact('task'));
    }

    // UPDATE
    public function update(Request $request, StudyTask $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index');
    }
}
