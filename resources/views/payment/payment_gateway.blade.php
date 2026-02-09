<style>
    .spinner-border {
        width: 3.5rem;
        height: 3.5rem;
    }
</style>
<div class="paymentWrap d-flex align-items-start flex-wrap">
    <div class="paymentLeft">
        <p class="payment_tab_title pb-30">{{ get_phrase('Select payment gateway') }}</p>
        <!-- Tab -->
        <div class="nav flex-md-column flex-row nav-pills payment_modalTab" role="tablist" aria-orientation="vertical">

            @foreach ($payment_gateways as $key => $payment_gateway)
                <div class="tabItem" onclick="showPaymentGatewayByAjax('{{ $payment_gateway->identifier }}')" id="{{ $payment_gateway->identifier }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $payment_gateway->identifier }}" role="tab" aria-controls="{{ $payment_gateway->identifier }}" aria-selected="true">
                    <div class="payment_gateway_option d-flex align-items-center">
                        <div class="logo">
                            <img width="100px" src="{{ get_image('assets/payment/' . $payment_gateway->identifier . '.png') }}" alt="" />
                        </div>
                        <div class="info">
                            <p class="card_no">{{ $payment_gateway->title }}</p>
                            <p class="card_date"></p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <div class="paymentRight">
        <p class="payment_tab_title pb-30">{{ get_phrase('Package Details') }}</p>
        <div class="payment_table">
            <div class="table-responsive">
                <table class="table eTable eTable-2">
                    <tbody>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="dAdmin_info_name min-w-100px">
                                        <p>{{$package->name}}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="dAdmin_info_name min-w-150px text-end">
                                        <p>{{ currency($package->price) }}</p>
                                    </div>
                                </td>
                            </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="dAdmin_info_name min-w-100px">
                                    <p>{{ get_phrase('Total') }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="dAdmin_info_name min-w-100px text-end">
                                    <p>{{ currency($package->price) }}</p>
                                </div>
                            </td>
                        </tr>

                        

                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="dAdmin_info_name min-w-150px text-end">
                                    <p><span>{{ get_phrase('Grand Total') }}:
                                            {{ currency($package->price) }}</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Content -->
        <div class="tab-content">
            <div class="tab-pane fade show active text-end" id="showPaymentGatewayByAjax">
            </div>
        </div>
    </div>
</div>


<script src="https://checkout.flutterwave.com/v3.js"></script>
<script type="text/javascript">
    "use strict";

    function showPaymentGatewayByAjax(identifier) {
        $('#showPaymentGatewayByAjax').html(
            '<div class="w-100 text-center my-5"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>'
        );
        $.ajax({
            url: "{{ route('payment.show_payment_gateway_by_ajax', '') }}/" + identifier,
            success(response) {
                $('#showPaymentGatewayByAjax').html(response);
            }
        });
    }
</script>
