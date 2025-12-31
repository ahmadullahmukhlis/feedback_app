<?php

namespace App\Http\Requests\UserManagement;

use App\Models\PermissionGroup;
use Illuminate\Foundation\Http\FormRequest;

class PermissionGroupRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'min:3', function($field, $value, $error){
                if(PermissionGroup::query()
                    ->where($field, $value)
                    ->where('permission_group_id', $this->request->get('permission_group_id'))
                    ->exists()){
                    $error('This name is already taken');
                }
            }],
            'icon' => ['string', 'nullable'],
            'permission_group_id' => ['required', 'int']
        ];
    }
}
