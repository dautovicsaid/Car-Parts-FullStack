<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class UserService
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return UserResource::collection(
            User::query()->with('role')
                ->withTrashed()
                ->search($request)
                ->when($request->role, function ($query) use ($request) {
                    $request->role === 'admin' ? $query->admin() : $query->user();
                })
                ->whereNot('role_id', 1)
                ->orderBy('id', 'desc')
                ->paginate()
                ->withQueryString()
        );
    }

    /**
     * @param $id
     * @return void
     */
    public function updateStatus($id): void
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->trashed() ? $user->restore() : $user->delete();
    }
}
