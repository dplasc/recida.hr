# ReciDa (Atlas Laravel) — Category Taxonomy Audit

**Date:** 2026-02-22  
**Scope:** Read-only audit for Outscraper export alignment  
**No project files were modified.**

---

## SECTION A: Taxonomy System Overview

### Tables and Relations

| Entity | Table | Key Columns | Notes |
|--------|-------|-------------|-------|
| **Listing categories** | `categories` | `id`, `name`, `parent`, `type`, `type_id` (nullable) | Single table for all listing types |
| **Subcategories** | Same `categories` table | `parent` ≠ 0 → child of category | Hierarchical via `parent` |
| **Listings** | Multiple tables | `category` (FK to categories.id) | One category per listing |

### Listing Tables (per type)

| Type | Table | Category column | Active filter |
|------|-------|-----------------|---------------|
| Beauty | `beauty_listings` | `category` | `visibility = 'visible'` |
| Car | `car_listings` | `category` | `visibility = 'visible'` |
| Hotel | `hotel_listings` | `category` | `visibility = 'visible'` |
| Real Estate | `real_estate_listings` | `category` | `visibility = 'visible'` |
| Restaurant | `restaurant_listings` | `category` | `visibility = 'visible'` |
| Custom types | `custom_listings` | `category` | `visibility = 'visible'` AND `type = <slug>` |

### Categories Table Schema (from migration)

```php
// database/migrations/2024_05_29_062523_create_categories_table.php
id, name, parent (nullable string), type, timestamps
```

**Note:** `type_id` is used in `CategoryController::store_category` for custom types but may have been added by an update script. No `slug` column in base migration — categories are identified by `id`.

### Parent/Child (Subcategories)

- **Parent categories:** `parent = 0` or `parent = ''`
- **Subcategories:** `parent = <parent_category_id>`
- Used explicitly for **Car** (e.g. `frontend/car/home.blade.php` shows parent categories as filter buttons)
- Other types may use flat lists; subcategories still exist in DB

### Other Taxonomies (NOT used for public listing search)

| Taxonomy | Table | Purpose |
|----------|-------|---------|
| **Listing types** | `custom_types` | Top-level directory (hotel, car, beauty, real-estate, restaurant, custom slugs) |
| **Blog categories** | `blog_categories` | Blog posts only |
| **Inventory categories** | `inventory_categories` (model ref) | Product/menu categories within a listing (e.g. restaurant menu items) |
| **Amenities** | `amenities` | Car type, brand, model, etc. — filter attributes, not categories |

**Public search uses:** `categories` (filtered by `type` = listing type slug) + listing table `category` column.

---

## SECTION B: Code Discovery Summary

### Files and usage

| Location | Usage |
|----------|-------|
| `app/Models/Category.php` | Eloquent model (no relations defined) |
| `app/Http/Controllers/Admin/CategoryController.php` | CRUD for categories per type |
| `app/Http/Controllers/Frontend/FrontendController.php` | `ListingsFilter()` — filters by `category` param |
| `app/Http/Controllers/Admin/ListingController.php` | `$data['category'] = $request->category` on create/update |
| `resources/views/admin/categories/index.blade.php` | Lists categories with parent name |
| `resources/views/admin/categories/create.blade.php` | Parent dropdown (`parent = 0` for root) |
| `resources/views/frontend/beauty/sidebar_beauty.blade.php` | Category filter + count |
| `resources/views/frontend/car/sidebar_car.blade.php` | Category filter + count (visible only) |
| `resources/views/frontend/hotel/sidebar_hotel.blade.php` | Category filter + count (visible only) |
| `resources/views/frontend/index.blade.php` | Homepage search — category dropdown per type |

### How categories are loaded

- **DB:** `Category::where('type', $type)->get()` — no config arrays
- **Listing type** comes from `CustomType::slug` or static types: `hotel`, `car`, `beauty`, `real-estate`, `restaurant`

---

## SECTION C: SQL Queries (MariaDB)

Run these on your VPS to extract taxonomy and counts.

### A) All categories

```sql
-- Categories: id, name, slug (derived), type, parent, sort
-- Note: No slug column in schema; use id or derive from name if needed
SELECT 
    id,
    name,
    LOWER(REPLACE(REPLACE(TRIM(name), ' ', '-'), '''', '')) AS slug_derived,
    type,
    COALESCE(NULLIF(TRIM(parent), ''), '0') AS parent,
    created_at,
    updated_at
FROM categories
ORDER BY type, parent, id;
```

### B) Subcategories grouped by category

```sql
-- Parent categories (main)
SELECT 
    c.id,
    c.name,
    c.type,
    '0' AS parent,
    'parent' AS level
FROM categories c
WHERE COALESCE(NULLIF(TRIM(c.parent), ''), '0') = '0'
   OR c.parent IS NULL
ORDER BY c.type, c.id;

-- Subcategories (children)
SELECT 
    c.id,
    c.name,
    c.type,
    c.parent AS parent_id,
    p.name AS parent_name,
    'child' AS level
FROM categories c
LEFT JOIN categories p ON p.id = c.parent
WHERE COALESCE(NULLIF(TRIM(c.parent), ''), '0') != '0'
  AND c.parent IS NOT NULL
ORDER BY c.type, c.parent, c.id;
```

### C) Listing counts per category (active = visible)

```sql
-- Count active listings per category, per listing type
-- Defensive: handles visibility column (visibility = 'visible')
-- Run per table; union for full picture

-- Beauty
SELECT 
    'beauty' AS listing_type,
    c.id AS category_id,
    c.name AS category_name,
    c.type,
    COUNT(l.id) AS active_count
FROM categories c
LEFT JOIN beauty_listings l ON l.category = c.id 
    AND l.visibility = 'visible'
WHERE c.type = 'beauty'
GROUP BY c.id, c.name, c.type;

-- Car
SELECT 
    'car' AS listing_type,
    c.id AS category_id,
    c.name AS category_name,
    c.type,
    COUNT(l.id) AS active_count
FROM categories c
LEFT JOIN car_listings l ON l.category = c.id 
    AND l.visibility = 'visible'
WHERE c.type = 'car'
GROUP BY c.id, c.name, c.type;

-- Hotel
SELECT 
    'hotel' AS listing_type,
    c.id AS category_id,
    c.name AS category_name,
    c.type,
    COUNT(l.id) AS active_count
FROM categories c
LEFT JOIN hotel_listings l ON l.category = c.id 
    AND l.visibility = 'visible'
WHERE c.type = 'hotel'
GROUP BY c.id, c.name, c.type;

-- Real Estate
SELECT 
    'real-estate' AS listing_type,
    c.id AS category_id,
    c.name AS category_name,
    c.type,
    COUNT(l.id) AS active_count
FROM categories c
LEFT JOIN real_estate_listings l ON l.category = c.id 
    AND l.visibility = 'visible'
WHERE c.type = 'real-estate'
GROUP BY c.id, c.name, c.type;

-- Restaurant
SELECT 
    'restaurant' AS listing_type,
    c.id AS category_id,
    c.name AS category_name,
    c.type,
    COUNT(l.id) AS active_count
FROM categories c
LEFT JOIN restaurant_listings l ON l.category = c.id 
    AND l.visibility = 'visible'
WHERE c.type = 'restaurant'
GROUP BY c.id, c.name, c.type;

-- Custom types (one row per custom type slug in categories)
SELECT 
    c.type AS listing_type,
    c.id AS category_id,
    c.name AS category_name,
    c.type,
    COUNT(l.id) AS active_count
FROM categories c
LEFT JOIN custom_listings l ON l.category = c.id 
    AND l.visibility = 'visible'
    AND l.type = c.type
WHERE c.type NOT IN ('beauty', 'car', 'hotel', 'real-estate', 'restaurant')
GROUP BY c.id, c.name, c.type;
```

### D) Combined listing counts (simplified)

```sql
-- Single query: all categories with total active count across all listing tables
-- Use only if category column exists on all tables
SELECT 
    c.id,
    c.name,
    c.type,
    c.parent,
    COALESCE(beauty.cnt, 0) + COALESCE(car.cnt, 0) + COALESCE(hotel.cnt, 0) 
        + COALESCE(realestate.cnt, 0) + COALESCE(restaurant.cnt, 0) AS total_active
FROM categories c
LEFT JOIN (
    SELECT category, COUNT(*) AS cnt FROM beauty_listings 
    WHERE visibility = 'visible' GROUP BY category
) beauty ON beauty.category = c.id AND c.type = 'beauty'
LEFT JOIN (
    SELECT category, COUNT(*) AS cnt FROM car_listings 
    WHERE visibility = 'visible' GROUP BY category
) car ON car.category = c.id AND c.type = 'car'
LEFT JOIN (
    SELECT category, COUNT(*) AS cnt FROM hotel_listings 
    WHERE visibility = 'visible' GROUP BY category
) hotel ON hotel.category = c.id AND c.type = 'hotel'
LEFT JOIN (
    SELECT category, COUNT(*) AS cnt FROM real_estate_listings 
    WHERE visibility = 'visible' GROUP BY category
) realestate ON realestate.category = c.id AND c.type = 'real-estate'
LEFT JOIN (
    SELECT category, COUNT(*) AS cnt FROM restaurant_listings 
    WHERE visibility = 'visible' GROUP BY category
) restaurant ON restaurant.category = c.id AND c.type = 'restaurant'
ORDER BY c.type, c.parent, c.id;
```

**Note:** If `category` is missing on any table, that part of the query will fail. Check with:

```sql
SHOW COLUMNS FROM beauty_listings LIKE 'category';
SHOW COLUMNS FROM car_listings LIKE 'category';
-- etc.
```

---

## SECTION D: Category List (Template)

*Populate by running query A on your DB.*

| id | name | slug_derived | type | parent |
|----|------|--------------|------|--------|
| … | … | … | beauty | 0 |
| … | … | … | car | 0 |
| … | … | … | hotel | 0 |
| … | … | … | real-estate | 0 |
| … | … | … | restaurant | 0 |
| … | … | … | &lt;custom_slug&gt; | 0 |

---

## SECTION E: Subcategory List (Template)

*Populate by running query B on your DB.*

| id | name | type | parent_id | parent_name |
|----|------|------|-----------|-------------|
| … | … | car | 5 | Sedan |
| … | … | car | 5 | SUV |

---

## SECTION F: Listing Counts (Template)

*Populate by running query C on your DB.*

| listing_type | category_id | category_name | active_count |
|--------------|-------------|---------------|--------------|
| beauty | 1 | Salon | 12 |
| car | 2 | Sedan | 45 |
| … | … | … | … |

---

## SECTION G: Outscraper Mapping Strategy

### 1. Identifier

- **Primary key:** `categories.id`
- **Stable label:** `categories.name` + `categories.type`
- **Slug:** Not stored; derive with `slugify(name)` if needed (e.g. `strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim(name)))`)

### 2. Export column mapping

| Outscraper export field | ReciDa source |
|-------------------------|---------------|
| `category` or `category_name` | `categories.name` |
| `category_id` | `categories.id` |
| `listing_type` / `directory` | `categories.type` (hotel, car, beauty, real-estate, restaurant, custom slug) |
| `subcategory` | Child category name when `parent != 0` |

### 3. Matching rules

1. **By type first:** Map Outscraper “directory” or “listing type” to `categories.type`.
2. **By name:** Match `category_name` to `categories.name` within that type.
3. **By ID:** If Outscraper provides IDs, use `categories.id` directly.
4. **Subcategories:** If Outscraper has parent/child, use `parent` to distinguish main vs subcategory.

### 4. Custom types

- Custom types use `custom_types.slug` as `categories.type`.
- Listings live in `custom_listings` with `type = custom_types.slug`.
- Fetch active custom types: `CustomType::where('status', 1)->pluck('slug')`.

### 5. Active listing definition

- **Active:** `visibility = 'visible'`
- No `status`, `is_active`, or `is_published` on listing tables; only `visibility`.

---

## Appendix: Route and filter flow

- **Filter route:** `GET /listings-filter` → `FrontendController::ListingsFilter`
- **Query param:** `?type=beauty&category=5` (category = categories.id)
- **Homepage search:** Category dropdown uses `Category::where('type', $type)->get()`
- **Sidebar filters:** Same; category links use `category={{ $category->id }}`
