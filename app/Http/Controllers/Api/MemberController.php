<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Market;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        // মেম্বার লিস্ট কুয়েরি
        $members = Member::with('market')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->paginate(12);

        // ভিউতে থাকা ড্রপডাউন এর জন্য সব বাজার নিয়ে আসা
        $markets = Market::all();

        // স্ট্যাট কার্ডের জন্য একটি ডেমো কাউন্ট (ঐচ্ছিক)
        $active_markets_count = Market::has('members')->count();



        $members = Member::with('market')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('members.index', compact('members', 'search', 'markets', 'active_markets_count'));
    }

    public function create(): View
    {
        return view('members.create', [
            'markets' => Market::active()->orderBy('name')->get(),
            'member' => new Member,
        ]);
    }

    public function store(MemberRequest $request): RedirectResponse
    {
        // ১. ভ্যালিডেশন (MemberRequest এর মাধ্যমে অলরেডি হচ্ছে, তবে এখানে অতিরিক্ত চেক প্রয়োজন)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:members,phone',
            'market_id' => 'required|exists:markets,id',
        ]);

        // ২. মার্কেট চেক (ডাটা সেভ করার আগেই চেক করতে হবে)
        $existing = Member::where('market_id', $request->market_id)->first();
        if ($existing) {
            return back()
                ->withInput()
                ->with('error', 'এই বাজারে ইতিমধ্যে একজন সদস্য আছেন।') // সেশন এরর
                ->withErrors(['market_id' => 'এই বাজারে ইতিমধ্যে একজন সদস্য আছেন।']); // ফিল্ড এরর
        }

        // ৩. মেম্বার তৈরি
        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'সদস্য সফলভাবে যোগ করা হয়েছে! ✅');
    }

    public function edit(Member $member): View
    {
        return view('members.edit', [
            'member' => $member,
            'markets' => Market::active()->orderBy('name')->get(),
        ]);
    }

    public function update(MemberRequest $request, Member $member): RedirectResponse
    {
        // Check if another member already assigned to the new market
        $existing = Member::where('market_id', $request->market_id)
            ->where('id', '!=', $member->id)
            ->first();

        if ($existing) {
            return back()
                ->withInput()
                ->withErrors(['market_id' => 'এই বাজারে ইতিমধ্যে একজন সদস্য আছেন।']);
        }

        $member->update($request->validated());

        return redirect()
            ->route('members.index')
            ->with('success', 'সদস্যের তথ্য আপডেট হয়েছে! ✅');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'সদস্য মুছে ফেলা হয়েছে।');
    }
}
