


<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ get_phrase('Subscription Invoice') }} | {{ get_phrase('Agent Panel') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
 </head>
<style>
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
                            <th>{{ get_phrase('Paid Amount') }}</th>
                         </thead>
                        @php
                        $created_at = date('d M Y', strtotime($subscriptionDetails->created_at));
                        $expire_date = date('d M Y', strtotime($subscriptionDetails->expire_date));
                       $package = App\Models\Pricing::where('id',$subscriptionDetails->package_id)->first();
                        @endphp
                        <tbody>
                            <tr>
                                <td>
                                    <p class="text-center">{{get_phrase('1')}}</p>
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
         </div>
    </div>
 </div>
 <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>
