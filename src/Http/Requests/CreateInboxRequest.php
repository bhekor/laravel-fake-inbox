<?php

namespace YourVendor\FakeInbox\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInboxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'forwarding_enabled' => 'sometimes|boolean',
            'max_emails' => 'sometimes|integer|min:1',
            'retention_days' => 'sometimes|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('fake-inbox::validation.inbox_name_required'),
        ];
    }
}