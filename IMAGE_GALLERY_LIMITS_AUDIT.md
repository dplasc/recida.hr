# Tehnički audit: limiti za slike i galerije (PREMIUM korisnici)

**Datum:** 19. ožujka 2025  
**Scope:** upload slika, galerije, storage, subscription/pricing, custom fields (gallery/slider).  
**Napomena:** Kod nije mijenjan; samo audit.

---

## 1. SAŽETAK

- **Listing galerija (glavne slike oglasa):** Postoji **plan-based limit** — broj slika po oglasu (3 FREE / 30 PREMIUM) i **ukupni storage po korisniku** (20 MB FREE / 300 MB PREMIUM). Provjera je u `App\Http\Controllers\Admin\ListingController` (koristi se i za admin i za agent rute). Pojedinačna slika: max **5 MB** (5120 KB), mimes: jpeg, jpg, png, gif, webp.
- **Floor plan, og_image, 3d model:** Uračunati u isti korisnički quota; floor plan broj: 2 (FREE) / 10 (PREMIUM).
- **Room slike (hotel sobe), Menu slike, Custom fields (image/slider/gallery):** **Nema** limita broja ili ukupnog storagea; nisu uključeni u `getUserListingStorageUsage()`.
- **Infrastruktura (php.ini, nginx, post_max_size):** U repozitoriju **nije pronađeno**; ovisi o serveru.
- **Zaključak:** **C) Postoji plan-based limit** za listing galeriju i ukupni storage, ali samo za “listing” storage (listing-images, floor-plan, og_image, 3d). PREMIUM trenutno ima **300 MB** (ne 100 MB). Room, menu i custom-fields uploadi nemaju storage/kvota kontrolu.

---

## 2. PRONAĐENI FILEOVI

| Kategorija | File path | Opis |
|------------|-----------|------|
| **Controller – listing slike** | `app/Http/Controllers/Admin/ListingController.php` | `listing_store`, `listing_update`, `getListingImageFiles`, `listing_image_delete`, `listing_floor_image_delete`; koristi `getUserImageLimits`, `getUserListingStorageUsage`, `getUserPlanKey`. Isti controller za admin i agent (routes: `admin.listing.store` / `user.listing.store`). |
| **Helper – limiti i storage** | `app/Helpers/common_helpers.php` | `getUserPlanKey`, `getActivePricingForUser`, `getUserImageLimits`, `getUserListingStorageUsage`, `has_pro_subscription`. |
| **Upload / optimizacija** | `app/Models/FileUploader.php` | `uploadOptimized`, `uploadOptimizedLarge`; nema vlastitih business limitova (samo optimizacija/veličina po datoteci unutar poziva). |
| **Custom fields (slider/gallery/image)** | `app/Http/Controllers/Agent/AgentCustomFieldController.php` | `customField_store` – spremanje `image_file`, `slider_images`, `gallery_images` u `uploads/custom-fields`; **nema** validacije veličine/broja. |
| **Admin custom fields** | `app/Http/Controllers/Admin/CustomFieldController.php` | Isti tip uploada u `uploads/custom-fields`; **nema** validacije veličine/broja. |
| **Room / Menu slike** | `app/Http/Controllers/Admin/ListingController.php` | `listing_store_room`, `listing_update_room`, `listing_menu_store`, `listing_menu_update` – validacija samo po datoteci (npr. max:10 slika sobe, max:5120 KB po slici); **nema** korisničkog storage quota. |
| **Claim file** | `app/Http/Controllers/Frontend/FrontendController.php` | Validacija `file` za claim: mimes jpeg,jpg,png,pdf, max:4096 (KB). Nije galerija oglasa. |
| **Rute** | `routes/web.php`, `routes/agent.php` | Admin: `ListingController::listing_store`, `listing_update`. Agent: isti controller `ListingController::listing_store`, `listing_update` (`user.listing.store`, `user.listing.update`). |
| **Blade – input galerije** | `resources/views/user/agent/listing/*.blade.php` (real-estate, hotel, car, beauty, restaurant, custom_add, custom_edit) | `name="listing_image[]"` multiple, `data-max_length="20"` – samo UI hint; stvarni limit dolazi s backenda (3/30). |
| **Blade – script** | `resources/views/user/agent/listing/script.blade.php` | JS `maxFiles = data-max_length || 20` – ograničava broj odabranih datoteka u UI. |
| **Pricing** | `app/Models/Pricing.php`, migracija `create_pricings_table` | Model prazan; tablica: name, sub_title, price, icon, period, feature. **Nema** polja za max_images / storage_mb – limiti su u helperu. |

---

## 3. POSTOJEĆI LIMITI

### 3.1 Listing galerija (glavne slike oglasa) + floor plan + og_image

| Što | Gdje | Vrijednost | Tip limita |
|-----|------|------------|-------------|
| Broj slika po oglasu | `common_helpers.php` → `getUserImageLimits()` | FREE: 3, PREMIUM: 30 | e) po planu |
| Ukupni storage po korisniku | `common_helpers.php` → `getUserImageLimits()` | FREE: 20 MB, PREMIUM: **300 MB** | d) po korisniku / e) po planu |
| Provjera storagea pri uploadu | `ListingController::listing_store`, `listing_update` | `getUserListingStorageUsage($ownerId) + newFilesSize > $quotaBytes` → ValidationException | d) po korisniku |
| Max veličina **jedne** slike | `ListingController` validate | `listing_image.*` → `max:5120` (KB) = 5 MB | a) po slici |
| Mimes | Isto | jpeg, jpg, png, gif, webp | a) po slici |
| Max broj floor plan slika | `ListingController` (hardcoded) | FREE: 2, PREMIUM: 10 | e) po planu |
| Floor plan / og_image veličina | Isto | 5120 KB po datoteci | a) po slici |

**Što se uračunava u quota:**  
`getUserListingStorageUsage()` zbraja datoteke iz:  
`listing-images`, `floor-plan`, `og_image`, `uploads/og_image`, `uploads/3d` za sve listing modele (Beauty, Car, Hotel, RealEstate, Restaurant, CustomListings). Room, menu i custom-fields **nisu** uključeni.

### 3.2 Room slike (hotel sobe)

| Što | Gdje | Vrijednost | Tip limita |
|-----|------|------------|-------------|
| Broj slika po sobi | `ListingController::listing_store_room`, `listing_update_room` | max:10 (array) | c) po galeriji (sobi) |
| Veličina po slici | Isto | image.* max:5120 KB | a) po slici |
| Storage po korisniku / planu | — | **Nema** | — |

Spremanje: `uploads/room-images`, FileUploader::uploadOptimized.

### 3.3 Menu slike (restaurant)

| Što | Gdje | Vrijednost | Tip limita |
|-----|------|------------|-------------|
| Jedna slika po menu stavci | `listing_menu_store`, `listing_menu_update` | image max:5120 KB | a) po slici |
| Broj stavki / ukupni storage | — | **Nema** | — |

### 3.4 Custom fields (image / slider / gallery)

| Što | Gdje | Vrijednost | Tip limita |
|-----|------|------------|-------------|
| Pristup | `AgentCustomFieldController`, `has_pro_subscription()` | Samo PRO mogu koristiti custom field sekcije | e) po planu (feature flag) |
| Broj slika / veličina / storage | — | **Nema** validacije; direktan `move(public_path('uploads/custom-fields'))` | — |

### 3.5 Plan detection

- **getUserPlanKey($user_id):** `getActivePricingForUser` → ako `pricing->price >= 0.1` → `'premium'`, inače `'free'`. Koristi se za `getUserImageLimits` i floor plan cap.
- **getActivePricingForUser:** Subscription (status=1, expire_date > now) → Pricing po package_id.
- **has_pro_subscription:** pristup custom fields / “pro” značajkama; uvjet: price > 0 ili naziv sadrži “unlimited”.

---

## 4. ŠTO NEDOSTAJE

1. **Room images** – nisu u korisničkom quota; moguće neograničeno po broju soba i ukupnoj veličini.
2. **Menu images** – isto, nema ukupnog limita.
3. **Custom fields (image / slider / gallery)** – nema limita broja ili veličine; upload ide u `uploads/custom-fields` bez provjere quota.
4. **Pricing tablica** – nema kolona za `max_listing_images` ili `storage_mb`; limiti su hardcodirani u `getUserImageLimits()`.
5. **Infrastruktura** – u repozitoriju nema konfiguracije za `upload_max_filesize`, `post_max_size`, nginx `client_max_body_size`; to ovisi o serveru i može ograničiti upload prije Laravel validacije.
6. **UI vs backend** – blade koristi `data-max_length="20"` i JS ograničava na 20; stvarni backend limit je 3 ili 30. Ako želite dosljednost, treba limit u blade-u/JS-u dohvatiti dinamički (npr. iz session/backend).

---

## 5. PREPORUČENA IMPLEMENTACIJA ZA 100 MB PREMIUM LIMIT

Cilj: PREMIUM korisnik **maksimalno 100 MB ukupno** za galerije (listing + floor plan + og_image + 3d, kako danas računa `getUserListingStorageUsage`).

### Najmanji ispravan put

1. **Helper (jedno mjesto)**  
   - **File:** `app/Helpers/common_helpers.php`  
   - **Funkcija:** `getUserImageLimits()`.  
   - **Promjena:** za premium umjesto `300 * 1024 * 1024` postaviti `100 * 1024 * 1024` (100 MB).  
   - **Napomena:** Isti quota se već provjerava u `ListingController::listing_store` i `listing_update`; nema potrebe mijenjati controller ako se samo smanji quota u helperu.

2. **Opcionalno – konfigurabilno iz baze (dugoročno)**  
   - **DB:** dodati na `pricings` kolone npr. `max_listing_images` (nullable int), `storage_mb` (nullable int).  
   - **Helper:** u `getUserImageLimits()` učitati te vrijednosti iz Pricing modela za aktivni paket; fallback na trenutne hardcodirane vrijednosti (3/20 za free, 30/100 za premium).  
   - **Admin UI:** u formi za uređivanje paketa (pricing) dodati polja za te limite.

3. **Controller**  
   - Nije obavezno za sam 100 MB limit: validacija i quota provjera već postoje u `ListingController`. Potrebno je samo da `getUserImageLimits()` vraća 100 MB za premium.

4. **Infrastruktura**  
   - Na serveru provjeriti da `upload_max_filesize` i `post_max_size` (PHP) te eventualno `client_max_body_size` (nginx) dopuštaju barem jedan upload koji može biti i do ~5 MB po slici i više slika u jednom requestu (npr. 30 × 5 MB). Ako želite stroži cap po requestu, to se može dodati u Laravel (npr. max ukupna veličina requesta za `listing_image`), ali za sam “100 MB po korisniku” nije nužno.

5. **Custom fields / room / menu**  
   - Ako želite da 100 MB obuhvaća i custom-fields ili room/menu slike, tada treba:  
     - proširiti `getUserListingStorageUsage()` na `uploads/custom-fields`, `uploads/room-images`, `uploads/menu` (po user_id kroz listing_id), i  
     - u AgentCustomFieldController (i eventualno Admin CustomFieldController) te u room/menu akcijama pozivati istu quota logiku prije spremanja.  
   - Za “samo 100 MB za galerije” u trenutnom smislu (listing + floor + og + 3d) dovoljna je promjena u `getUserImageLimits()` na 100 MB za premium.

---

## 6. ZAKLJUČAK (točke 6 i 7 iz zahtjeva)

- **Odgovor na pitanje 6:**  
  **C) Postoji plan-based limit** za broj slika po oglasu i za ukupni storage po korisniku, ali **samo** za listing galeriju (listing-images, floor-plan, og_image, 3d). Room, menu i custom-fields nemaju storage kontrolu. PREMIUM trenutno ima 300 MB; za 100 MB dovoljno je promijeniti konstantu u `getUserImageLimits()`.

- **Odgovor na pitanje 7 (najmanji put za 100 MB PREMIUM):**  
  Implementirati u **helperu** (`app/Helpers/common_helpers.php`, funkcija `getUserImageLimits`): za premium vratiti `quota_bytes => 100 * 1024 * 1024`. Opcionalno: DB razina (pricings.storage_mb) + admin UI za uređivanje paketa; controller i ostala logika mogu ostati kao sada.
