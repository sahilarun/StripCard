@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder {
            min-height: 194px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 150px !important;
        }
    </style>
@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Setup FAQ")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Setup FAQ") }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.link.add-default',[
                        'text'          => "Add FAQ",
                        'href'          => "#faq-add",
                        'class'         => "modal-btn",
                        'permission'    => "admin.setup-sections.section.item.store",
                    ])
                </div>
            </div>
            <div class="table-responsive">
                @include('admin.components.data-table.faq-table',[
                    'data'  => $allFaq
                ])
            </div>
        </div>
        {{ get_paginate($allFaq) }}
    </div>

    {{-- faq Edit Modal --}}
    @include('admin.components.modals.edit-faq')

    {{-- answer details --}}
    @include('admin.components.modals.faq-info')

    {{-- faq Add Modal --}}
    @include('admin.components.modals.faq-add')

@endsection

@push('script')
    <script>
        function keyPressCurrencyView(select) {
            var selectedValue = $(select);
            selectedValue.parents("form").find("input[name=code],input[name=currency_code]").keyup(function(){
                selectedValue.parents("form").find(".selcted-currency").text($(this).val());
            });
        }

        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var actionRoute =  "{{ setRoute('admin.setup.sections.faq.delete') }}";
            var target      = oldData.id;
            var message     = `Are you sure to delete <strong>${oldData.question}</strong> Faq?`;
            openDeleteModal(actionRoute,target,message);
        });
    </script>
@endpush
