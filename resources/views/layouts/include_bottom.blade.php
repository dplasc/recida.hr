
    @include('layouts.modal')
    
    <script src="{{ asset('assets/frontend/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/vendors/nice-select/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/swiper-bundle.min.js') }}"></script>
    



    <!-- toastr js -->
    <script src="{{asset('plugin/toastr/toastr.min.js')}}"></script>
    {!! Toastr::message() !!}
 
    <script src="{{ asset('assets/frontend/js/script.js') }}"></script>  

    <script>
        "use strict";
         function validateSearch() {
           const type = document.getElementById('type').value;
           if (type === "") {
               warning("Please select a type to search!");
               return false;
           }
       return true;
   }
   </script>