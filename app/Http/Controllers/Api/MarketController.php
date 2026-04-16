<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketRequest;
use App\Models\Market;
use Illuminate\Http\RedirectResponse;
use App\Models\MarketDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Contracts\Filesystem\Filesystem;

class MarketController extends Controller
{
    public function index(Request $request): View
    {
        $division = $request->get('division');
        $search = $request->get('search');

        $markets = Market::with(['member', 'prices' => fn($q) => $q->latest('date')->limit(1)])
            ->when($division, fn($q) => $q->byDivision($division))
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->withCount('prices')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('markets.index', [
            'markets' => $markets,
            'divisions' => Market::divisions(),
            'division' => $division,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('markets.create', [
            'divisions' => Market::divisions(),
            'weekdays' => Market::weekdays(),
            'market' => new Market,
        ]);
    }

    public function store(MarketRequest $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:markets',
            'division' => 'required',
            'off_days' => 'nullable|array',
            'opening_time' => 'nullable',
            'closing_time' => 'nullable',
        ]);

        Market::create([
            'name' => $validated['name'],
            'division' => $validated['division'],
            'off_days' => $validated['off_days'],
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
        ]);

        return redirect()
            ->route('markets.index')
            ->with('success', 'বাজার সফলভাবে যোগ করা হয়েছে! ✅');
    }

    public function show(Market $market): View
    {
        $market->load(['member', 'prices' => fn($q) => $q->latest('date')->take(10), 'documents']);

        return view('markets.show', ['market' => $market]);
    }

    public function edit(Market $market): View
    {
        return view('markets.edit', [
            'market' => $market,
            'divisions' => Market::divisions(),
            'weekdays' => Market::weekdays(),
        ]);
    }

    public function update(MarketRequest $request, Market $market): RedirectResponse
    {
        $market->update($request->validated());

        return redirect()
            ->route('markets.index')
            ->with('success', 'বাজারের তথ্য আপডেট হয়েছে! ✅');
    }

    public function destroy(Market $market): RedirectResponse
    {
        $market->delete();

        return redirect()
            ->route('markets.index')
            ->with('success', 'বাজার মুছে ফেলা হয়েছে।');
    }

    public function storeDocument(Request $request, Market $market)
    {
        $request->validate([
            'document' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('market_docs', 'public');

            $market->documents()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
            ]);

            return back()->with('success', 'ফাইলটি সফলভাবে আপলোড হয়েছে।');
        }

        return back()->with('error', 'কোন ফাইল পাওয়া যায়নি।');
    }

    public function downloadDocument($id)
    {
        $document = MarketDocument::findOrFail($id);

        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'ফাইলটি খুঁজে পাওয়া যায়নি!');
        }

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    /* * এই মেথডটি আগে দুইবার ছিল, এখন একবার রাখা হয়েছে।
     */
    public function destroyDocument($id)
    {
        $document = MarketDocument::findOrFail($id);

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'ফাইলটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}