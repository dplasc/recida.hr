<form action="{{route('claimStore')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{$type}}" name="claim_listing_type">
    <input type="hidden" value="{{$listing_id}}" name="claim_listing_id">

    {{-- Explanatory info box --}}
    <div class="alert alert-light border rounded-3 mb-4 p-3" role="region" aria-label="Informacije o zahtjevu">
        <div class="d-flex gap-2">
            <i class="fas fa-info-circle text-primary mt-1 flex-shrink-0" aria-hidden="true"></i>
            <div class="small">
                <p class="mb-2">Ako ste vlasnik ili službeni predstavnik ovog oglasa, možete zatražiti prijenos vlasništva na svoj korisnički račun.</p>
                <p class="mb-0">Radi sigurnosti i sprječavanja zloupotrebe, potrebno je priložiti dokaz vlasništva (npr. fotografiju, screenshot društvene mreže, web stranice ili drugi relevantni dokument).</p>
                <p class="mb-0 mt-2">Nakon provjere, administrator će vas kontaktirati putem emaila.</p>
            </div>
        </div>
    </div>

    <div class="">
        <div class="mb-3">
            <label for="description" class="form-label ua-form-label mb-2">Opis zahtjeva</label>
            <textarea class="form-control mform-control review-textarea" name="description" id="description" required rows="4"></textarea>
            <div class="form-text small mt-1">Ukratko opišite svoju povezanost s oglasom.</div>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label ua-form-label mb-2">Dokaz vlasništva (obavezno)</label>
            <input type="file" class="form-control ol-form-control" name="file" id="file" required accept=".jpg,.jpeg,.png,.pdf">
            <div class="form-text small mt-1">Učitajte dokument, fotografiju ili screenshot koji potvrđuje da ste vlasnik ili predstavnik ovog oglasa.</div>
            <div class="alert alert-warning border-0 py-2 px-3 mt-2 small mb-0" role="alert">
                <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i> Lažno predstavljanje može dovesti do trajnog uklanjanja korisničkog računa.
            </div>
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="btn btn-primary fw-semibold px-4">Pošalji zahtjev</button>
    </div>
</form>