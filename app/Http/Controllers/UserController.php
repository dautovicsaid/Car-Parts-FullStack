<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendResetPasswordEmailJob;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users' => UserResource::collection(User::query()->with('role')->admin()->search($request)->orderBy('id', 'desc')->paginate()),
            'filters' => [
                'search' => $request->get('search'),
            ],
            'can' => [
                'create' => $request->user()->role_id === Role::SUPER_ADMIN_ID,
                'delete' => $request->user()->role_id === Role::SUPER_ADMIN_ID,
            ],
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Users/Create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $token = Str::random(64);
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();   //brisanje starih neiskoristenih tokena
        DB::table('password_reset_tokens')
            ->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        $link = config('app.front_url') . "/reset-password?token=" . $token;
        dispatch(new SendResetPasswordEmailJob($user, $link, 'set'));

        return to_route('users.index')->with('success', 'User created successfully');

    }
}
