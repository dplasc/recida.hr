# Implementacijska mapa: zatvaranje storage rupe za custom fields

**Cilj:** Custom fields (image / slider / gallery) uračunati u isti user quota kao listing slike (FREE 20 MB, PREMIUM 100 MB).  
**Ne mijenjaj kod još** — samo priprema za implementaciju.

---

## 1. METODE

### 1.1 AgentCustomFieldController::customField_store

- **Request parametri:** `custom_type`, `type` (listing_type), `listing_id`, te ovisno o custom_type:  
  - image: `image_file[]`, `image_title[]`, `image_description[]`, `image_custom_title`  
  - slider: `slider_images[]`, `slider_title[]`, `slider_description[]`, `slider_custom_title`  
  - gallery: `gallery_images[]`, `gallery_custom_title`  
  - text: `text_content[]`, `text_custom_title`  
  - video: `video_url[]`, `video_custom_title`  
  - faq: `faq_question[]`, `faq_answer[]`, `faq_custom_title`
- **listing_type:** `$request->input('type')`.  
- **listing_id:** `$request->input('listing_id')`.  
- **Razlika image / slider / gallery:** `$custom_type = $request->custom_type` (string: `'image'`, `'slider'`, `'gallery'`).  
- **File input name-ovi:**  
  - image: `image_file` (array)  
  - slider: `slider_images` (array)  
  - gallery: `gallery_images` (array)  
- **move() točke:**  
  - image: unutar `if ($custom_type == 'image')` → `foreach ($request->file('image_file') as ...)` → **linija 49** `$image->move(public_path('uploads/custom-fields'), $filename);`  
  - slider: unutar `elseif ($custom_type == 'slider')` → `foreach ($request->file('slider_images') as ...)` → **linija 75**  
  - gallery: unutar `elseif ($custom_type == 'gallery')` → `foreach ($request->file('gallery_images') as ...)` → **linija 91**  
- **Najčišće mjesto za quota provjeru:** Na **početku** bloka koji obradjuje tipove s fileovima (prije bilo kojeg `if ($custom_type == 'image')`), nakon što imamo `$custom_type`, `$request->input('type')`, `$request->input('listing_id')`: izračunati `$newFilesSize` za sve uploadane fileove (image_file + slider_images + gallery_images), dohvatiti owner ID, provjeriti quota; ako prekoračenje, `throw ValidationException` i izaći. Alternativa: na samom ulazu u svaki od tri bloka (image / slider / gallery), prije `foreach` i prvog `move()` — ali to zahtijeva tri iste provjere; čišće je **jedna** provjera na početku, samo ako postoje fileovi u requestu.

---

### 1.2 AgentCustomFieldController::customFieldUpdate

- **Request parametri:** `field_id`, `item_id` (route); u body ovisno o tipu: image — `image_title[0]`, `image_description[0]`, `image_file[0]`; slider — `slider_title[0]`, `slider_description[0]`, `slider_images[0]`; gallery — `gallery_images[0]`; text/video/faq bez fileova.
- **listing_type / listing_id:** Nisu u requestu; iz modela: `$customField = CustomField::findOrFail($field_id)` → `$customField->listing_type`, `$customField->listing_id`.  
- **Razlika image / slider / gallery:** `$type = $customField->custom_type` (unutar loopa po `$fieldData['data']`, za item koji matcha `$item_id`).  
- **File input name-ovi:**  
  - image: `image_file[0]`  
  - slider: `slider_images[0]`  
  - gallery: `gallery_images[0]` (ili `$request->file('gallery_images')[0]`)  
- **move() točke:**  
  - image: **linija 241** `$newFile->move(public_path('uploads/custom-fields'), $filename);` (unutar `if ($newFile)`).  
  - slider: **linija 264**.  
  - gallery: **linija 291** `$newFiles[0]->move(...)`.  
- **Najčišće mjesto za quota provjeru:** Na početku metode, nakon `$customField = CustomField::findOrFail($field_id)`: izračunati ima li request novi file (image_file[0], slider_images[0] ili gallery_images[0]); ako da, `$newFilesSize = getSize()` tog filea, `$ownerId = getListingOwnerId($customField->listing_type, $customField->listing_id)`, provjera `getUserListingStorageUsage($ownerId) + $newFilesSize <= getUserImageLimits($ownerId)['quota_bytes']`; ako ne, ValidationException. To je **jedna** provjera prije ulaska u `foreach ($fieldData['data'] as $item)`.

---

### 1.3 Admin\CustomFieldController::customField_store

- **Request parametri:** Isti kao Agent `customField_store` (custom_type, type, listing_id, image_file / slider_images / gallery_images, te ostala polja po tipu).
- **listing_type:** `$request->input('type')`.  
- **listing_id:** `$request->input('listing_id')`.  
- **Razlika image / slider / gallery:** `$custom_type = $request->custom_type`.  
- **File input name-ovi:** `image_file`, `slider_images`, `gallery_images` (isti kao Agent).  
- **move() točke:** Iste logičke lokacije kao Agent store — **linije 50, 76, 92** (Admin file).  
- **Najčišće mjesto za quota provjeru:** Isto kao Agent store — jedna blok provjera na početku obrade (nakon Subscription checka), prije bilo kojeg `if ($custom_type == 'image')` koji radi s fileovima: izračunati `$newFilesSize`, dohvatiti owner preko `getListingOwnerId($request->input('type'), $request->input('listing_id'))`, provjera quota.

---

### 1.4 Admin\CustomFieldController::customFieldUpdate

- **Request parametri:** Kao Agent customFieldUpdate (field_id, item_id u route; u body image_file[0] / slider_images[0] / gallery_images[0] po tipu).
- **listing_type / listing_id:** Iz `$customField->listing_type`, `$customField->listing_id` (CustomField::findOrFail($field_id)).  
- **Razlika image / slider / gallery:** `$type = $customField->custom_type` unutar loopa.  
- **File input name-ovi:** Isti kao Agent update.  
- **move() točke:** **Linije 233, 256, 283** (Admin file).  
- **Najčišće mjesto za quota provjeru:** Kao Agent update — na početku, nakon `$customField = CustomField::findOrFail($field_id)`: ako postoji novi file u requestu, izračunati veličinu, dohvatiti ownerId, provjera quota prije ulaska u foreach.

---

## 2. FILE INPUTI I MOVE TOČKE

| Metoda | Tip | Request file key | Move točka (broj linije) |
|--------|-----|-------------------|---------------------------|
| Agent customField_store | image | `image_file` (array) | 49 |
| Agent customField_store | slider | `slider_images` (array) | 75 |
| Agent customField_store | gallery | `gallery_images` (array) | 91 |
| Agent customFieldUpdate | image | `image_file[0]` | 241 |
| Agent customFieldUpdate | slider | `slider_images[0]` | 264 |
| Agent customFieldUpdate | gallery | `gallery_images[0]` | 291 |
| Admin customField_store | image | `image_file` | 50 |
| Admin customField_store | slider | `slider_images` | 76 |
| Admin customField_store | gallery | `gallery_images` | 92 |
| Admin customFieldUpdate | image | `image_file[0]` | 233 |
| Admin customFieldUpdate | slider | `slider_images[0]` | 256 |
| Admin customFieldUpdate | gallery | `gallery_images[0]` | 283 |

**Mjesto za quota provjeru:**  
- **Store (Agent i Admin):** Jedna provjera na početku, nakon čitanja `custom_type`, `type`, `listing_id`, a **prije** prvog `if ($custom_type == 'image')` koji poziva `move()`. U provjeru uključiti sve tri niza: `image_file`, `slider_images`, `gallery_images`.  
- **Update (Agent i Admin):** Jedna provjera na početku, nakon `findOrFail($field_id)`, **prije** `foreach ($fieldData['data'] as $item)`. Računati samo veličinu novog filea (jedan file po requestu u updateu).

---

## 3. KAKO DOBITI OWNER ID

- U projektu **ne postoji** globalni helper tipa `getListingOwnerId($listingType, $listingId)`.  
- **ListingController** koristi privatnu metodu `getListingModel(string $type)` koja mapira type na model klasu; owner se dobiva kao `$listing->user_id` nakon učitavanja listinga.

**Prijedlog novog helpera** (npr. u `app/Helpers/common_helpers.php`):

```php
/**
 * Returns user_id (owner) of a listing by type and id.
 * Used for quota checks when uploading custom field files.
 *
 * @param string $listingType  e.g. 'beauty', 'car', 'hotel', 'real-estate', 'restaurant', or custom type slug
 * @param int $listingId
 * @return int|null  user_id or null if listing not found
 */
if (! function_exists('getListingOwnerId')) {
    function getListingOwnerId($listingType, $listingId) {
        $model = getListingModelClass($listingType);
        if (!$model) {
            return null;
        }
        $listing = $model::where('id', (int) $listingId)->first();
        return $listing ? (int) $listing->user_id : null;
    }
}

/**
 * Resolve listing model class by type slug (for use in helpers).
 */
if (! function_exists('getListingModelClass')) {
    function getListingModelClass(string $type): ?string {
        $map = [
            'car' => \App\Models\CarListing::class,
            'beauty' => \App\Models\BeautyListing::class,
            'hotel' => \App\Models\HotelListing::class,
            'real-estate' => \App\Models\RealEstateListing::class,
            'restaurant' => \App\Models\RestaurantListing::class,
        ];
        return $map[$type] ?? \App\Models\CustomListings::class;
    }
}
```

- U controllerima:  
  - **store:** `$ownerId = getListingOwnerId($request->input('type'), $request->input('listing_id'));`  
  - **update:** `$ownerId = getListingOwnerId($customField->listing_type, $customField->listing_id);`  
- Ako je `$ownerId === null`, odluka: ili tretirati kao error (listing nije pronađen), ili fallback na `auth()->id()` za Agent; za konzistentnost preporučuje se **ne** fallback-ati i vratiti 403/404 ili validation error.

---

## 4. KAKO PROŠIRITI STORAGE USAGE

### 4.1 Što getUserListingStorageUsage($user_id) trenutno broji

- Iterira po **listing modelima** (BeautyListing, CarListing, HotelListing, RealEstateListing, RestaurantListing, CustomListings).
- Za svaki model: sve listinge gdje `user_id = $user_id`.
- Za svaki listing: stupci `image`, `og_image`, te za RealEstate i `floor_plan`, `model`.
- **pathMap:**  
  - `image` → `uploads/listing-images`  
  - `floor_plan` → `uploads/floor-plan`  
  - `og_image` → `uploads/og_image`  
  - `model` → `uploads/3d`  
- Za `image` i `floor_plan` vrijednost je JSON niz imena fileova; za ostale jedan string (ime filea). Zbraja se `filesize($basePath . '/' . $path . '/' . $file)` za svaki postojeći file.
- **Ne broji:** room-images, menu, **custom_fields**.

### 4.2 Struktura koda (common_helpers.php, c. linije 579–629)

- Inicijalizacija `$total = 0`, `$basePath = public_path()`.
- `$listingModels` = mapa model → niz stupaca.
- `$pathMap` = mapa stupac → relativni path.
- Dva ugniježdena foreacha: po modelima, zatim po listingima tog usera, zatim po stupcima; za svaki stupac čita vrijednost, za JSON array iterira po elementima i zbraja filesize, inače jedan file.
- Na kraju `return $total`.

### 4.3 Gdje najčišće dodati brojanje custom_fields storagea

- **Nakon** postojeće petlje po listing modelima (nakon `}` koja zatvara unutarnji foreach po listingima), a **prije** `return $total`.
- Korak:  
  1) Za dani `$user_id` pronaći sve parove (listing_type, listing_id) koji mu pripadaju. To zahtijeva upite na sve listing modele (isti set kao gore) i skupljanje `['type' => ..., 'id' => ...]` (tip za CustomListings je iz polja `type` na modelu; za ostale modele tip je fiksni slug: beauty, car, hotel, real-estate, restaurant).  
  2) Za svaki takav par dohvatiti CustomField zapise: `CustomField::where('listing_type', $type)->where('listing_id', $id)->whereIn('custom_type', ['image','slider','gallery'])->get()`.  
  3) Za svaki CustomField parsirati `custom_field` (JSON) u array; za svaki element u `data` koji ima ključ `file`, provjeriti postoji li `$basePath . '/uploads/custom-fields/' . $item['file']` i zbrojiti `filesize()`.  
  4) Dodati taj zbroj u `$total`.

- **Napomena:** Da ne duplicirate mapu type → model, možete koristiti isti set modela kao u postojećoj petlji i za svaki model znati “type” (za BeautyListing = 'beauty', za CustomListings treba uzeti `$listing->type`). Alternativa: jedan helper koji vraća listu svih (listing_type, listing_id) za user_id (koristeći getListingModelClass), pa jedan upit CustomField::whereIn po (listing_type, listing_id) — ali CustomField ne podržava whereIn na dva stupca jednostavno; najjednostavnije je za svaki listing model iterirati po listingima usera i za svaki (type, id) učitati CustomField zapise i zbrojiti fileove.

---

## 5. JSON FORMAT CUSTOM FIELDS

- Polje u DB: `custom_fields.custom_field` (longText). Vrijednost je JSON string. Struktura: **uvijek** `{ "data": [ ... ] }`.  
- Svi tipovi koji imaju file koriste u elementima niza **ključ `file`** — vrijednost je ime filea (npr. `1234567890_original.jpg`) bez patha.

### 5.1 image

```json
{
  "data": [
    {
      "id": 1,
      "title": "Naslov slike",
      "description": "Opis",
      "file": "1731234567_photo.jpg"
    }
  ]
}
```

- Ime filea: `item['file']`. Path na disku: `uploads/custom-fields/{file}`.

### 5.2 slider

```json
{
  "data": [
    {
      "id": 1,
      "file": "1731234568_slide1.jpg",
      "title": "Slide naslov",
      "description": "Slide opis"
    }
  ]
}
```

- Ime filea: `item['file']`.

### 5.3 gallery

```json
{
  "data": [
    {
      "id": 1,
      "file": "1731234569_gallery1.jpg"
    }
  ]
}
```

- Ime filea: `item['file']`. Nema title/description u strukturi.

### 5.4 Konzistentnost

- Format je konzistentan: uvijek `data` niz; svaki element za image/slider/gallery ima **`file`**. Za brojanje storagea dovoljno je: `custom_type in ['image','slider','gallery']`, parsirati JSON, za svaki element u `data` s ključem `file` dodati `filesize(public_path('uploads/custom-fields/' . $item['file']))` ako datoteka postoji.

---

## 6. MINIMALNI PATCH PLAN

### Korak 1: Helper 1 — proširiti getUserListingStorageUsage

- **File:** `app/Helpers/common_helpers.php`.  
- **Lokacija:** Unutar funkcije `getUserListingStorageUsage`, nakon postojeće petlje koja zbraja listing images/floor_plan/og_image/model, a prije `return $total`.  
- **Promjena:** Dodati blok koji za dani `$user_id`:  
  - za svaki listing model (BeautyListing, CarListing, HotelListing, RealEstateListing, RestaurantListing, CustomListings) i njegov type slug,  
  - za sve listinge tog usera (po user_id),  
  - dohvati CustomField zapise za (listing_type, listing_id) s custom_type in ('image','slider','gallery'),  
  - za svaki zapis parsiraj `custom_field` JSON i za svaki item u `data` s ključem `file` zbroji filesize za `public_path('uploads/custom-fields/' . $file)` ako postoji.  
  - Dodaj taj zbroj u `$total`.  
- **Napomena:** Potreban je mapiranje model → listing_type (za CustomListings uzeti `$listing->type`, za ostale fiksni slug). Može se uvesti pomoćni `getListingModelClass()` i inverzna mapa type → model, te za svaki model iterirati listinge i za svaki (type, id) raditi CustomField + filesize.

### Korak 2: Helper 2 — novi helper getListingOwnerId (i opcionalno getListingModelClass)

- **File:** `app/Helpers/common_helpers.php` (npr. odmah iznad ili ispod `getUserListingStorageUsage`).  
- **Dodati:**  
  - `getListingModelClass(string $type): ?string` — vraća model klasu za type (car, beauty, hotel, real-estate, restaurant → odgovarajući model; default CustomListings::class).  
  - `getListingOwnerId($listingType, $listingId): ?int` — koristi getListingModelClass, učitava listing po id, vraća `user_id` ili null.  
- **Korištenje:** U custom field store/update u oba controllera za dohvat ownerId prije quota provjere.

### Korak 3: Controller patch točke

- **AgentCustomFieldController::customField_store**  
  - Nakon `$custom_type = $request->custom_type;` (i nakon PRO checka).  
  - Ako je `$custom_type` u `['image','slider','gallery']`, izračunati `$newFilesSize` kao zbroj getSize() za sve `$request->file('image_file')`, `$request->file('slider_images')`, `$request->file('gallery_images')` (samo one koji postoje i koji su UploadedFile).  
  - Ako `$newFilesSize > 0`: `$ownerId = getListingOwnerId($request->input('type'), $request->input('listing_id'));`; ako je null, odluka (npr. validation error “Listing not found”). Inače: `$limits = getUserImageLimits($ownerId);`; `$used = getUserListingStorageUsage($ownerId);`; ako `$used + $newFilesSize > $limits['quota_bytes']`, baciti `ValidationException` s porukom (vidi dolje).  
  - Ostaviti sve move() na istom mjestu.

- **AgentCustomFieldController::customFieldUpdate**  
  - Nakon `$customField = CustomField::findOrFail($field_id);` i učitavanja `$fieldData`.  
  - Odrediti ima li request novi file: za `$customField->custom_type === 'image'` provjeriti `$request->hasFile('image_file.0')` ili ekvivalent; za slider `slider_images.0`; za gallery `gallery_images.0`.  
  - Ako ima: `$newFile` = odgovarajući file, `$newFilesSize = $newFile->getSize()`. `$ownerId = getListingOwnerId($customField->listing_type, $customField->listing_id)`. Provjera quota; ako prekoračenje, ValidationException.  
  - Ostaviti move() na istom mjestu.

- **CustomFieldController::customField_store** (Admin)  
  - Ista logika kao Agent customField_store: nakon čitanja `custom_type` i Subscription checka, ako je tip image/slider/gallery, izračunati `$newFilesSize`, dohvatiti ownerId preko `getListingOwnerId($request->input('type'), $request->input('listing_id'))`, provjera quota prije bilo kojeg move().

- **CustomFieldController::customFieldUpdate** (Admin)  
  - Ista logika kao Agent customFieldUpdate: nakon findOrFail, ako postoji novi file u requestu, veličina + ownerId + quota provjera prije foreacha.

### Korak 4: Validation / error poruka

- Koristiti isti stil kao u ListingController:  
  `throw \Illuminate\Validation\ValidationException::withMessages([ 'image_file' => [ get_phrase('Storage quota exceeded. Your plan allows ') . $allowedMb . 'MB total. You have used ' . $usedMb . 'MB.' ] ]);`  
  (ili jedan generički key npr. `'custom_field'` ako ne želite vezati na image_file).  
- `$allowedMb = $limits['quota_bytes'] / (1024 * 1024);`  
- `$usedMb = round((getUserListingStorageUsage($ownerId) + $newFilesSize) / (1024 * 1024), 2);` za poruku (ili samo trenutni used bez + newFilesSize, po želji).  
- Ako owner nije pronađen: npr. `throw \Illuminate\Validation\ValidationException::withMessages([ 'listing_id' => [ get_phrase('Listing not found.') ] ]);` ili 404.

### Korak 5: Što testirati nakon deploya

1. **PREMIUM korisnik, ispod 100 MB (listing + custom fields zajedno):**  
   Dodavanje custom field slika (image / slider / gallery) dok ukupni storage ostane ispod 100 MB — očekivano: uspjeh.

2. **PREMIUM, prekoračenje 100 MB:**  
   Kada je ukupna potrošnja (listing + custom fields) na 100 MB ili više, sljedeći upload u custom fields — očekivano: validation error s porukom tipa “Storage quota exceeded. Your plan allows 100MB total. You have used X MB.”

3. **Agent store:**  
   Upload više slika u jednu custom field sekciju (image / slider / gallery) — provjera da se quota računa za zbroj svih novih fileova u jednom requestu.

4. **Agent i Admin update:**  
   Zamjena jedne slike u custom field itemu — provjera da se quota provjerava za veličinu novog filea i da se odbija ako prekoračuje limit.

5. **getUserListingStorageUsage:**  
   Nakon dodavanja custom field fileova, provjera (npr. tinker ili privremeni route) da `getUserListingStorageUsage($user_id)` uključuje i te fileove (broj se povećao).

6. **Owner iz listinga:**  
   Admin uređuje custom field na tuđem listingu — provjera da se quota gleda za owner listinga (user_id s listinga), ne za auth()->id().

7. **FREE korisnik:**  
   Ako FREE ne može pristupiti custom fields (has_pro_subscription), ostaje nepromijenjeno; ako negdje može, provjera da se koristi isti helper (20 MB).

8. **Listing bez pronađenog ownera (edge):**  
   Npr. listing_id koji ne postoji — očekivano: jasna greška (validation ili 404), bez move().

---

Kod se ne mijenja u ovoj fazi; ovo je samo precizna mapa za implementaciju.
