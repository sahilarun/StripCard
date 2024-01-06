@extends('admin.layouts.master')

@push('css')
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('User Care'),
    ])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Edit KYC") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form">
                <div class="row align-items-center mb-10-none">
                    <div class="col-xl-4 col-lg-4 form-group">
                        <ul class="user-profile-list-three">
                            <li class="bg--base one">Full Name: <span>{{ $user->fullname }}</span></li>
                            <li class="bg--info two">Username: <span>{{ "@".$user->username }}</span></li>
                            <li class="bg--success three">Email: <span>{{ $user->email }}</span></li>
                            <li class="bg--warning four">Status: <span>{{ $user->stringStatus->value }}</span></li>
                            <li class="bg--danger five">Last Login: <span>{{ $user->lastLogin }}</span></li>
                        </ul>
                    </div>
                    <div class="col-xl-4 col-lg-4 form-group">
                        <div class="user-profile-thumb">
                            <img src="{{ $user->userImage }}" alt="user">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 form-group">
                        <ul class="user-profile-list">
                            <li class="bg--danger one">State: <span>{{ $user->address->state ?? "-" }}</span></li>
                            <li class="bg--warning two">Phone Number: <span>{{ $user->full_mobile }}</span></li>
                            <li class="bg--success three">Zip/Postal: <span>{{ $user->address->zip ?? "-" }}</span></li>
                            <li class="bg--info four">City: <span>{{ $user->address->city ?? "-" }}</span></li>
                            <li class="bg--base five">Country: <span>{{ $user->address->country ?? "-" }}</span></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="custom-card mt-15">
        <div class="card-header">
            <h6 class="title">{{ __("Information of Logs") }}</h6>
            <span class="{{ $user->kycStringStatus->class }}">{{ $user->kycStringStatus->value }}</span>
            @include('admin.components.link.custom',[
                'href'          => setRoute('admin.users.details',$user->username),
                'text'          => "Profile",
                'class'         => "btn btn--base",
                'permission'    => "admin.users.details",
            ])
        </div>
        <div class="card-body">
            @if ($user->kyc != null && $user->kyc->data != null)
                <ul class="product-sales-info">
                    @foreach ($user->kyc->data ?? [] as $item)
                        @if ($item->type == "file")
                            @php
                                $file_link = get_file_link("kyc-files",$item->value);
                            @endphp
                            <li>
                                <span class="kyc-title">{{ $item->label }}:</span>
                                @if ($file_link == false)
                                    <span>{{ __("File not found!") }}</span>
                                    @continue
                                @endif
                                
                                @if (its_image($item->value))
                                    <span class="product-sales-thumb">
                                        <a class="img-popup" data-rel="lightcase:myCollection" href="{{ $file_link }}">
                                            <img src="{{ $file_link }}" alt="{{ $item->label }}">
                                        </a>
                                    </span>
                                @else
                                    <span class="text--danger">
                                        @php
                                            $file_info = get_file_basename_ext_from_link($file_link);
                                        @endphp
                                        <a href="{{ setRoute('file.download',["kyc-files",$item->value]) }}" >
                                            {{ Str::substr($file_info->base_name ?? "", 0 , 20 ) ."..." . $file_info->extension ?? "" }}
                                        </a>
                                    </span>
                                @endif
                            </li>
                        @else
                            <li>
                                <span class="kyc-title">{{ $item->label }}:</span> 
                                <span>{{ $item->value }}</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="product-sales-btn">
                    @if ($user->kyc_verified != global_const()::VERIFIED)
                        @include('admin.components.button.custom',[
                            'type'          => "button",
                            'class'         => "approve-btn w-100",
                            'text'          => "Approve",
                            'permission'    => "admin.users.kyc.approve",
                        ])
                    @endif

                    @if ($user->kyc_verified != global_const()::REJECTED)
                        @include('admin.components.button.custom',[
                            'type'          => "button",
                            'class'         => "bg--danger reject-btn w-100",
                            'text'          => "Reject",
                            'permission'    => "admin.users.kyc.reject",
                        ])
                    @endif
                </div>
            @else
                <div class="alert alert-primary">{{ __("KYC Information not submitted yet") }}</div>
            @endif
        </div>
    </div>

    @include('admin.components.modals.kyc-reject',compact("user"))
@endsection

@push('script')
    <script>
        $(".approve-btn").click(function(){
            var actionRoute = "{{ setRoute('admin.users.kyc.approve',$user->username) }}";
            var target      = "{{ $user->username }}";
            var message     = `Are you sure to approve {{ "@" . $user->username }} KYC information.`;
            openDeleteModal(actionRoute,target,message,"Approve","POST");
        });
    </script>
@endpush
