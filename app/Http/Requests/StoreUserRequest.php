<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'string', 'email', 'unique:users,email', 'min:3', 'max:50'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['role_id'] = Role::ADMIN_ID;
        $data['password'] = bcrypt(Str::random(49));
        return $data;
    }
}
