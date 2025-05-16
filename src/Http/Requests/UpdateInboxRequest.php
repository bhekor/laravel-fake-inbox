<?php

namespace YourVendor\FakeInbox\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInboxRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'settings.forwarding_enabled' => 'sometimes|boolean',
            'settings.max_emails' => 'sometimes|integer|min:1',
            'settings.retention_days' => 'sometimes|integer|min:1',
        ];
    }
}