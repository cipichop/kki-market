<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $result = $this->user()->id === $this->request->get('id') || $this->user()->role_id === 1;
        return $result;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->user()->role_id === 1){
            return [
                'username' => ['sometimes', 'string', 'max:255'],
                'email' => ['sometimes', 'string', 'email', 'max:255'],
                'newPassword' => ['nullable', 'string', 'min:8'],
                'newPasswordConfirm' => ['nullable', 'required_with:newPassword', 'string', 'same:newPassword'],
            ];
        }

        $rules = [
            'username' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255'],
            'currentPassword' => ['required', 'string'],
        ];

        if ($this->has('newPassword')) {
            $rules['newPassword'] = ['required', 'string', 'min:8'];
            $rules['newPasswordConfirm'] = ['required', 'string', 'same:newPassword'];
            $rules['currentPassword'] = ['required', 'string'];
        }

        return $rules;
    }
}
