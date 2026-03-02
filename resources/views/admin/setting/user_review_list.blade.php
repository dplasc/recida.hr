
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Review') }}
                </h4>

                <a href="javascript:;" onclick="modal('modal-md', '{{route('admin.review.create')}}', '{{get_phrase('Add Review')}}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new Review') }}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mb-3 mt-3 row-gap-3">
                        <div class="col-lg-5 col-md-5 pt-2 pt-md-0"></div>
                        <div class="col-lg-7 col-md-7">
                            <form action="" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-lg-9 col-md-7">
                                        <div class="search-input">
                                            <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ get_phrase('Search reviews...') }}" class="ol-form-control form-control" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-5">
                                        <button type="submit" class="btn ol-btn-primary w-100">{{ get_phrase('Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Table -->
                        @if(count($user_reviews) > 0)
                        <div class="table-responsive">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Name') }}</th>
                                        <th scope="col">{{ get_phrase('Rating') }}</th>
                                        <th scope="col">{{ get_phrase('Review') }}</th>
                                        <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user_reviews as $key => $review)
                                    @php 
                                     $userInfo = DB::table('users')->where('id',$review->user_id)->first();  
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <p class="row-number">{{ $key + 1 }}</p>
                                        </th>
                                        <td>
                                            <div class="dAdmin_info_name min-w-150px">
                                                <p>{{ $userInfo?->name ?? '(unknown user)' }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dAdmin_info_name">
                                                <p>{{ $review->rating }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dAdmin_info_name">
                                                <p>{{ $review->review }}</p>
                                            </div>
                                        </td>
                                        <td class="print-d-none">
                                            <div class="adminTable-action">
                                                <a href="{{ route('admin.review.edit', ['id' => $review->id]) }}" class="btn ol-btn-light ol-icon-btn" data-bs-toggle="tooltip" title="{{ get_phrase('Edit') }}"><i class="fi-rr-pen-clip"></i></a>
                                                <button type="button" class="btn ol-btn-light ol-icon-btn" data-bs-toggle="tooltip" onclick="delete_modal('{{ route('admin.review.delete', ['id' => $review->id]) }}')" title="{{ get_phrase('Delete') }}"><i class="fi-rr-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">{{ get_phrase('Showing') . ' ' . count($user_reviews) . ' ' . get_phrase('of') . ' ' . $user_reviews->total() . ' ' . get_phrase('data') }}</p>
                            {{ $user_reviews->links() }}
                        </div>
                    @else
                       
                    @endif
                    <!-- Data info and Pagination -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Admin area -->

