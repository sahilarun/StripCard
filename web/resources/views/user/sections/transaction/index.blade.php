@extends('user.layouts.master')

@push('css')

@endpush

@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Transactions")])
@endsection

@section('content')

    <div class="body-wrapper">
        <div class="dashboard-area mt-10">
            <div class="dashboard-header-wrapper">
                <h3 class="title">{{ __(@$page_title) }}</h3>
                <div class="header-search-wrapper">
                    <div class="position-relative">
                        <input class="form-control" type="text" name="search" placeholder="Ex: Transaction, Add Money" aria-label="Search">
                        <span class="las la-search"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-list-wrapper">


        <div class="dashboard-list-area item-wrapper mt-20">
            @include('user.components.transaction-log',compact("transactions"))
        </div>
    </div>

    </div>
@endsection

@push('script')
    <script>

        var searchURL = "{{ setRoute('user.transactions.search') }}";

        var timeOut;
        $("input[name=search]").bind("keyup",function(){
            clearTimeout(timeOut);
            timeOut = setTimeout(executeLogSearch, 500,$(this));
        });

        function executeLogSearch(input) {
            // Ajax request
            var searchText = input.val();
            if(searchText.length == 0) {
                $(".search-result-item-wrapper").remove();
                $(".item-wrapper").removeClass("d-none");
            }

            if(searchText.length < 1) {
                return false;
            }

            var data = {
                _token      : laravelCsrf(),
                text        : searchText,
            };
            $.post(searchURL,data,function(response) {
                //response
            }).done(function(response){
                console.log(response);
                $(".search-result-item-wrapper").remove();
                $(".item-wrapper").addClass("d-none");

                $(".dashboard-list-wrapper").append(`
                    <div class="search-result-item-wrapper">
                        ${response}
                    </div>
                `);

            }).fail(function(response) {
                throwMessage('error',["Something went worng! Please try again."]);
            });
        }
    </script>
@endpush
