<?php

namespace App\Http\Requests\Configurations;

use App\Models\LanguageWord;
use Illuminate\Foundation\Http\FormRequest;

class LanguageWordRequest extends FormRequest
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
            'word' => ['required', 'string', 'min:1', function($field, $value, $error){
                $check = LanguageWord::query()
                    ->where($field, $value)
                    ->where('language_id', $this->language_id)
                    ->where('id', '!=', $this->id);
                if($check->exists()) $error('Word already exists');
            }],
            'translation' => ['required', 'string', 'min:1'],
            'language_id' => ['required']
        ];
    }
}
