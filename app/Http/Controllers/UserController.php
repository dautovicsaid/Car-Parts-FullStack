<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Jobs\SendResetPasswordEmailJob;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Http\Services\UserService;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $canAction = $request->user()->role_id === Role::SUPER_ADMIN_ID;
        return Inertia::render('Users/Index', [
            'users' => $this->userService->index($request),
            'filters' => [
                'search' => $request->get('search'),
                'role' => $request->get('role'),
            ],
            'can' => [
                'create' => $canAction,
                'deactivate' => $canAction,
                'activate' => $canAction,
            ],
        ]);
    }


    /**
     * @return Response
     */
    public function create() : Response
    {
        return Inertia::render('Users/Create');
    }

    /**
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request) : RedirectResponse
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
        $link = config('app.url') . "/reset-password/" . $token . "?email=" . $user->email;
        dispatch(new SendResetPasswordEmailJob($user, $link, 'set'));

        return to_route('users.index')->with('success', 'User created successfully');

    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function updateStatus($id) : RedirectResponse
    {
        $this->userService->updateStatus($id);
        return back()->with('success', 'User status updated successfully');
    }
}
