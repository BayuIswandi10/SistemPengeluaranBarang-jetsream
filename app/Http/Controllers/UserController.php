<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUser()
    {
        $users = User::select('nrp_karyawan', 'name')->get();
        return response()->json($users);
    }

}
