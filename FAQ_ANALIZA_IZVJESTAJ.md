# FAQ Analiza – Izvještaj i Rješenje

## 1. ADMIN STRANA

**Datoteka:** `resources/views/admin/setting/webfaqs.blade.php`

| Element | Vrijednost |
|---------|------------|
| Form action | `route('admin.website-setting-update')` |
| Method | POST |
| Hidden input | `name="type"` `value="websitefaqs"` |
| Polja | `name="questions[]"`, `name="answers[]"` |
| Izvor podataka za prikaz | `get_frontend_settings('website_faqs')` → **frontend_settings** tablica |

---

## 2. ROUTE

**Datoteka:** `routes/web.php` (linija 221)

```
POST /website-setting-update
→ SettingController::website_setting_update
→ name: admin.website-setting-update
```

---

## 3. CONTROLLER

**Datoteka:** `app/Http/Controllers/Admin/SettingController.php` (linije 515–525)

```php
if ($request->type == 'websitefaqs') {
    array_shift($data);
    $faqs = array();
    foreach (array_filter($data['questions']) as $key => $question) {
        $faqs[$key]['question'] = $question;
        $faqs[$key]['answer']   = $data['answers'][$key];
    }
    $data['value'] = json_encode($faqs);
    $faq           = $data['value'];
    FrontendSettings::where('key', 'website_faqs')->update(['value' => $faq]);
    Session::flash('success', get_phrase('Website Faqs update successfully!'));
}
```

| Parametar | Vrijednost |
|-----------|------------|
| Tablica | **frontend_settings** (model `FrontendSettings`) |
| Key | `website_faqs` |
| Format | JSON niz objekata `[{question, answer}, ...]` |

**Napomena:** Koristi se `update()` – ako zapis ne postoji, ništa se ne sprema (0 affected rows).

---

## 4. HELPER FUNKCIJE

| Funkcija | Tablica | Primjer |
|----------|---------|---------|
| `get_settings($key)` | **system_settings** | `get_settings('website_faqs')` |
| `get_frontend_settings($key)` | **frontend_settings** | `get_frontend_settings('website_faqs')` |

`get_settings($key, 'decode')` vraća `json_decode($value, true)`.

---

## 5. FRONTEND

**Datoteka:** `resources/views/frontend/pricing.blade.php` (linije 166–177)

```php
@php
    $faqs = get_settings('website_faqs') ?: get_settings('webfaqs') ?: get_settings('website_faq');
@endphp

@if(!empty($faqs))
    {!! $faqs !!}
@else
    ...
@endif
```

---

## 6. UZROK PROBLEMA

| Komponenta | Gdje čita/piše | Tablica |
|------------|----------------|---------|
| Admin forma | Čita za prikaz | **frontend_settings** |
| Controller | Sprema | **frontend_settings** |
| Frontend /pricing | Čita | **system_settings** |

**Problem 1:** Frontend koristi `get_settings()` → čita iz **system_settings**, dok se podaci spremaju u **frontend_settings**.

**Problem 2:** Frontend očekuje HTML string (`{!! $faqs !!}`), a podaci su JSON niz `[{question, answer}, ...]` – treba dekodirati i iterirati.

**Problem 3:** Controller koristi `update()` – ako zapis `website_faqs` ne postoji u `frontend_settings`, prvi Save neće ništa spremiti.

---

## 7. MINIMALNI PATCH

### Opcija A: Ispravak frontenda (preporučeno – najmanje promjena)

Admin i controller ostaju na **frontend_settings**. Mijenja se samo frontend da čita s pravog mjesta i ispravno renderira.

**Promjena:** `resources/views/frontend/pricing.blade.php`

```php
@php
    $faqs = json_decode(get_frontend_settings('website_faqs') ?? '[]', true) ?: [];
@endphp

@if(!empty($faqs))
    <div class="accordion" id="faqAccordion">
        @foreach($faqs as $index => $faq)
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index }}" aria-expanded="{{ $index === 0 }}">
                        {{ $faq['question'] ?? '' }}
                    </button>
                </h3>
                <div id="faq-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {!! nl2br(e($faq['answer'] ?? '')) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center text-muted">
        <p>FAQ trenutno nije postavljen.</p>
    </div>
@endif
```

**Controller:** Zamijeniti `update()` s `updateOrCreate()` radi prvog spremanja:

```php
FrontendSettings::updateOrCreate(
    ['key' => 'website_faqs'],
    ['value' => $faq]
);
```

---

### Opcija B: Jedan key u system_settings (kako si tražio)

Ako želiš jedan key u **system_settings** i `get_settings('website_faqs', 'decode')`:

1. **Controller** – spremati u `system_settings`:
   ```php
   System_setting::updateOrCreate(
       ['key' => 'website_faqs'],
       ['value' => $faq]
   );
   ```

2. **Admin webfaqs.blade.php** – čitati iz `system_settings`:
   ```php
   $faqs = get_settings('website_faqs', 'decode');
   $faqs = is_array($faqs) && count($faqs) > 0 ? $faqs : [['question' => '', 'answer' => '']];
   ```

3. **Frontend pricing.blade.php** – čitati i prikazivati:
   ```php
   $faqs = get_settings('website_faqs', 'decode') ?: [];
   ```
   + isti `@foreach` blok kao u Opciji A.

**Napomena:** Ako već imaš FAQ u `frontend_settings`, trebat će jednokratna migracija ili ručno ponovno spremanje u adminu.

---

## 8. SAŽETAK

| Stavka | Vrijednost |
|--------|------------|
| Ruta za Save | `admin.website-setting-update` (POST) |
| Controller + metoda | `SettingController::website_setting_update` |
| Tablica (trenutno) | **frontend_settings** |
| Key | `website_faqs` |
| Format | JSON `[{question, answer}, ...]` |

**Preporuka:** Opcija A – minimalan patch (samo frontend + `updateOrCreate` u controlleru), bez mijenjanja tablice i bez migracije podataka.
