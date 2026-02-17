


<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ get_phrase('Subscription Invoice') }} | {{ get_phrase('Agent Panel') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
</head>
<style>
    body, table, th, td { font-family: DejaVu Sans, sans-serif !important; }
    .table-responsive{
        margin:auto;
    }
    .table-responsive .table th{
        padding:10px 0;
        border-bottom:1px solid #e3e4ea !important;
        font-size:15px;
        font-weight:500;
    }
    .table-responsive .table{
        border:1px solid #e3e4ea !important;
    }
    .table-responsive .table tr td{
        border-bottom:1px solid #e3e4ea !important;
    }
    .table-responsive .table tr td{
        padding:8px 0;
        font-size:14px;
    }
    .text-center{
       text-align:center;
    }
    .w-100{
        width:140px;
    }
</style>

<body>
    <div class="container">
        <div class="row">
           <div class="col-lg-12">
            <table class="table-content">
                <tbody>
                    <tr>
                        <td>
                            <div>
                                <p>{{ get_phrase('INVOICE') }}</p>
                            </div>
                            <div>
                                <div>
                                    <p >{{ auth()->user()->name }}</p>
                                    <p >{{ auth()->user()->email }}</p>
                                </div>
                                <div >{{ get_phrase('Billing Address :') }}</div>
                                <div  class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p>
                                            {{ get_phrase('Country') }}: {{ $country->name ?? '' }}<br>
                                            {{ get_phrase('City') }}: {{ $address?->city ? App\Models\City::find($address->city)?->name : '' }}<br>
                                            {{ get_phrase('Address line') }}: {{ $address?->addressline ?? '' }}<br>
                                        </p>
                                    </div>                                    
                                </div>
                            </div>
                            <p>{{ get_phrase('Paid') }}</p>
                        </td>
                        <td class="w-100"></td>
                        <td class="w-100"></td>
                        <td class="w-100"></td>
                        <td>
                            <div>
                                <p >{{ get_phrase('Invoice no :') }}</p>
                                <p >{{ $subscriptionDetails->id }}</p>
                                <p>{{ get_phrase('Date :') }}</p>
                                <p >{{ date('D, d-M-Y') }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="table-responsive">
                <table class="table table-bordered">
                       <thead>
                            <th><p>{{ get_phrase('ID') }}</p></th>
                            <th>{{ get_phrase('Package') }}</th>
                            <th>{{ get_phrase('Date') }}</th>
                            <th>{{ get_phrase('Total Amount') }}</th>
                            <th>Plaćeni iznos</th>
                         </thead>
                        @php
                        $created_at = date('d M Y', strtotime($subscriptionDetails->created_at));
                        $expire_date = date('d M Y', strtotime($subscriptionDetails->expire_date));
                       $package = App\Models\Pricing::where('id',$subscriptionDetails->package_id)->first();
                        @endphp
                        <tbody>
                            <tr>
                                <td>
                                    <p class="text-center">{{ get_phrase('1') }}</p>
                                </td>
                                <td class="w-100">
                                   <p class="text-center">{{ $package->name }}</p>
                                </td>
                                <td class="w-100">
                                  <p class="text-center">{{ $created_at }}</p>
                                </td>
                                <td class="w-100">
                                   <p class="text-center">@if ($package->price == 0)
                                                        {{get_phrase('Free')}}
                                                    @else
                                                        {{currency($package->price)}}
                                                    @endif</p>
                                </td>
                                <td class="w-100">
                                    <p class="text-center">@if (empty($subscriptionDetails->paid_amount)){{get_phrase('Free')}}@else{{currency($subscriptionDetails->paid_amount)}}@endif</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-100"></td>
                                <td class="w-100"></td>
                                <td class="w-100"></td>
                                <td class="w-100">
                                    <p class="text-center">{{ get_phrase('Subtotal') }}</p>
                                </td>
                                <td class="w-100">
                                   <p class="text-center">@if (empty($subscriptionDetails->paid_amount)){{get_phrase('Free')}}@else{{currency($subscriptionDetails->paid_amount)}}@endif</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-100"></td>
                                <td class="w-100"></td>
                                <td class="w-100"></td>
                                <td>
                                    <p class="text-center">{{ get_phrase('Grand Total') }}</p>
                                </td>
                                <td>
                                   <p class="text-center">@if (empty($subscriptionDetails->paid_amount)){{get_phrase('Free')}}@else{{currency($subscriptionDetails->paid_amount)}}@endif</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @php
                  $start = \Carbon\Carbon::parse($subscriptionDetails->created_at)->locale('hr');
                  $end   = \Carbon\Carbon::createFromTimestamp($subscriptionDetails->expire_date)->locale('hr');
                @endphp
                <p style="margin: 12px 0 0; line-height: 1.4; font-size: 13px;">
                    Način plaćanja: Kartično plaćanje (Stripe) — plaćeno online.<br>
                    PDV nije obračunat sukladno čl. 90. Zakona o PDV-u (nisam u sustavu PDV-a).<br>
                    Period usluge: {{ $start->translatedFormat('d. F Y.') }} – {{ $end->translatedFormat('d. F Y.') }} (12 mjeseci)
                </p>

                <hr style="margin: 14px 0;">

                <h4 style="margin: 0 0 6px;">Podaci za uplatu</h4>
                <p style="margin: 0; line-height: 1.35;">
                    <strong>IBAN:</strong> HR6023400091160622773<br>
                    <strong>Primatelj:</strong> Oglašavaj se – obrt za marketinške usluge<br>
                    <strong>Model i poziv na broj:</strong> HR00 {{ $subscriptionDetails->id ?? '' }}<br>
                    <strong>Opis plaćanja:</strong> Pretplata – ReciDa.hr
                </p>
                <p style="margin: 10px 0 0; line-height: 1.35;">
                    <strong>Napomena:</strong> Originalni račun bit će dostavljen na vašu e-mail adresu.
                </p>

                <hr style="margin: 14px 0;">

                <h4 style="margin: 0 0 6px;">Voditelj obrade</h4>
                <p style="margin: 0; line-height: 1.35;">
                    Voditelj obrade osobnih podataka je:<br>
                    <strong>Oglašavaj se – obrt za marketinške usluge</strong><br>
                    Vlasnik: Darko Plašć<br>
                    OIB: 98808078966<br>
                    Ivana Dončevića 7, 43000 Bjelovar, Hrvatska
                </p>
         </div>
    </div>
</div>
</body>
</html>
