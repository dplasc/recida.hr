# Audit: gdje prikazati user storage usage u UI-u

**Datum:** 19. ožujka 2025  
**Kontekst:** Backend quota uključuje listing images, floor plans, og_image, 3D model, custom field image/slider/gallery. Cilj: pronaći najbolja mjesta za prikaz iskorištenog prostora, limita i preostalog.  
**Napomena:** Kod nije mijenjan; samo audit.

---

## 1. SAŽETAK

- **Primarno mjesto:** **Agent – My Listings** (`resources/views/user/agent/my_listings.blade.php`). Na tom ekranu agent upravlja oglasima i već postoji plan-related info box (Premium upgrade). Dodavanje storage usagea (npr. info kartica ili red ispod/iznad tog boxa) daje kontekst prije “Add Listing” i prije ulaska u custom fields; jedan blok vidljiv na glavnom “listing hubu”.
- **Sekundarno mjesto:** **Agent – Subscription** (`resources/views/user/agent/subscription/index.blade.php`). Stranica trenutnog paketa i isteka; prirodno mjesto za “Storage: X MB / Y MB” ili kratak progress u okviru kartice trenutnog paketa.
- **Kontekstualno (opcionalno):** Listing edit (Media tab ili iznad tabova) i Custom field create – prikaz uz sam upload, da korisnik vidi stanje upravo kad dodaje slike.
- **Helperi su dovoljni:** U bladeovima mogu se koristiti `getUserListingStorageUsage(user('id'))` i `getUserImageLimits(user('id'))`; controller ne mora proslijediti podatke ako se prikaz ograniči na auth usera. Za admin prikaz po useru treba proslijediti `user_id` (npr. u `$user` na edit stranici) i u viewu pozvati helpere s tim idom.
- **Postojeći UI:** Na My Listings postoji `ca-content-card` s border-warning (Premium upgrade) i badge; na Subscription `dl_column_item` kartice. Nema postojećeg progress bara ili “plan usage” komponente – može se dodati jednostavan tekst ili progress bar u istom stilu (Bootstrap 5 kompatibilno).

---

## 2. RELEVANTNI EKRANI

| Ekran | File path | Route | Controller metoda | Tko vidi | Dobro mjesto za storage? Zašto |
|-------|-----------|--------|--------------------|----------|---------------------------------|
| **My Listings** | `resources/views/user/agent/my_listings.blade.php` | `agent.my_listings` | `AgentController::my_listings` | Agent | **Da.** Glavni “listing hub”; već ima Premium info box. Jedno mjesto gdje agent vidi stanje prije dodavanja/uređivanja oglasa i custom fields. |
| **Listing create (tip)** | `resources/views/user/agent/listing/add.blade.php` | `agent.add.listing` | `AgentController::add_listing` | Agent | Djelomično. Odabir tipa listinga; slike se dodaju tek na sljedećem koraku (create forma po tipu). Storage moguće prikazati, ali korisnik još ne uploada. |
| **Listing create (forma)** | `resources/views/user/agent/listing/real-estate.blade.php`, `car.blade.php`, `hotel.blade.php`, `beauty.blade.php`, `restaurant.blade.php`, `custom_add.blade.php` | `agent.add.listing.type` → zatim POST na `user.listing.store` | `AgentController::add_listing_type` → `ListingController::listing_store` | Agent | **Da (kontekstualno).** Upravo tu se uploadaju listing slike. Kratak “X MB / Y MB” iznad ili pokraj galerije pomaže pri uploadu. |
| **Listing edit** | `resources/views/user/agent/listing/real-estate_edit.blade.php` (+ hotel, car, beauty, restaurant, custom_edit) | `user.listing.edit` | `AgentController::listing_edit` | Agent | **Da (kontekstualno).** Tabs: Basic Info, Address, Features, SEO, **Media**, Nearby, 3D Model, Custom Field. Media tab = galerija i floor plan; Custom Field tab vodi na custom field sekcije. Prikaz storagea iznad tabova ili na Media tabu ima smisla. |
| **Custom field create** | `resources/views/user/agent/custom-field/create.blade.php` | `agent.custom-field.create` | `AgentCustomFieldController::customField_Create` | Agent | **Da (kontekstualno).** Dodavanje image/slider/gallery sekcija; prikaz “X MB / Y MB” ili “Preostalo: Z MB” smanji iznenađenje kad quota prekorači. |
| **Custom field edit** | `resources/views/user/agent/custom-field/edit.blade.php` | `agent.custom-field.edit` | `AgentCustomFieldController::customFieldEdit` | Agent | Može. Rjeđe korišten; isti kontekst kao create. |
| **Agent Subscription** | `resources/views/user/agent/subscription/index.blade.php` | `user.subscription` | `SubscriptionController::user_subscription` | Agent | **Da.** Stranica trenutnog paketa, isteka i naplate. Prirodno mjesto za “Storage: X MB / Y MB” ili progress u okviru kartice paketa. |
| **Agent Account** | `resources/views/user/agent/account.blade.php` | `user.account` | `AgentController::account` (ili sl.) | Agent | Moguće. Profil i postavke; storage nije glavna tema, ali jedan red “Media storage: X / Y MB” je prihvatljiv. |
| **Agent sidebar** | `resources/views/user/navigation.blade.php` | (dio svake agent stranice) | — | Agent (i customer) | **Moguće.** U “My Agent Panel” bloku mogla bi stajati kratka linija “Storage: X / Y MB” ili mala progress traka. Uvijek vidljivo; malo zauzima. |
| **Admin listing create/edit** | `resources/views/admin/listing/*.blade.php` (real-estate, car, hotel, …) | `admin.listing.create`, `admin.listing.edit` | `ListingController::listing_create`, `listing_edit` | Admin | Opcionalno. Admin uređuje u ime usera; quota se računa po owneru. Ako želimo da admin vidi storage, treba prikaz za **odabranog usera** (npr. owner listinga). |
| **Admin custom field** | `resources/views/admin/custom-field/create.blade.php`, `edit.blade.php` | `admin.custom-field.create`, `admin.custom-field.edit` | `CustomFieldController::customField_Create`, `customFieldEdit` | Admin | Isto kao agent – kontekstualno pri uploadu. |
| **Admin user edit** | `resources/views/admin/user/edit.blade.php` | `admin.edit.user` | `UserController::user_edit` | Admin | **Da (za admin).** Prikaz “Storage usage: X MB / Y MB” za tog usera pomaže supportu i provjeri quotaa; trenutno nema takvog bloka. |
| **Admin user list** | `resources/views/admin/user/index.blade.php` | `admin.user` | `UserController::index` | Admin | Opcionalno. Moguće dodati stupac ili tooltip “X MB” po useru; manji prioritet od user edit. |
| **Frontend Pricing** | `resources/views/frontend/pricing.blade.php` | `pricing` | `FrontendController::pricing` | Customer / anonimni | Slabo. Stranica za odabir paketa; moguće spomenuti “100 MB storage” u opisu paketa, ali to je copy, ne live usage. |

---

## 3. NAJBOLJA MJESTA ZA PRIKAZ

### A) Listing create/edit forma

- **Create:** Forme po tipu (real-estate, car, hotel, …) i `custom_add` – gdje se uploadaju `listing_image[]`. Dobro mjesto za kratku liniju “Media storage: X MB / Y MB” ili “Preostalo: Z MB” iznad ili ispod inputa za slike.
- **Edit:** Svi `*_edit.blade.php` imaju tabove; “Media” tab sadrži galeriju i floor plan. Prikaz storagea iznad tabova (u istom `ca-content-card` bloku) ili na vrhu Media taba – korisnik vidi stanje prije nego što dodaje slike ili ide na Custom Field tab.
- **Procjena:** Jako dobro za **kontekst** (vidim koliko mogu još uploadati upravo na formi). Nije nužno primarno jer se prikaz mora ponavljati na više bladeova (6+ edit/create viewova).

### B) Custom fields add/edit ekran

- **Create:** `user/agent/custom-field/create.blade.php` – forma s tipovima image, slider, gallery. Prikaz “Storage: X / Y MB” na vrhu forme ili pokraj “Select Type” smanji prekoračenje quota bez upozorenja.
- **Edit:** Isti princip na edit stranici.
- **Procjena:** Vrlo dobro **kontekstualno** (upload custom field slika). Manji doseg od My Listings jer ne vidi svaki agent tu stranicu na prvom mjestu.

### C) Agent dashboard sidebar / top card

- **Sidebar:** `resources/views/user/navigation.blade.php`. U sekciji “My Agent Panel” (nakon My Listing, Add Listing, …) mogla bi stajati jedna linija: “Storage: X / Y MB” ili mala progress traka. Uvijek vidljivo na svim agent stranicama; minimalan utjecaj na layout. Sidebar već ima `badge-secondary` za brojeve (npr. appointments).
- **Top card:** Na My Listings već postoji “top” info box (Premium upgrade). Ekvivalent “Storage usage” kartice može stajati ispod ili iznad njega – jedna kartica s “X MB used of Y MB” i opcionalno progress bar.
- **Procjena:** Sidebar = dobro za **stalnu vidljivost** bez zauzimanja sadržaja. Top card na My Listings = bolji balans vidljivost + kontekst (listing hub).

### D) Pricing / current package ekran

- **Subscription index:** `user/agent/subscription/index.blade.php`. Kartica “Account” prikazuje trenutni paket, cijenu i datum isteka. Dodati jedan red “Media storage: X MB of Y MB” ili kratak progress bar u tu istu karticu – sve što se tiče “plan and limits” na jednom mjestu.
- **Procjena:** Vrlo dobro kao **sekundarno** mjesto; korisnik koji gleda subscription očekuje i limite (uključujući storage).

### E) Admin user profile / user list

- **User edit:** `admin/user/edit.blade.php`. Za odabranog usera prikaz “Storage usage: X MB / Y MB (plan: Free/Premium)”. Admin vidi koliko taj user troši; korisno za support i provjeru.
- **User list:** Moguće dodati stupac “Storage” (npr. X MB) – manji prioritet, više posla (N upita po stranici).
- **Procjena:** User edit = dobro **samo za admin**; ne rješava prikaz za samog agenta.

---

## 4. POSTOJEĆI UI ELEMENTI KOJI SE MOGU ISKORISTITI

| Element | Gdje postoji | Kako iskoristiti za storage |
|--------|----------------|-----------------------------|
| **Info box / card** | My Listings: `ca-content-card mb-4 p-4 d-flex justify-content-between ... border border-warning bg-light` (Premium upgrade). | Nova slična kartica ispod ili iznad: “Media storage: X MB / Y MB” s istim `ca-content-card` stilom, bez border-warning osim ako je blizu limita. |
| **Badge** | My Listings: `badge bg-warning`, claim_history: `badge bg-success`, itd. | Moguće badge “X MB” ili “X/Y MB” u sidebaru ili u karticu; manje čitljivo od punog teksta. |
| **Kartice (dl_column_item / boxShadow)** | Subscription: `dl_column_item pt-22 px-30 pb-30 boxShadow-06 bg-white` s naslovom i tekstom. | U prvu karticu (trenutni paket) dodati paragraf “Media storage: X MB of Y MB” ili mali progress. |
| **Progress bar** | U pregledanim viewovima **nije** pronađen gotov progress bar za usage. | Dodati jednostavan Bootstrap 5 progress: `<div class="progress"><div class="progress-bar" style="width: {{ $percent }}%">`. Stil uskladiti s postojećim (npr. cap-* klasama). |
| **Plan usage indikator** | Nema posebnog “plan usage” widgeta. | Storage usage može biti prvi takav indikator – isti pattern kasnije za “listings used” ako se uvede. |
| **Listing limits prikaz** | Nema eksplicitnog prikaza “max X slika” u UI-u (limit je u validaciji). | Opcionalno uz storage prikazati i “Max Y slika po oglasu” iz `getUserImageLimits()['max_images']` ako želimo sve limite na jednom mjestu. |

---

## 5. KAKO U BLADEOVIMA DOHVATITI PODATKE (POSTOJEĆI HELPERI)

Sve vrijednosti mogu se izračunati u bladeu bez dodatnog controller koda (za trenutnog usera):

```php
@php
    $userId = user('id');  // ili auth()->id()
    $limits = getUserImageLimits($userId);
    $usedBytes = getUserListingStorageUsage($userId);
    $quotaBytes = $limits['quota_bytes'];
    $usedMb = round($usedBytes / (1024 * 1024), 2);
    $quotaMb = round($quotaBytes / (1024 * 1024), 2);
    $remainingBytes = max(0, $quotaBytes - $usedBytes);
    $remainingMb = round($remainingBytes / (1024 * 1024), 2);
    $percent = $quotaBytes > 0 ? min(100, round(($usedBytes / $quotaBytes) * 100)) : 0;
@endphp
```

- **used bytes:** `getUserListingStorageUsage($userId)`  
- **quota bytes:** `getUserImageLimits($userId)['quota_bytes']`  
- **used MB:** `round($usedBytes / (1024 * 1024), 2)`  
- **remaining MB:** `round(max(0, $quotaBytes - $usedBytes) / (1024 * 1024), 2)`  
- **postotak:** `min(100, round(($usedBytes / $quotaBytes) * 100))` (za progress bar)

Na **admin user edit** treba koristiti **tog usera**, npr. `$userId = $user->id` (ili `$user_id` kako controller proslijedi), a ne `user('id')`.

---

## 6. PREPORUKA ZA IMPLEMENTACIJU

### Najbolje primarno mjesto

- **Agent – My Listings** (`resources/views/user/agent/my_listings.blade.php`).
- Razlozi: (1) Glavni ekran za listanje i dodavanje oglasa; (2) već postoji plan-related box (Premium); (3) jedan blok vidljiv svima prije “Add Listing” i prije ulaska u listing edit / custom fields; (4) bez ponavljanja na desecima stranica.

### Opcionalno sekundarno mjesto

- **Agent – Subscription** (`resources/views/user/agent/subscription/index.blade.php`).
- U kartici “Account” (trenutni paket) dodati red “Media storage: X MB of Y MB” i opcionalno progress bar. Korisnik koji gleda plan i istek prirodno vidi i storage limit.

### Zašto

- **My Listings:** Mjesto gdje se donosi odluka “dodaj oglas” i “uredi oglas / custom fields”; prikaz storagea tu smanjuje prekoračenje i podržava isti quota koji se već provjerava na backendu.
- **Subscription:** Sve “plan and limits” na jednom mjestu; manji naglasak od My Listings, ali konzistentno.

### Koji blade file treba mijenjati

- **Primarno:** `resources/views/user/agent/my_listings.blade.php`  
  - Ubaciti blok (npr. ispod Premium boxa ili iznad tablice listinga) s `@php` izračunom i prikazom: “Media storage: {{ $usedMb }} MB / {{ $quotaMb }} MB” te opcionalno progress bar.
- **Sekundarno:** `resources/views/user/agent/subscription/index.blade.php`  
  - Unutar `@if ($expiry_status)` kartice “Account” dodati paragraf ili red s “Media storage: …” i eventualno progress.

### Treba li mijenjati controller ili je dovoljan helper/blade?

- **Dovoljno je helper + blade.** Za agenta `user('id')` je uvijek dostupan u viewu; `getUserListingStorageUsage()` i `getUserImageLimits()` mogu se pozvati iz bladea. **Controller ne mora proslijediti** `usedBytes`, `quotaBytes` itd. ako se prikaz odnosi samo na `auth()->id()`.
- **Iznimka – admin user edit:** Tamo treba prikaz za **uređivanog usera** (`$user->id`). Controller već šalje `$user`; u bladeu koristiti `getUserListingStorageUsage($user->id)` i `getUserImageLimits($user->id)`. Nema potrebe za novim endpointom, samo poziv helpera s drugim idom.

---

## 7. DODATNE NAPOMENE

- **Layout:** Agent stranice koriste `@include('user.navigation')` u lijevom stupcu; glavni sadržaj je u `col-lg-8 col-xl-9`. Storage blok na My Listings i Subscription uglavnom ide u taj glavni stupac.
- **Više jezika:** Ako se koristi `get_phrase()`, naslove tipa “Media storage” i “X MB of Y MB” staviti u prijevod.
- **Kontekstualni prikazi (listing edit, custom field create):** Ako se kasnije doda, isti `@php` blok i prikaz mogu ući u partial (npr. `user.agent.partials.storage_usage`) i uključiti ga u My Listings, Subscription, listing edit (iznad Media taba) i custom-field create – da ne duplicirate logiku.

Kod nije mijenjan; ovo je samo audit i preporuka.
