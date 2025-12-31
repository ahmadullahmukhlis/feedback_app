<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'min:2', 'max:100'],
            'last_name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'min:2', 'max:100'],
            'roles' => ['required'],
        ];

        if ($this->isMethod('post')) {
            // For creating a new user
            $rules['password'] = ['required', Password::default()];
            $rules['confirm_password'] = ['required', 'same:password'];
            $rules['image'] = ['required', 'file', 'image', 'max:5000'];
            $rules['email'] =  ['unique:users,email'];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            if ($this->has('password') && $this->has('confirm_password')) {
                $rules['password'] = ['nullable', Password::default()];
                $rules['confirm_password'] = ['nullable', 'same:password'];
            }
            if($this->has('image')){
                $rules['image'] = ['nullable', 'file', 'image', 'max:5000'];
            }
            $rules['email'] = Rule::unique('users')->ignore($this->user);
            $rules['is_active'] = ['required'];
        }

        return $rules;
    }
    public function validated($key = null, $default = null)
    {
        $data = [
            ...$this->all(),
            'roles' => collect(json_decode($this->roles))->map(fn($data)=>$data->id),
            'image' => $this->image?asset('storage/'.$this->file('image')->store('users-profile', 'public')):$this->user->iamge,
        ];
        unset($data['confirm_password']);
        unset($data['_method']);
        return $data;
    }
}
