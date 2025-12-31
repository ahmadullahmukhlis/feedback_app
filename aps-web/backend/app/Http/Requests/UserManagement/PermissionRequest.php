<?php

namespace App\Http\Requests\UserManagement;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:100', function($field, $value, $error){
                if(Permission::query()->where('name', $value)->where('permission_group_id', $this->permission_group_id)->count()){
                    $error('This name is already taken');
                }
            }],
            'key' => ['nullable', function($value, $field, $error){
                if(Permission::query()->where('key', '=', str()->slug($value))->exists()) $error('This name is already taken');
            }],
            'permission_group_id' => ['required', 'int']
        ];
    }
    public function validated($key = null, $default = null)
    {
        return [
            ...$this->all(),
            'key' => str()->slug(PermissionGroup::find($this->permission_group_id)->name.' '.$this->name)
        ];
    }
}
