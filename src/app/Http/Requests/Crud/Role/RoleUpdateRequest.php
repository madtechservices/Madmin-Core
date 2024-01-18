<?php

namespace Madtechservices\MadminCore\app\Http\Requests\Crud\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'readable_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(config('permission.table_names.roles', 'roles'))->ignore($this->id),
            ],
        ];
    }
    
}
