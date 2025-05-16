<?php

namespace YourVendor\FakeInbox\Http\Controllers;

use YourVendor\FakeInbox\Models\Inbox;
use YourVendor\FakeInbox\Models\InboxEmail;
use YourVendor\FakeInbox\Http\Requests\ForwardEmailRequest;

class InboxEmailController extends Controller
{
    /**
     * Display emails for an inbox
     *
     * @param Inbox $inbox
     * @return \Illuminate\View\View
     */
    public function index(Inbox $inbox)
    {
        $emails = $inbox->emails()
            ->latest()
            ->paginate(config('fake-inbox.ui.items_per_page'));

        return view('fake-inbox::emails.index', [
            'inbox' => $inbox,
            'emails' => $emails,
        ]);
    }

    /**
     * Display a single email
     *
     * @param Inbox $inbox
     * @param InboxEmail $email
     * @return \Illuminate\View\View
     */
    public function show(Inbox $inbox, InboxEmail $email)
    {
        $email->update(['read_at' => now()]);

        return view('fake-inbox::emails.show', [
            'inbox' => $inbox,
            'email' => $email,
        ]);
    }

    /**
     * Forward an email to a real address
     *
     * @param ForwardEmailRequest $request
     * @param Inbox $inbox
     * @param InboxEmail $email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forward(ForwardEmailRequest $request, Inbox $inbox, InboxEmail $email)
    {
        dispatch(new \YourVendor\FakeInbox\Jobs\ForwardEmail($email, $request->recipient));

        return back()->with('status', 'Email has been queued for forwarding');
    }
}