<?php

use App\Models\Claim;
use App\Models\ClaimedListing;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('claims:sync-approved-to-claimed-listings', function () {
    $claims = Claim::where('status', 'approved')->get();
    $synced = 0;

    foreach ($claims as $claim) {
        $user = User::find($claim->user_id);
        ClaimedListing::updateOrCreate(
            [
                'listing_id' => $claim->listing_id,
                'listing_type' => $claim->listing_type,
            ],
            [
                'user_id' => $claim->user_id,
                'status' => 1,
                'user_name' => $user ? $user->name : '',
                'user_phone' => '',
                'additional_info' => $claim->description ?? '',
            ]
        );
        $synced++;
    }

    if ($synced > 0) {
        $this->info("Synced {$synced} approved claim(s) to claimed_listings.");
    } else {
        $this->info('No approved claims found. Nothing to sync.');
    }
})->purpose('Backfill claimed_listings from approved claims (run once on VPS)');
