<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingComment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->string('tab', 'all')->lower()->toString();

        $tabs = [
            'all' => 'All Listings',
            'advert' => 'Advert',
            'lost-found' => 'Lost & Found',
            'sale' => 'For Sale',
            'rental' => 'Rentals',
        ];

        if (! isset($tabs[$activeTab])) {
            $activeTab = 'all';
        }

        $filters = $this->normalizedListingFilters($request);

        $query = Listing::query()
            ->approved()
            ->withCount('comments')
            ->latest('published_at')
            ->latest('created_at');

        $query->when($activeTab === 'advert', fn ($q) => $q->where('type', 'advert'));
        $query->when($activeTab === 'lost-found', fn ($q) => $q->whereIn('type', ['lost', 'found']));
        $query->when($activeTab === 'sale', fn ($q) => $q->where('type', 'sale'));
        $query->when($activeTab === 'rental', fn ($q) => $q->where('type', 'rental'));

        if ($filters['q'] !== '') {
            $term = '%'.$this->escapeLike($filters['q']).'%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('location', 'like', $term);
            });
        }

        if ($filters['location'] !== '') {
            $query->where('location', 'like', '%'.$this->escapeLike($filters['location']).'%');
        }

        if ($filters['price_hint'] !== '') {
            $query->where('price', 'like', '%'.$this->escapeLike($filters['price_hint']).'%');
        }

        if ($filters['posted'] === 'today') {
            $query->whereRaw('COALESCE(published_at, created_at) >= ?', [now()->startOfDay()]);
        } elseif ($filters['posted'] === 'week') {
            $query->whereRaw('COALESCE(published_at, created_at) >= ?', [now()->subDays(7)]);
        }

        if ($filters['condition'] !== '') {
            $this->applyProductConditionFilter($query, $filters['condition'], $activeTab);
        }

        if ($filters['rental_period'] !== '') {
            $this->applyRentalPeriodFilter($query, $filters['rental_period'], $activeTab);
        }

        $listings = $query->paginate(12)->withQueryString()->through(function (Listing $item): array {
            $badgeMap = [
                'advert' => ['Advert', 'bg-black text-white'],
                'lost' => ['Lost', 'bg-red-600 text-white'],
                'found' => ['Found', 'bg-emerald-600 text-white'],
                'sale' => ['For Sale', 'bg-blue-600 text-white'],
                'rental' => ['For Rent', 'bg-amber-500 text-black'],
            ];

            [$badge, $badgeClass] = $badgeMap[$item->type] ?? ['Listing', 'bg-zinc-200 text-zinc-800'];

            return [
                'id' => $item->id,
                'type' => $item->type,
                'badge' => $badge,
                'badgeClass' => $badgeClass,
                'title' => $item->title,
                'price' => $item->price,
                'location' => $item->location ?? 'Not specified',
                'posted' => Carbon::parse($item->published_at ?? $item->created_at)->diffForHumans(),
                'image' => $item->primaryImage() ?? 'logo.png',
                'comments_count' => (int) $item->comments_count,
            ];
        });

        return view('pages.listings.index', [
            'tabs' => $tabs,
            'activeTab' => $activeTab,
            'filters' => $filters,
            'filterQuery' => $this->filterQueryForLinks($activeTab, $filters),
            'listings' => $listings,
        ]);
    }

    public function createLost()
    {
        return view('pages.listings.forms.lost');
    }

    public function createSale()
    {
        return view('pages.listings.forms.sale');
    }

    public function createRental()
    {
        return view('pages.listings.forms.rental');
    }

    public function createAdvert()
    {
        return view('pages.listings.forms.advert');
    }

    public function createFound()
    {
        return view('pages.listings.forms.found');
    }

    public function storeLost(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:4000'],
            'last_seen_location' => ['required', 'string', 'max:255'],
            'date_lost' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:4096'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_info' => ['required', 'string', 'max:255'],
            'reward' => ['nullable', 'string', 'max:255'],
        ]);

        Listing::create([
            'type' => 'lost',
            'title' => $validated['item_name'],
            'description' => $validated['description'],
            'price' => $validated['reward'] ?? null,
            'location' => $validated['last_seen_location'],
            'contact_name' => $validated['contact_name'],
            'contact_info' => $validated['contact_info'],
            'status' => 'pending',
            'images' => $this->storeSingleImage($request, 'image'),
            'details' => [
                'date_lost' => $validated['date_lost'],
                'reward' => $validated['reward'] ?? null,
            ],
        ]);

        return back()->with('success', 'Submitted. Your lost-item report is pending admin approval.');
    }

    public function storeSale(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', 'max:255'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'description' => ['required', 'string', 'max:4000'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_info' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
        ]);

        Listing::create([
            'type' => 'sale',
            'title' => $validated['product_name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'contact_name' => $validated['contact_name'],
            'contact_info' => $validated['contact_info'],
            'status' => 'pending',
            'images' => $this->storeMultipleImages($request, 'images'),
            'details' => [
                'category' => $validated['category'],
                'condition' => $validated['condition'],
            ],
        ]);

        return back()->with('success', 'Submitted. Your product listing is pending admin approval.');
    }

    public function storeRental(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'asset_name' => ['required', 'string', 'max:255'],
            'price_period' => ['required', 'string', 'max:255'],
            'availability' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'description' => ['required', 'string', 'max:4000'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_info' => ['required', 'string', 'max:255'],
        ]);

        Listing::create([
            'type' => 'rental',
            'title' => $validated['asset_name'],
            'description' => $validated['description'],
            'price' => $validated['price_period'],
            'location' => $validated['location'],
            'contact_name' => $validated['contact_name'],
            'contact_info' => $validated['contact_info'],
            'status' => 'pending',
            'images' => $this->storeMultipleImages($request, 'images'),
            'details' => [
                'availability' => $validated['availability'],
            ],
        ]);

        return back()->with('success', 'Submitted. Your rental listing is pending admin approval.');
    }

    public function storeAdvert(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'advert_title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:4000'],
            'location' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'string', 'max:255'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_info' => ['required', 'string', 'max:255'],
        ]);

        Listing::create([
            'type' => 'advert',
            'title' => $validated['advert_title'],
            'description' => $validated['description'],
            'price' => $validated['price'] ?? null,
            'location' => $validated['location'] ?? null,
            'contact_name' => $validated['contact_name'],
            'contact_info' => $validated['contact_info'],
            'status' => 'pending',
            'images' => $this->storeMultipleImages($request, 'images'),
            'details' => [],
        ]);

        return back()->with('success', 'Submitted. Your advert is pending admin approval.');
    }

    public function storeFound(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:4000'],
            'found_location' => ['required', 'string', 'max:255'],
            'date_found' => ['required', 'date'],
            'image' => ['nullable', 'image', 'max:4096'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_info' => ['required', 'string', 'max:255'],
        ]);

        Listing::create([
            'type' => 'found',
            'title' => $validated['item_name'],
            'description' => $validated['description'],
            'price' => null,
            'location' => $validated['found_location'],
            'contact_name' => $validated['contact_name'],
            'contact_info' => $validated['contact_info'],
            'status' => 'pending',
            'images' => $this->storeSingleImage($request, 'image'),
            'details' => [
                'date_found' => $validated['date_found'],
            ],
        ]);

        return back()->with('success', 'Submitted. Your found-item post is pending admin approval.');
    }

    public function show(Listing $listing)
    {
        abort_unless($listing->status === 'approved', 404);

        $listing->loadCount('comments');
        $listing->load('comments');

        $badgeMap = [
            'advert' => ['Advert', 'bg-black text-white'],
            'lost' => ['Lost', 'bg-red-600 text-white'],
            'found' => ['Found', 'bg-emerald-600 text-white'],
            'sale' => ['For Sale', 'bg-blue-600 text-white'],
            'rental' => ['For Rent', 'bg-amber-500 text-black'],
        ];

        [$badge, $badgeClass] = $badgeMap[$listing->type] ?? ['Listing', 'bg-zinc-200 text-zinc-800'];

        return view('pages.listings.show', [
            'listing' => $listing,
            'badge' => $badge,
            'badgeClass' => $badgeClass,
        ]);
    }

    public function storeComment(Request $request, Listing $listing): RedirectResponse
    {
        abort_unless($listing->status === 'approved', 404);

        $validated = $request->validate([
            'author_name' => ['required', 'string', 'max:120'],
            'author_contact' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $listing->comments()->create([
            'author_name' => $validated['author_name'],
            'author_contact' => $validated['author_contact'] ?? null,
            'body' => $validated['body'],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Thanks — your comment is visible on this listing.');
    }

    public function admin(Request $request)
    {
        $status = $request->string('status', 'pending')->toString();
        if (! in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $status = 'pending';
        }

        $items = Listing::query()
            ->where('status', $status)
            ->withCount('comments')
            ->latest()
            ->limit(100)
            ->get();

        return view('pages.listings.admin', [
            'status' => $status,
            'items' => $items,
        ]);
    }

    public function adminComments(Request $request)
    {
        $listingId = $request->filled('listing_id') ? $request->integer('listing_id') : null;

        $query = ListingComment::query()->with('listing')->latest();

        if ($listingId !== null && $listingId > 0) {
            $query->where('listing_id', $listingId);
        }

        $comments = $query->paginate(40)->withQueryString();

        $listingsForFilter = Listing::query()
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('pages.listings.admin-comments', [
            'comments' => $comments,
            'listingsForFilter' => $listingsForFilter,
            'filterListingId' => $listingId,
        ]);
    }

    public function approve(Request $request, Listing $listing): RedirectResponse
    {
        $listing->update([
            'status' => 'approved',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Listing approved and now public.');
    }

    public function reject(Request $request, Listing $listing): RedirectResponse
    {
        $listing->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Listing rejected.');
    }

    public function edit(Listing $listing)
    {
        $from = request()->string('from', '')->toString();
        if (! in_array($from, ['pending', 'approved', 'rejected'], true)) {
            $from = $listing->status;
        }

        return view('pages.listings.admin-edit', [
            'listing' => $listing,
            'adminStatus' => $from,
        ]);
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', Rule::in(['advert', 'lost', 'found', 'sale', 'rental'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:4000'],
            'price' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_info' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', Rule::in(['pending', 'approved', 'rejected'])],
            'from' => ['nullable', 'string', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        $publishedAt = $listing->published_at;
        if ($validated['status'] === 'approved') {
            $publishedAt = $publishedAt ?? now();
        } else {
            $publishedAt = null;
        }

        $listing->update([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'location' => $validated['location'] ?? null,
            'contact_name' => $validated['contact_name'] ?? null,
            'contact_info' => $validated['contact_info'] ?? null,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
        ]);

        $tab = in_array($validated['from'] ?? '', ['pending', 'approved', 'rejected'], true)
            ? $validated['from']
            : $validated['status'];

        return redirect()
            ->route('listings.admin', ['status' => $tab])
            ->with('success', 'Listing updated.');
    }

    public function destroy(Request $request, Listing $listing): RedirectResponse
    {
        $listing->delete();

        $tab = $request->string('from', 'approved')->toString();
        if (! in_array($tab, ['pending', 'approved', 'rejected'], true)) {
            $tab = 'approved';
        }

        return redirect()
            ->route('listings.admin', ['status' => $tab])
            ->with('success', 'Listing deleted.');
    }

    /**
     * @return array{q: string, location: string, price_hint: string, posted: string, condition: string, rental_period: string}
     */
    private function normalizedListingFilters(Request $request): array
    {
        $posted = $request->string('posted', '')->toString();
        if (! in_array($posted, ['', 'today', 'week'], true)) {
            $posted = '';
        }

        $condition = $request->string('condition', '')->toString();
        if (! in_array($condition, ['', 'new', 'used', 'refurbished'], true)) {
            $condition = '';
        }

        $rentalPeriod = $request->string('rental_period', '')->toString();
        if (! in_array($rentalPeriod, ['', 'day', 'week', 'month'], true)) {
            $rentalPeriod = '';
        }

        return [
            'q' => $request->string('q')->trim()->toString(),
            'location' => $request->string('location')->trim()->toString(),
            'price_hint' => $request->string('price_hint')->trim()->toString(),
            'posted' => $posted,
            'condition' => $condition,
            'rental_period' => $rentalPeriod,
        ];
    }

    /**
     * @param  Builder<Listing>  $query
     */
    private function applyProductConditionFilter($query, string $condition, string $activeTab): void
    {
        if ($activeTab === 'sale') {
            $query->where('details->condition', $condition);

            return;
        }

        $query->where(function ($w) use ($condition) {
            $w->where('type', '!=', 'sale')
                ->orWhere(function ($w2) use ($condition) {
                    $w2->where('type', 'sale')
                        ->where('details->condition', $condition);
                });
        });
    }

    /**
     * @param  Builder<Listing>  $query
     */
    private function applyRentalPeriodFilter($query, string $period, string $activeTab): void
    {
        $patterns = match ($period) {
            'day' => ['%/day%', '%per day%', '% daily%'],
            'week' => ['%/week%', '%per week%', '% weekly%'],
            'month' => ['%/month%', '%per month%', '% monthly%'],
            default => [],
        };

        if ($patterns === []) {
            return;
        }

        $matchPricePatterns = function ($q) use ($patterns): void {
            $q->where(function ($w) use ($patterns) {
                foreach ($patterns as $i => $pat) {
                    if ($i === 0) {
                        $w->where('price', 'like', $pat);
                    } else {
                        $w->orWhere('price', 'like', $pat);
                    }
                }
            });
        };

        if ($activeTab === 'rental') {
            $matchPricePatterns($query);

            return;
        }

        $query->where(function ($w) use ($matchPricePatterns) {
            $w->where('type', '!=', 'rental')
                ->orWhere(function ($w2) use ($matchPricePatterns) {
                    $w2->where('type', 'rental');
                    $matchPricePatterns($w2);
                });
        });
    }

    /**
     * @param  array{q: string, location: string, price_hint: string, posted: string, condition: string, rental_period: string}  $filters
     * @return array<string, string>
     */
    private function filterQueryForLinks(string $activeTab, array $filters): array
    {
        $query = ['tab' => $activeTab];
        foreach (['q', 'location', 'price_hint', 'posted', 'condition', 'rental_period'] as $key) {
            if (($filters[$key] ?? '') !== '') {
                $query[$key] = $filters[$key];
            }
        }

        return $query;
    }

    private function escapeLike(string $value): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $value);
    }

    private function storeSingleImage(Request $request, string $field): array
    {
        if (! $request->hasFile($field)) {
            return [];
        }

        $stored = $request->file($field)->store('listings', 'listing_images');

        return [$stored];
    }

    private function storeMultipleImages(Request $request, string $field): array
    {
        $paths = [];
        if (! $request->hasFile($field)) {
            return $paths;
        }

        foreach ((array) $request->file($field, []) as $file) {
            if (! $file) {
                continue;
            }
            $paths[] = $file->store('listings', 'listing_images');
        }

        return $paths;
    }
}
