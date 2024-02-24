<aside class="left-sidebar">
    <div class="scroll-sidebar">
{{--        <div class="user-profile">--}}
{{--            <div class="profile-img"> <img src="{{asset('template/admin_template/assets/images/users/profile.png')}}" alt="user" />--}}
{{--                <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>--}}
{{--            </div>--}}
{{--            <div class="profile-text">--}}
{{--                <h5>{{Auth::user()->name}}</h5>--}}
{{--                <div class="dropdown-menu animated flipInY">--}}
{{--                    <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="/" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li> <a class=" waves-effect waves-dark" href="{{route('user.dashboard')}}" aria-expanded="false"><i class="mdi mdi-home"></i><span class="hide-menu font-15">Dashboard </span></a>
                </li>
                <li class="nav-small-cap">SERVICES</li>
                <li> <a class=" waves-effect waves-dark" href="{{route('service','envato')}}" aria-expanded="false"><img src="{{asset('template/admin_template/assets/images/envato_logo.png')}}" width="32px"><span class="hide-menu font-15 font-bold px-2"> Envato Elements </span></a>
                </li>
                <li> <a class=" waves-effect waves-dark" href="{{route('service','freepik')}}" aria-expanded="false"><img src="{{asset('template/admin_template/assets/images/freepik_logo.png')}}" width="32px"> <span class="hide-menu font-15 font-bold  px-2"> Free Pik </span> </a>
                </li>
                <li> <a class=" waves-effect waves-dark" href="{{route('service','motion-array')}}" aria-expanded="false"><img src="{{asset('template/admin_template/assets/images/motion-array_logo.png')}}" width="32px"> <span class="hide-menu font-15 font-bold  px-2"> Motion Array </span> </a>
                </li>
                <li class="nav-small-cap font-15">ACTIVATION</li>
                <li><a href="#" data-toggle="modal" data-target="#licenseKeyModal" data-whatever="LiceseKey" class="font-15 font-bold"> <i class="mdi mdi-key-plus"></i> <span class="hide-menu font-15 font-bold px-2"> License Key </span> </a></li>
                <li class="nav-small-cap font-15 font-bold"> <i class="mdi mdi-phone"></i> SUPPORTS</li>

                @php
                    $social =  \App\Models\SocialLink::get();
                @endphp

                @foreach($social as $social_list)
                <li class="p-1">
                    <a class="btn text-white" style="background: {{$social_list->button_color}}; text-align: left;" href="{{$social_list->goto_url}}" target="_blank" aria-expanded="false">
                        <div style="margin-left: 30px">
                            <img src="{{asset('uploads/social/'.$social_list->social_icon)}}" style="width: 30px"><span class="hide-menu font-15 font-bold px-2"> {{$social_list->name}} </span>
                        </div>
                    </a>
                </li>
                @endforeach

            </ul>
        </nav>
    </div>
</aside>
