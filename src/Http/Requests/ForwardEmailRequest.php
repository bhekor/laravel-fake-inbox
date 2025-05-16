<?php

namespace YourVendor\FakeInbox\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForwardEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'recipient' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'recipient.required' => trans('fake-inbox::validation.recipient_email_required'),
            'recipient.email' => trans('fake-inbox::validation.recipient_email_valid'),
        ];
    }
}