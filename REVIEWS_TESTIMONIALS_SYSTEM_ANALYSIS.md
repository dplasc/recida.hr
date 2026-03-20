# Reviews / Testimonials System — Full Codebase Analysis

## 1. LOCATION REFERENCE MAP

### Model
| Reference | File Path |
|-----------|-----------|
| Review model | `app/Models/Review.php` |

### Table
| Reference | File Path |
|-----------|-----------|
| reviews table schema | `public/assets/install.sql` (lines 2975-2986) |
| Migration | **MISSING** — no Laravel migration exists for `reviews` |

### Routes

**Frontend (public):**
| Route | Method | Controller::Method | Name |
|-------|--------|-------------------|------|
| `/listing-review/{id}` | POST | FrontendController::ListingReviews | listing.review |
| `/listing-review/update/{id}` | POST | FrontendController::ListingReviewsUpdate | listing.review.update |
| `/listing-review/reply/{id}` | POST | FrontendController::ListingReviewsReply | listing.review.reply |
| `/listing-review/edit/{id}` | GET | FrontendController::ListingReviewsEdit | listing.review.edit |
| `/listing/reviews/updated/{id}` | POST | FrontendController::ListingOwnReviewsUpdated | listing.reviews.updated |
| `/listing/reviews/delete/{id}` | GET | FrontendController::ListingOwnReviewsDelete | listing.review.delete |

**Admin (protected):**
| Route | Method | Controller::Method | Name |
|-------|--------|-------------------|------|
| `admin/user/review` | GET | SettingController::user_review_add | admin.review.create |
| `admin/user/review/stor` | POST | SettingController::user_review_stor | admin.review.store |
| `admin/user/review/edit/{id}` | GET | SettingController::review_edit | admin.review.edit |
| `admin/user/review/update/{id}` | POST | SettingController::review_update | admin.review.update |
| `admin/user/review/delete/{id}` | GET | SettingController::review_delete | admin.review.delete |

### Key terms used across codebase
- `review` — text content of a review
- `rating` — 1–5 stars
- `reply_id` — parent review ID (null for top-level reviews, set for replies)
- `listing_id` — listing the review belongs to (null for admin-created homepage testimonials)
- `user_review_count` / `user_review_count` — user's existing review for a listing
- `testimonial` — same data as reviews, filtered for homepage display

---

## 2. A) DATABASE STRUCTURE

### Table: `reviews`

| Column | Type | Nullable | Purpose |
|--------|------|----------|---------|
| `id` | int(11) | NO | Primary key |
| `user_id` | int(11) | YES | Reviewer (FK to users) |
| `listing_id` | int(11) | YES | Listing (null = homepage testimonial) |
| `agent_id` | int(11) | YES | Listing owner |
| `type` | varchar(255) | YES | Listing type (beauty, car, real-estate, hotel, restaurant, custom slug) |
| `reply_id` | int(11) | YES | Parent review ID (null = top-level) |
| `rating` | int(11) | YES | 1–5 stars |
| `review` | longtext | YES | Review text |
| `created_at` | timestamp | YES | |
| `updated_at` | timestamp | YES | |

### Columns that determine usage

| Usage | Filter criteria |
|-------|-----------------|
| **Homepage testimonials** | `reply_id IS NULL` AND `rating = 5` (from FrontendController::index) |
| **Listing reviews** | `listing_id = X` AND `reply_id IS NULL` AND `type = Y` |
| **Replies** | `reply_id = parent_review_id` |

### Moderation & soft delete
- **Soft delete:** None
- **Approval flag:** None (`is_approved` does not exist)
- **Foreign keys:** None in DB — only logical references to users and listings

---

## 2. B) ADMIN MANAGEMENT

### Admin routes related to reviews
- `admin.review.create` — Add review form (modal)
- `admin.review.store` — Store new review
- `admin.review.edit` — Edit form (modal)
- `admin.review.update` — Update review
- `admin.review.delete` — Delete review (hard delete)

### Controller methods

| Method | File | Behavior |
|--------|------|----------|
| `user_review_add()` | `app/Http/Controllers/Admin/SettingController.php:1426` | Returns `user_review_create` view |
| `user_review_stor()` | `app/Http/Controllers/Admin/SettingController.php:1430` | Creates review (user_id, rating, review) — **no listing_id/type, no is_approved** |
| `review_edit()` | `app/Http/Controllers/Admin/SettingController.php:1441` | Returns `user_review_edit` view |
| `review_update()` | `app/Http/Controllers/Admin/SettingController.php:1447` | Updates review, redirects to `admin.website.settings` |
| `review_delete()` | `app/Http/Controllers/Admin/SettingController.php:1456` | Hard delete |

### Blade files used
- `resources/views/admin/setting/user_review_create.blade.php` — Add form
- `resources/views/admin/setting/user_review_edit.blade.php` — Edit form
- `resources/views/admin/setting/user_review_list.blade.php` — **ORPHAN** — no route returns it

### Review list page
- **Broken / missing:** There is no `admin.review.index` route.
- `user_review_list.blade.php` exists and has Edit/Delete dropdowns and Add button, but it is never included or rendered.
- Admin sidebar has no link to Reviews.
- After `review_update`, redirect goes to `admin.website.settings`, not a reviews list.

### Delete / Edit
- Delete: works (hard delete) via `admin.review.delete`
- Edit: works via `admin.review.edit` (modal), `admin.review.update` (POST)
- List: not reachable — no index route and no sidebar link

---

## 2. C) FRONTEND RENDERING

### Homepage testimonials

| Location | Query |
|----------|-------|
| `resources/views/frontend/index.blade.php` (lines 1051–1095) | `Review::whereNull('reply_id')->where('rating', 5)->orderBy('created_at', 'DESC')->take(50)->get()` |

**Source:** `app/Http/Controllers/Frontend/FrontendController.php:57`

```php
$page_data['reviews'] = Review::whereNull('reply_id')->where('rating',5)->orderBy('created_at', 'DESC')->take(50)->get();
```

- Uses `$reviews->unique('user_id')` in Blade to dedupe by user
- No `is_approved` or `listing_id` filter — mixes listing reviews with admin testimonials
- Moderation filter: **none**

### Car home testimonials
- `resources/views/frontend/car/home.blade.php:84-86`
- Query: `Review::where('type', 'car')->whereNull('reply_id')->get()->unique('user_id')`
- No approval filter

### Listing reviews (by listing type)

| Blade file | Query pattern |
|------------|---------------|
| `details_.blade.php` (custom) | `Review::where('listing_id', $id)->where('type', $type)->where('reply_id', null)` |
| `details_real-estate.blade.php` | Same with `type = 'real-estate'` |
| `details_beauty.blade.php` | Same with `type = 'beauty'` |
| `details_car.blade.php` | Same with `type = 'car'` |
| `details_restaurant.blade.php` | Same with `type = 'restaurant'` |
| `details_hotel.blade.php` | Same with `type = 'hotel'` |

- Moderation filter: **none** — all reviews shown immediately

---

## 2. D) SECURITY & MODERATION RISK

| Risk | Status |
|------|--------|
| Reviews posted without approval | **Yes** — all reviews are public immediately |
| Reviews automatically public | **Yes** |
| Spam protection | **None** — no rate limit, CAPTCHA, or throttle |
| Rating validation | **Partial** — `required|integer` but no `in:1,2,3,4,5` |
| Authorization on edit/delete | **Broken** — `ListingOwnReviewsUpdated` and `ListingOwnReviewsDelete` do not check ownership; any authenticated user can edit/delete any review by ID |
| Typo bug in delete | `review::where` (lowercase) in `ListingOwnReviewsDelete` — may cause error (depends on PHP version) |

---

## 3. PROPOSED MODERATION SYSTEM

### 3.1 Design summary
- Add `is_approved` (boolean, default false)
- Add optional `deleted_at` (soft delete)
- Add `is_homepage_testimonial` (boolean) to separate homepage testimonials from listing reviews
- Admin approval panel with list, approve, reject, bulk delete
- Filter homepage and listing views by `is_approved`
- Fix authorization on user edit/delete
- Add bulk delete and optional spam protection

### 3.2 Database migration

**File:** `database/migrations/YYYY_MM_DD_HHMMSS_add_moderation_to_reviews_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('review');
            $table->boolean('is_homepage_testimonial')->default(false)->after('is_approved');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'is_homepage_testimonial', 'deleted_at']);
        });
    }
};
```

### 3.3 Model changes

**File:** `app/Models/Review.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'listing_id', 'agent_id', 'type', 'reply_id',
        'rating', 'review', 'is_approved', 'is_homepage_testimonial',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_homepage_testimonial' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeForHomepage($query)
    {
        return $query->whereNull('reply_id')
            ->where('is_approved', true)
            ->where('is_homepage_testimonial', true);
    }
}
```

### 3.4 Controller changes

**File:** `app/Http/Controllers/Admin/SettingController.php`

Add methods:

```php
public function review_index()
{
    $page_data['reviews'] = Review::with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(20);
    return view('admin.setting.user_review_list', $page_data);
}

public function review_approve($id)
{
    Review::where('id', $id)->update(['is_approved' => true]);
    Session::flash('success', get_phrase('Review approved!'));
    return redirect()->route('admin.review.index');
}

public function review_reject($id)
{
    Review::where('id', $id)->update(['is_approved' => false]);
    Session::flash('success', get_phrase('Review rejected!'));
    return redirect()->route('admin.review.index');
}

public function review_bulk_delete(Request $request)
{
    $ids = $request->input('ids', []);
    Review::whereIn('id', $ids)->delete();
    Session::flash('success', get_phrase('Reviews deleted!'));
    return redirect()->route('admin.review.index');
}
```

Update `user_review_stor` to set `is_approved => true` for admin-created reviews and `is_homepage_testimonial => true` when `listing_id` is null.

**File:** `app/Http/Controllers/Frontend/FrontendController.php`

- `index()`: change to `Review::forHomepage()->orderBy('created_at', 'DESC')->take(50)->get()` or equivalent approved-only logic.
- `ListingReviews()`: set `is_approved => false` (or per-setting) on create.
- `ListingOwnReviewsUpdated` / `ListingOwnReviewsDelete`: add `$review->user_id === auth()->id()` check (or similar policy).

**Bug fix in `ListingOwnReviewsDelete`:**

```php
Review::where('id', $id)->delete();  // was: review::where(...)
```

### 3.5 Route changes

**File:** `routes/web.php` (inside admin group)

```php
Route::get('user/review', [SettingController::class, 'review_index'])->name('admin.review.index');
Route::get('user/review/add', [SettingController::class, 'user_review_add'])->name('admin.review.create');
Route::get('user/review/approve/{id}', [SettingController::class, 'review_approve'])->name('admin.review.approve');
Route::get('user/review/reject/{id}', [SettingController::class, 'review_reject'])->name('admin.review.reject');
Route::post('user/review/bulk-delete', [SettingController::class, 'review_bulk_delete'])->name('admin.review.bulk-delete');
// Keep existing: store, edit, update, delete
```

### 3.6 Blade changes

**File:** `resources/views/frontend/index.blade.php`

Replace review query with approved-only scope (e.g. `Review::forHomepage()->...` or `approved()->whereNull('reply_id')->where('rating', 5)->...`).

**Listing detail blades (6 files):**

Add `->where('is_approved', true)` (or `approved()` scope) to all listing review queries, e.g.:

```php
$reviews = App\Models\Review::where('listing_id', $listing->id)
    ->where('type', $type)
    ->where('reply_id', null)
    ->approved()  // or ->where('is_approved', true)
    ->get();
```

**File:** `resources/views/admin/setting/user_review_list.blade.php`

- Change data source from `DB::table('reviews')` to `$reviews` from controller.
- Add columns: Status (approved/pending), Listing, Type.
- Add Approve / Reject buttons.
- Add checkbox column and “Bulk delete” form posting to `admin.review.bulk-delete`.

### 3.7 Admin sidebar

**File:** `resources/views/admin/navigation.blade.php`

Under Settings (or a new “Content” section), add:

```html
<li class="sidebar-second-li {{request()->is('admin/user/review*')?'active':''}}">
    <a href="{{route('admin.review.index')}}"> {{get_phrase('Reviews & Testimonials')}} </a>
</li>
```

---

## 4. EXACT FILE PATHS SUMMARY

| Action | File Path |
|--------|-----------|
| Migration | `database/migrations/YYYY_MM_DD_HHMMSS_add_moderation_to_reviews_table.php` |
| Model | `app/Models/Review.php` |
| Admin controller | `app/Http/Controllers/Admin/SettingController.php` |
| Frontend controller | `app/Http/Controllers/Frontend/FrontendController.php` |
| Routes | `routes/web.php` |
| Homepage testimonials | `resources/views/frontend/index.blade.php` |
| Admin list | `resources/views/admin/setting/user_review_list.blade.php` |
| Admin create | `resources/views/admin/setting/user_review_create.blade.php` |
| Admin edit | `resources/views/admin/setting/user_review_edit.blade.php` |
| Admin nav | `resources/views/admin/navigation.blade.php` |
| Listing details (custom) | `resources/views/frontend/custom-types/details_.blade.php` |
| Listing details (real-estate) | `resources/views/frontend/real-estate/details_real-estate.blade.php` |
| Listing details (beauty) | `resources/views/frontend/beauty/details_beauty.blade.php` |
| Listing details (car) | `resources/views/frontend/car/details_car.blade.php` |
| Listing details (restaurant) | `resources/views/frontend/restaurant/details_restaurant.blade.php` |
| Listing details (hotel) | `resources/views/frontend/hotel/details_hotel.blade.php` |
| Car home | `resources/views/frontend/car/home.blade.php` |

---

## 5. CRITICAL BUGS TO FIX IMMEDIATELY

1. **ListingOwnReviewsDelete** — typo: `review::where` → `Review::where`
2. **ListingOwnReviewsUpdated** — add ownership check: `$review->user_id !== auth()->id() && !auth()->user()->isAdmin()` → abort 403
3. **ListingOwnReviewsDelete** — add same ownership check
4. **ListingReviewsEdit** — add ownership or admin check before returning edit view
