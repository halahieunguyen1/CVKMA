<?php
namespace App\Http\Traits;
use App\Models\User;
trait UserTrait {
    public function index() {
        // Fetch all the students from the 'student' table.
        $student = User::all();
        return view('welcome')->with(compact('student'));
    }
}