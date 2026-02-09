<link href="{{asset('assets/frontend/css/nouislider.min.css')}}" rel="stylesheet">
<script src="{{asset('assets/frontend/js/nouislider.min.js')}}"></script>
<style>
    .noUi-touch-area, .noUi-tooltip {
        display: none !important;
    }
    .accordion-item-range .value {
        width: 100px;
        background: transparent;
        border: 0;
        margin-top: 6px;
        font-size: 16px;
    }
    .noUi-connect {
        background: #6C1CFF;
    }
    .noUi-horizontal {
        height: 8px;
    }
    .noUi-horizontal .noUi-handle {
        width: 20px;
        height: 20px;
        right: -10px;
        top: -7px;
        border-radius: 50%;
    }
    .noUi-handle:after, .noUi-handle:before {
        display: none;
    }
</style>