<div class="row">
    <div class="col-12">
        <div class="card noDataCard">
            <div class="card-body">
                <img src="{{asset('assets/frontend/images/empty-folder 1.svg')}}" alt="...">
                <h3>{{get_phrase('No Result Found')}}</h3>
                <p>{{get_phrase('No Data were found matching your selection.')}}</p>
                <a href="{{url()->previous()}}" class="noDataBtn">{{get_phrase('Go Back')}}</a>
            </div>
        </div>
    </div>
</div>