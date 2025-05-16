<?php

namespace YourVendor\FakeInbox\Http\Controllers;

use Illuminate\Http\Request;
use YourVendor\FakeInbox\Models\Inbox;
use YourVendor\FakeInbox\Services\InboxManager;

class InboxController extends Controller
{
    protected InboxManager $inboxManager;

    public function __construct(InboxManager $inboxManager)
    {
        $this->inboxManager = $inboxManager;
    }

    public function index()
    {
        $inboxes = Inbox::where('user_id', auth()->id())->paginate(15);
        return view('fake-inbox::inboxes.index', compact('inboxes'));
    }

    public function create()
    {
        return view('fake-inbox::inboxes.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $inbox = $this->inboxManager->create($request->name, [
            'forwarding_enabled' => $request->has('forwarding_enabled')
        ]);

        return redirect()->route('fake-inbox.inboxes.show', $inbox->slug);
    }

    public function show($inboxId)
    {
        $inbox = $this->inboxManager->findByIdOrSlug($inboxId);
        return view('fake-inbox::emails.index', compact('inbox'));
    }

    public function edit($inboxId)
    {
        $inbox = $this->inboxManager->findByIdOrSlug($inboxId);
        return view('fake-inbox::inboxes.edit', compact('inbox'));
    }

    public function update(Request $request, $inboxId)
    {
        $inbox = $this->inboxManager->findByIdOrSlug($inboxId);

        $inbox->update([
            'name' => $request->name,
            'settings' => array_merge($inbox->settings, [
                'forwarding_enabled' => $request->has('forwarding_enabled')
            ])
        ]);

        return redirect()->route('fake-inbox.inboxes.index');
    }

    public function destroy($inboxId)
    {
        $inbox = $this->inboxManager->findByIdOrSlug($inboxId);
        $inbox->delete();
        return redirect()->route('fake-inbox.inboxes.index');
    }
}