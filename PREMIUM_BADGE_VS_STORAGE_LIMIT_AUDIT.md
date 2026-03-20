# Audit: PREMIUM badge u adminu vs 20 MB limit na frontendu (recidahr@gmail.com)

**Cilj:** Dijagnosticirati zašto korisnik ima PREMIUM badge u adminu, ali frontend storage usage pokazuje FREE limit (20 MB umjesto 100 MB). **Bez izmjene koda** — samo audit i dijagnostika.

---

## SAŽETAK

- **Admin PREMIUM badge** koristi logiku: postoji li **bilo koja** aktivna pretplata (status=1, expire_date > sada) čiji paket ima **price > 0 ILI name sadrži "unlimited"**.
- **Frontend storage limit** (`getUserImageLimits`) koristi **getUserPlanKey** → **getActivePricingForUser** → **jedna** pretplata (zadnja po `id`, status=1, ne istekla) i onda **samo** `pricing.price >= 0.1` za PREMIUM (ne gleda naziv paketa).
- **Mismatch:** Ako je paket “premium” po admin logici (npr. name sadrži "unlimited") ali ima **price = 0**, admin prikaže PREMIUM, a `getUserPlanKey` vrati `'free'` → frontend pokazuje 20 MB.
- **Alternativni uzrok:** Više aktivnih pretplata; zadnja po `id` je FREE paket, starija je PREMIUM → admin vidi PREMIUM (postoji premium red), a `getActivePricingForUser` uzima zadnji (FREE) → 20 MB.

**Minimalni fix:** Uskladiti izvor istine: u `getUserPlanKey` (ili u `getActivePricingForUser` pri interpretaciji paketa) uvesti isti uvjet kao za badge: PREMIUM ako je `price >= 0.1` **ili** `LOWER(name) LIKE '%unlimited%'`.

---

## 1. HELPER LOGIKA

### 1.1 `getUserPlanKey($user_id)`

- **Datoteka:** `app/Helpers/common_helpers.php` (c. 544–552)
- **Logika:**
  - Poziva `getActivePricingForUser($user_id)`.
  - Ako nema aktivnog paketa → `'free'`.
  - Inače: `(float) $pricing->price >= 0.1` → `'premium'`, inače `'free'`.
- **FREE vs PREMIUM:** Samo po **cijeni paketa** (`price >= 0.1`). **Ne** gleda naziv (npr. "unlimited").

### 1.2 `getUserImageLimits($user_id)`

- **Datoteka:** `app/Helpers/common_helpers.php` (c. 562–571)
- **Logika:**
  - `$plan = getUserPlanKey($user_id)`.
  - Ako `$plan === 'premium'` → `['max_images' => 30, 'quota_bytes' => 100 * 1024 * 1024]` (100 MB).
  - Inače → `['max_images' => 3, 'quota_bytes' => 20 * 1024 * 1024]` (20 MB).
- **FREE vs PREMIUM:** Potpuno ovisi o `getUserPlanKey`; nema dodatne logike.

### 1.3 `has_pro_subscription($user_id)`

- **Datoteka:** `app/Helpers/common_helpers.php` (c. 439–457)
- **Logika:** Jedan upit na `subscriptions` JOIN `pricings`:
  - `subscriptions.user_id = $user_id`
  - `subscriptions.status = 1`
  - `subscriptions.expire_date > time()`
  - I **(pricings.price > 0 ILI LOWER(pricings.name) LIKE '%unlimited%')**
  - `.exists()`.
- **FREE vs PREMIUM (PRO):** TRUE ako **postoji barem jedan** takav red. **Ne** bira “zadnju” pretplatu; gleda i **cijenu** i **naziv** paketa.

### 1.4 Pomocne funkcije koje one pozivaju

**getActivePricingForUser($user_id)**  
- **Datoteka:** `app/Helpers/common_helpers.php` (c. 515–532)  
- **Logika:**
  - Jedna pretplata: `Subscription::where('user_id', $user_id)->where('status', 1)->orderBy('id', 'DESC')->first()`.
  - Ako nema ili `time() > expire_date` → `null`.
  - Inače: `Pricing::where('id', $subscription->package_id)->first()`.
- **Važno:** Bira **samo jedan** zapis — onaj s **najvećim `id`** (zadnji po id). Ako korisnik ima više aktivnih pretplata, uzima se samo ta jedna.

**check_subscription($user_id)** — ne koristi se za plan/limit; koristi zadnju pretplatu po id, gleda samo expire_date.  
**current_package()** — auth user, listing limiti, ne koristi se za storage/premium plan.  
**has_paid_subscription($user_id)** — koristi zadnju aktivnu pretplatu i provjeru price/paid_amount; ne koristi se za admin badge niti za `getUserImageLimits`.

---

## 2. ADMIN DODJELA PREMIUMA

### Akcije: "Dodijeli Premium (12 mj)" i "Deaktiviraj Premium"

- **Route:**  
  - Dodjela: `GET subscription/assign-premium/{user_id}` → `admin.subscription.assign-premium`  
  - Deaktivacija: `GET subscription/deactivate-premium/{user_id}` → `admin.subscription.deactivate-premium`  
- **Datoteka ruta:** `routes/web.php` (c. 315–316).
- **Controller:** `App\Http\Controllers\Admin\SubscriptionController`:
  - `assignPremium($user_id)`
  - `deactivatePremium($user_id)`

### Što točno upisuje "Dodijeli Premium"

1. **Tablica:** `subscriptions`.
2. **Prije upisa:** sve postojeće pretplate tog korisnika s `status = 1` postavljaju se na `status = 0`.
3. **Novi red (insert):**
   - `user_id` = dani `$user_id`
   - `package_id` = id paketa iz `Pricing::where('choice', 1)->first()` (paket označen kao “premium” u adminu)
   - `paid_amount` = 0
   - `payment_method` = 'manual'
   - `transaction_keys` = null
   - `auto_subscription` = 0
   - `status` = '1'
   - `expire_date` = strtotime('+12 months')
   - `date_added` = time()
   - `created_at`, `updated_at` = Carbon::now()

**Važno:** Premium paket se određuje po **pricings.choice = 1**, ne po cijeni. Taj paket može imati `price = 0` i/ili naziv s "unlimited".

### Deaktiviraj Premium

- Jedan update: `Subscription::where('user_id', $user_id)->where('status', '1')->update(['status' => '0'])`.

---

## 3. KAKO SE PRIKAZUJE PREMIUM BADGE U ADMIN LISTI AGENATA

- **Blade:** `resources/views/admin/user/index.blade.php` (c. 46–51).  
  Za svakog agenta: `@if (in_array($user->id, $activePremiumUserIds ?? []))` → badge PREMIUM, inače FREE.
- **Controller:** `App\Http\Controllers\Admin\UserController::index($type, $action)`.
- **Kada se postavlja `activePremiumUserIds`:** samo ako je `$type === 'agent'` i `$action === 'all'` (c. 17–29):
  - Upit: `subscriptions` JOIN `pricings` na `subscriptions.package_id = pricings.id`,
  - `subscriptions.status = 1`,
  - `subscriptions.expire_date > time()`,
  - i **(pricings.price > 0 OR LOWER(pricings.name) LIKE '%unlimited%')**,
  - `pluck('subscriptions.user_id')->unique()->values()->toArray()`.
- **Razlika u odnosu na helpere:** Badge koristi **istu** logiku kao `has_pro_subscription` (postoji li **bilo koji** takav red). **Ne** koristi `getUserPlanKey` niti `getActivePricingForUser`. Ne bira “zadnju” pretplatu po `id`.

---

## 4. MODEL I TABLICA ZA SUBSCRIPTIONS / PRICINGS

### Subscription

- **Model:** `app/Models/Subscription.php`  
- **Tablica:** `subscriptions` (Laravel konvencija, nije override-ana u modelu).  
- **Relevantna polja za plan:**  
  `user_id`, `package_id`, `status`, `expire_date`, `date_added` (i ostala polja za plaćanje).

### Pricing

- **Model:** `app/Models/Pricing.php`  
- **Tablica:** `pricings` (iz migracije `2024_07_09_053040_create_pricings_table.php`).  
- **Polja iz migracije:** id, name, sub_title, price, icon, period, feature, timestamps.  
- **U kodu se koristi i:** `choice` (npr. `Pricing::where('choice', 1)` za premium paket) — vjerojatno dodano kasnije (alter ili druga migracija).

---

## 5. VIŠE SUBSCRIPTION ZAPISA

- Korisnik **može** imati više redova u `subscriptions` (razni paketi, povijest, ručna dodjela itd.).
- **getActivePricingForUser:** uzima **samo jedan** red: `where('user_id', $user_id)->where('status', 1)->orderBy('id', 'DESC')->first()` → **zadnji po `id`**. Ta jedna pretplata određuje paket, a `getUserPlanKey` iz tog paketa gleda samo `price >= 0.1`.
- **Admin badge (activePremiumUserIds):** nema `orderBy`; korisnik je PREMIUM ako **postoji barem jedan** red koji zadovolji (status=1, expire_date>now, price>0 ili name unlimited). Može postojati stariji red (manji `id`) koji je premium, a noviji (veći `id`) koji je free → badge i dalje PREMIUM, a `getActivePricingForUser` vraća free paket → 20 MB.
- **Zaključak:** Postoji jasna razlika: badge = “postoji li *neka* premium pretplata”; storage limit = “*zadnja* pretplata (po id) i samo njezin price”.

---

## 6. DIJAGNOSTIKA ZA KORISNIKA recidahr@gmail.com

### Korak 1: User ID

```sql
SELECT id FROM users WHERE email = 'recidahr@gmail.com';
```

Npr. `user_id = X`.

### Korak 2: Sve pretplate i paketi

```sql
SELECT s.id AS sub_id, s.user_id, s.package_id, s.status, s.expire_date,
       FROM_UNIXTIME(s.expire_date) AS expire_at,
       p.name AS package_name, p.price AS package_price, p.choice
FROM subscriptions s
LEFT JOIN pricings p ON p.id = s.package_id
WHERE s.user_id = X
ORDER BY s.id DESC;
```

Provjeri:
- Ima li redova s `status = 1` i `expire_date > UNIX_TIMESTAMP(NOW())`?
- Za **zadnji** takav red (najveći `id`): koji je `package_id`, `package_name`, `package_price`?
- Ima li više aktivnih redova; je li “zadnji” po `id` FREE (price < 0.1, naziv bez "unlimited"), a neki stariji PREMIUM (price > 0 ili name LIKE '%unlimited%')?

### Korak 3: Zašto admin vidi PREMIUM

Admin će uključiti ovog user_id u `activePremiumUserIds` ako postoji **barem jedan** red u `subscriptions` za tog usera s:
- `status = 1`
- `expire_date > time()`
- i pripadajući paket u `pricings` s `price > 0` **ili** `LOWER(name) LIKE '%unlimited%'`.

### Korak 4: Što treba za PREMIUM u `getUserImageLimits`

- **getActivePricingForUser:** mora vratiti jedan Pricing za zadnju aktivnu pretplatu (zadnji `id`, status=1, expire_date>now).
- **getUserPlanKey:** taj paket mora imati `(float) price >= 0.1`.  
  **Trenutno** naziv paketa (npr. "unlimited") **ne** utječe na `getUserPlanKey`.

Dakle da bi frontend prikazao 100 MB, treba:
- Zadnja (po `id`) aktivna pretplata za tog usera mora imati `package_id` koji u `pricings` ima **price >= 0.1** (ili će se u kodu morati proširiti uvjet na “unlimited” kao u badge logici).

---

## 7. ODGOVORI NA PITANJA

### A) Zašto admin pokazuje PREMIUM, a frontend 20 MB?

- Admin badge gleda: “postoji li *bilo koja* aktivna pretplata čiji paket ima **price > 0** ili **name sadrži 'unlimited'**.”
- Frontend (`getUserImageLimits` → `getUserPlanKey`) gleda: **zadnju** aktivnu pretplatu (po `id`) i **samo** `pricing.price >= 0.1` (naziv se ne gleda).

Moguća objašnjenja za recidahr@gmail.com:

1. **Paket (choice=1) ima price = 0 i naziv s "unlimited":** admin uvjet je ispunjen (unlimited), a `getUserPlanKey` vrati 'free' (price < 0.1) → 20 MB.
2. **Više aktivnih pretplata:** zadnja po `id` je FREE paket; neka starija je PREMIUM paket → admin i dalje vidi PREMIUM, a `getActivePricingForUser` uzima zadnju → FREE → 20 MB.

### B) Točan izvor buga / mismatcha

- **Izvor:** Dva različita pravila za “je li korisnik premium”:
  - **Badge / has_pro_subscription:** `(pricings.price > 0) OR (LOWER(pricings.name) LIKE '%unlimited%')` i “postoji li takav red”.
  - **getUserPlanKey (pa i getUserImageLimits):** samo `(float) pricing->price >= 0.1`, bez provjere naziva, i uz korištenje **samo jedne** pretplate (zadnje po `id`).
- **Posljedica:** Ako je “premium” paket definiran s `price = 0` i nazivom tipa "Unlimited", ili ako je zadnja aktivna pretplata FREE, admin i frontend se ne slažu.

### C) Najmanji ispravan fix

- **Opcija 1 (preporučeno):** U `getUserPlanKey` (u `app/Helpers/common_helpers.php`) proširiti uvjet za premium na isti kao kod badgea:  
  PREMIUM ako `(float) $pricing->price >= 0.1` **ili** `stripos($pricing->name ?? '', 'unlimited') !== false` (ili ekvivalentno LOWER(name) LIKE '%unlimited%').  
  Time se ne dira admin, ne dira se baza, a storage limit i badge koriste isto pravilo.
- **Opcija 2:** U bazi za paket s `choice = 1` postaviti `price >= 0.1` (npr. 0.01 ili simbolična cijena), tako da `getUserPlanKey` bez promjene koda vrati PREMIUM. Manje preporučljivo ako “besplatni premium” želite eksplicitno držati s price=0.
- **Opcija 3:** Ako želimo jedan izvor istine “zadnja pretplata”, admin badge bi trebao koristiti `getUserPlanKey($user->id)` umjesto zasebnog upita; to zahtijeva refaktor (proslijediti helpere u view ili računati badge u controlleru), što je veći zahvat od minimalnog fixa u `getUserPlanKey`.

---

**Završna napomena:** Za potvrdu za recidahr@gmail.com potrebno je pokrenuti SQL iz točke 6 (user id, subscriptions + pricings) i provjeriti vrijednosti `package_price` i `package_name` za zadnju aktivnu pretplatu te postoji li više aktivnih pretplata s različitim paketima.
