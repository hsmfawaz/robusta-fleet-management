<?php

namespace App\Http\Controllers\Dashboard;

use App\Datatables\UserDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index(UserDatatable $datatable)
    {
        return $datatable->render('dashboard.users.index');
    }

    public function create()
    {
        return view('dashboard.users.form', ['model' => null]);
    }

    public function store(UserRequest $request)
    {
        User::create($request->validated());
        toast(__('User Created Successfully'), 'success');

        return redirect()->back();
    }

    public function edit(User $user)
    {
        return view('dashboard.users.form', ['model' => $user]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        toast(__('User Saved Successfully'), 'success');

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['status' => true]);
    }
}
