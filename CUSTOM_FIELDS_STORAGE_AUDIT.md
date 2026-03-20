# Audit: storage rupa u custom fields upload sustavu

**Datum:** 19. ožujka 2025  
**Kontekst:** Listing quota (100 MB PREMIUM) pokriva samo listing-images, floor-plan, og_image, 3d. Custom fields uploadi nisu uključeni.  
**Cilj:** Utvrditi može li PREMIUM zaobići 100 MB limit kroz custom fields i kako zatvoriti rupu.  
**Napomena:** Kod nije mijenjan; samo audit.

---

## 1. SAŽETAK

- **Rupa postoji:** PREMIUM korisnik **može** zaobići 100 MB limit kroz custom fields. Uploadi za **image**, **slider** i **gallery** idu u `uploads/custom-fields/`, bez ikakve provjere quota ili veličine. `getUserListingStorageUsage()` i `getUserImageLimits()` **ne** uključuju custom fields.
- **Entry pointi:** `AgentCustomFieldController::customField_store`, `customFieldUpdate`; `Admin\CustomFieldController::customField_store`, `customFieldUpdate`. Tipovi s file uploadom: **image**, **slider**, **gallery**. FAQ i video nemaju upload slika.
- **Validacija:** Nema mime, max size po fileu, max broja fileova niti ukupnog quota. Jedina provjera je pristup (PRO/Premium) preko `has_pro_subscription()` (Agent) odnosno Subscription check (Admin).
- **DB:** Tablica `custom_fields` ima `listing_type`, `listing_id`, `custom_type`, `custom_field` (JSON s putanjama). Nema `user_id`; vlasnik se može dohvatiti preko listinga (listing → user_id).
- **Zatvaranje rupe:** Proširiti `getUserListingStorageUsage()` na custom fields (po user_id preko listinga), uvesti poziv iste quota logike u oba custom field store/update endpointa prije `move()`.

---

## 2. ENTRY POINTI

| File | Klasa | Metoda | Tipovi s uploadom | Ruta (Agent) | Ruta (Admin) |
|------|--------|--------|--------------------|---------------|--------------|
| `app/Http/Controllers/Agent/AgentCustomFieldController.php` | AgentCustomFieldController | `customField_store` | image, slider, gallery | POST `agent/custom-field/store` | — |
| `app/Http/Controllers/Agent/AgentCustomFieldController.php` | AgentCustomFieldController | `customFieldUpdate` | image, slider, gallery | POST `agent/custom-field/update/{field_id}/{item_id}` | — |
| `app/Http/Controllers/Admin/CustomFieldController.php` | CustomFieldController | `customField_store` | image, slider, gallery | — | POST `admin/custom-field/store` |
| `app/Http/Controllers/Admin/CustomFieldController.php` | CustomFieldController | `customFieldUpdate` | image, slider, gallery | — | POST `admin/custom-field/update/{field_id}/{item_id}` |

- **customField_Create / customFieldEdit / customFieldDelete / customSectionEdit / customSectionUpdate / customSectionDelete / sectionSorting / SectionSortUpdate** — ne uploadaju nove fileove (delete briše file s diska, ostalo samo CRUD na JSON/DB).
- **Carousel:** U kodu nema posebnog tipa "carousel"; prikaz slika u krug je **slider** (custom_type = slider).
- **FAQ:** Samo tekst (faq_question, faq_answer); nema file upload.
- **Video:** Samo URL; nema file upload.

---

## 3. GDJE SE SPREMAJU FILEOVI

| Odredište | Tip | Korištenje |
|-----------|-----|------------|
| `public_path('uploads/custom-fields')` | Direktorij | Svi custom field file uploadi (image, slider, gallery). |
| `$image->move(public_path('uploads/custom-fields'), $filename)` | Agent + Admin | `customField_store` za image_file, slider_images, gallery_images. |
| Isti path | Agent + Admin | `customFieldUpdate` pri zamjeni slike (image, slider, gallery). |
| `public_path('uploads/custom-fields/' . $item['file'])` | Agent + Admin | Brisanje filea u `customFieldDelete` i u `customFieldUpdate` (stara slika pri zamjeni). |

- **Filename:** `time() . '_' . $image->getClientOriginalName()` — nema sanitizacije ekstenzije ili mime provjere.
- **Optimizacija:** Nema; koristi se samo `move()`, bez `FileUploader::uploadOptimized()`.

---

## 4. POSTOJEĆE VALIDACIJE

Za svaki entry point (store/update) i svaki tip (image / slider / gallery):

| Validacija | customField_store (Agent) | customField_store (Admin) | customFieldUpdate (Agent) | customFieldUpdate (Admin) |
|------------|---------------------------|----------------------------|----------------------------|----------------------------|
| **(a) Mime** | ❌ Nema | ❌ Nema | ❌ Nema | ❌ Nema |
| **(b) Max size po fileu** | ❌ Nema | ❌ Nema | ❌ Nema | ❌ Nema |
| **(c) Max broj fileova** | ❌ Nema | ❌ Nema | ❌ Nema (1 po itemu) | ❌ Nema |
| **(d) Ukupni quota po korisniku** | ❌ Nema | ❌ Nema | ❌ Nema | ❌ Nema |
| **(e) Provjera plana FREE vs PREMIUM** | ✅ `has_pro_subscription()` | ✅ Subscription + expire (role != 1) | ✅ `has_pro_subscription()` | ❌ Nema (admin role 1 zaobilazi) |

- **Agent:** Pristup ograničen na PRO (`has_pro_subscription()`). Ako je PRO, može neograničeno uploadati u `uploads/custom-fields` bez provjere veličine ili quota.
- **Admin:** U store-u provjera subscriptiona samo za non-admin (role != 1). Nema quota provjere ni za admina ni za agenta.
- **getUserImageLimits()** i **getUserListingStorageUsage()** se u custom field controllerima **ne koriste**.

---

## 5. POSTOJI LI RUPA

**A) Može li PREMIUM korisnik trenutno zaobići 100 MB limit kroz custom fields?**  
**Da.** Svi custom field uploadi (image, slider, gallery) idu u `uploads/custom-fields` i ne ulaze u `getUserListingStorageUsage()`. PREMIUM korisnik može ispuniti 100 MB na listing slikama, a zatim dodavati proizvoljno puno sadržaja kroz custom fields bez ikakvog ograničenja.

**B) Kroz koje točno tipove?**  
- **image** — da (polje `image_file[]`, sprema se u `uploads/custom-fields`).  
- **slider** — da (`slider_images[]`, isti folder).  
- **gallery** — da (`gallery_images[]`, isti folder).  
- **carousel** — u kodu ne postoji kao poseban tip; prikaz je kroz **slider**.  
- **faq** — ne (nema file upload).  
- **video** — ne (samo URL).  
- **text** — ne (nema file).

**C) Najmanji ispravan način zatvaranja bez velikog refaktora**  
- Uključiti custom fields storage u **isti** 100 MB quota (zajedno s listing images).  
- Koraci:  
  1) Proširiti **getUserListingStorageUsage($user_id)** da zbraja i fileove iz `custom_fields` koji pripadaju listingima tog usera (preko listing_type + listing_id → user_id).  
  2) U **customField_store** i **customFieldUpdate** (Agent i Admin), prije bilo kojeg `move()`, izračunati veličinu novih fileova, dohvatiti `$ownerId` s listinga (listing_type + listing_id), pozvati `getUserImageLimits($ownerId)` i provjeriti `getUserListingStorageUsage($ownerId) + $newFilesSize <= $quotaBytes`; ako ne, baciti ValidationException s jasnom porukom.  
  3) Opcionalno: dodati validaciju mime i max size po fileu (npr. kao za listing slike: image, max 5120 KB) radi sigurnosti i konzistentnosti.

---

## 6. DB STRUKTURA I VLASNIŠTVO

- **Tablica:** `custom_fields` (Laravel konvencija za model `CustomField`). Točna migracija nije u glavnom repozitoriju; iz koda slijedi:
  - **listing_type** — tip listinga (npr. beauty, car, real-estate, hotel, restaurant ili custom type slug).  
  - **listing_id** — ID listinga.  
  - **custom_type** — image | slider | gallery | text | video | faq.  
  - **custom_title** — naslov sekcije.  
  - **custom_field** — JSON; za image/slider/gallery sadrži niz objekata s `id`, `file` (filename), te title/description gdje ima smisla.  
  - **sorting** — redoslijed (koristi se u sectionSorting).

- **user_id:** U tablici **nema**; vlasnik se izvodi iz listinga: za dani `listing_type` i `listing_id` treba učitati odgovarajući listing model (npr. BeautyListing, CarListing, CustomListings, …) i uzeti `user_id`. Svi listing modeli imaju `user_id`.

- **Izračun storagea po korisniku iz DB:** Moguće. Algoritam: za svakog usera dohvatiti sve listinge (svi tipovi) po `user_id` → za svaki par (listing_type, listing_id) dohvatiti CustomField zapise → za svaki zapis s custom_type in (image, slider, gallery) parsirati `custom_field`->data i zbrojiti `filesize(uploads/custom-fields/{file})` za svaki `file`. To je upravo logika koju treba ugraditi u proširenu **getUserListingStorageUsage()** (ili u novi helper koji se onda koristi u njoj).

---

## 7. PREPORUČENA MINIMALNA IMPLEMENTACIJA

### 7.1 Koji helper dodati ili proširiti

- **Proširiti** `getUserListingStorageUsage($user_id)` u **`app/Helpers/common_helpers.php`**:
  - Zadržati postojeći izračun (listing-images, floor-plan, og_image, 3d).
  - **Dodati:** za dani `$user_id` pronaći sve listing ID-eve po tipu (BeautyListing, CarListing, HotelListing, RealEstateListing, RestaurantListing, CustomListings) gdje `user_id = $user_id`. Zatim za svaki par (listing_type, listing_id) dohvatiti CustomField zapise s `custom_type` in ['image','slider','gallery']. Za svaki zapis parsirati JSON `custom_field`->data; za svaki item koji ima ključ `file`, zbrajati `filesize(public_path('uploads/custom-fields/'. $file))` ako datoteka postoji.
  - Vratiti ukupan zbroj (listing + custom fields) u bajtovima.

- **Ne** praviti poseban quota za “samo custom fields”; koristiti **isti** 100 MB limit (getUserImageLimits() vraća jedan quota_bytes po planu). Tako custom fields + listing images zajedno ulaze u isti PREMIUM cap.

### 7.2 U kojim controller metodama provjeriti quota

- **Agent:**  
  - `AgentCustomFieldController::customField_store` — prije bilo kojeg `move()`, izračunati ukupnu veličinu novih fileova (image_file, slider_images, gallery_images), dohvatiti ownerId (vidi dolje), provjeriti quota.  
  - `AgentCustomFieldController::customFieldUpdate` — prije `move()` za novi file (image/slider/gallery), izračunati veličinu novog filea, dohvatiti ownerId, provjeriti quota (ukupna potrošnja + nova veličina ≤ quota).

- **Admin:**  
  - `CustomFieldController::customField_store` — ista logika kao Agent customField_store.  
  - `CustomFieldController::customFieldUpdate` — ista logika kao Agent customFieldUpdate.

### 7.3 Kako izračunati veličinu novih fileova

- U **customField_store:**  
  - Za `$request->file('image_file')` (ako postoji): zbrojiti `$file->getSize()` za sve elemente.  
  - Za `$request->file('slider_images')`: isto.  
  - Za `$request->file('gallery_images')`: isto.  
  - Ukupno: `$newFilesSize = sum(getSize())` za sve uploadane fileove u tom requestu.

- U **customFieldUpdate:**  
  - Samo ako se uploada novi file (image_file[0], slider_images[0] ili gallery_images[0]): `$newFilesSize = $newFile->getSize()`.  
  - Pri zamjeni slike stara se briše, pa se povećava samo za razliku (nova veličina minus stara); najjednostavnije je računati samo novu veličinu i koristiti postojeći `getUserListingStorageUsage()` koji će (nakon proširenja) već uračunati sve postojeće custom field fileove.

### 7.4 Kako povezati upload s owner/user računom

- U **customField_store:**  
  - Iz requesta: `listing_type` = `$request->input('type')`, `listing_id` = `$request->input('listing_id')`.  
  - Pomaknica: helper npr. `getListingOwnerId(string $listing_type, int $listing_id): ?int` koji prema `listing_type` odabere model (BeautyListing, CarListing, …), učita `Listing::where('id', $listing_id)->value('user_id')` i vrati `user_id`.  
  - Agent: `$ownerId = auth()->id()` ako su uvijek vlastiti listingovi; za konzistentnost i admin slučaj (admin uređuje tuđi listing) ipak dohvatiti ownerId iz listinga.

- U **customFieldUpdate:**  
  - Imate `$customField` (CustomField model) → `listing_type`, `listing_id`.  
  - Isti `getListingOwnerId($customField->listing_type, $customField->listing_id)` za `$ownerId`.

- Quota provjera: `$limits = getUserImageLimits($ownerId);` → `$quotaBytes = $limits['quota_bytes']`. `$usedBytes = getUserListingStorageUsage($ownerId);` (nakon što helper uključuje custom fields). Ako `$usedBytes + $newFilesSize > $quotaBytes`, baciti `ValidationException` s porukom sličnom listingu (npr. “Storage quota exceeded. Your plan allows 100MB total. You have used X MB.”).

### 7.5 Treba li brojati custom fields storage zajedno s listing storage ili odvojeno

- **Zajedno.** Jedan quota 100 MB (PREMIUM) za sve: listing images, floor plan, og_image, 3d **i** custom fields (image/slider/gallery).  
- Razlozi: minimalna promjena (samo proširiti postojeći helper i dodati provjeru u 4 metode), jedan jasni limit po korisniku, bez potrebe za novim planovima ili admin UI-om za odvojene limite.

---

## 8. KRATKA PROVJERA LISTE

- **getUserImageLimits()** — ne koristi se u custom field controllerima.  
- **getUserListingStorageUsage()** — ne uključuje custom fields; niti jedan controller ih ne koristi za quota.  
- **Subscriptions / has_pro_subscription** — koriste se samo za pristup (PRO/Premium), ne za quota ili veličinu.  
- **Bilo kakva quota provjera** — u custom field upload flowu **ne postoji**.

---

Kod nije mijenjan; ovo je samo audit i preporuka za minimalnu implementaciju.
