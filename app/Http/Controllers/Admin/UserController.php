<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Resources\users\UserAdminBasicResource;
use App\Http\Resources\users\UserAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function authUserComponents(Request $request)
    {
        // Log::info($request->user()->components);
        return $request->user()
            ->components
            ->map(function ($item, $key) {
                return $item->id;
            });
    }

    public function users()
    {
        $users = $this->user
            ->orderBy('created_at', 'desc')
            ->get();

        return UserAdminBasicResource::collection($users);
    }

    public function user(Request $request, User $user)
    {
        return new UserAdminFullResource($user);
    }

    public function store(Request $request)
    {
        $validations = [
            'name' => 'bail|required|max:150|unique:users,name',
            'username' => 'bail|required|max:150|unique:users,username',
            'email' => 'bail|nullable|email|unique:users,email',
            'password' => 'bail|required|min:8',
            'retype_password' => 'bail|same:password'

        ];

        $errors = [
            'name.required' => 'Name is required.',
            'name.max' => 'Must be 150 characters or less.',
            'name.unique' => 'This name has already been taken.',
            'username.required' => 'Username is required.',
            'username.max' => 'Must be 150 characters or less.',
            'username.unique' => 'This username has already been taken.',
            'email.email' => 'Must be a valid email address.',
            'email.unique' => 'This email has already been used.',
            'password.required' => 'Password is required',
            'password.min' => 'Must be at least 8 characters',
            'retype_password.same' => 'Password does not match'
        ];

        $this->validate($request, $validations, $errors);

        do {
            $id = str_random(14);
            $user = $this->user->find($id);
        } while ($user);

        $this->user->create([
            'id' => $id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_by' => $request->user()->id
        ]);
    }

    public function rename(Request $request, User $user)
    {
        $validations = [
            'name' => "bail|required|max:150|unique:users,name,$user->id,id",
            'username' => "bail|required|max:150|unique:users,username,$user->id,id",
            'email' => "bail|nullable|email|unique:users,email,$user->id,id"

        ];

        $errors = [
            'name.required' => 'Name is required.',
            'name.max' => 'Must be 150 characters or less.',
            'name.unique' => 'This name has already been taken.',
            'username.required' => 'Username is required.',
            'username.max' => 'Must be 150 characters or less.',
            'username.unique' => 'This username has already been taken.',
            'email.email' => 'Must be a valid email address.',
            'email.unique' => 'This email has already been used.'
        ];

        $this->validate($request, $validations, $errors);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request, User $user)
    {
        $validations = [
            'password' => 'bail|required|min:8',
            'retype_password' => 'bail|same:password'

        ];

        $errors = [
            'password.required' => 'New password is required',
            'password.min' => 'Must be at least 8 characters',
            'retype_password.same' => 'Password does not match'
        ];

        $this->validate($request, $validations, $errors);

        $user->update([
            'password' => bcrypt($request->password),
        ]);
    }

    public function assignUserComponents(Request $request, User $user)
    {
        $user->components()->sync($request->userComponents);
    }

    public function destroy(User $user)
    {
        $user->delete();
    }

}
