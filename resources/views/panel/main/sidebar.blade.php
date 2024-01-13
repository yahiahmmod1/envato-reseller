<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <div class="user-profile">
            <div class="profile-img"> <img src="{{asset('template/admin_template/assets/images/users/profile.png')}}" alt="user" />
                <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
            </div>
            <div class="profile-text">
                <h5>Markarn Doe</h5>
                <div class="dropdown-menu animated flipInY">
                    <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="/" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li> <a class=" waves-effect waves-dark" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="mdi mdi-home"></i><span class="hide-menu">Dashboard </span></a>
                </li>
                <li class="nav-small-cap">SERVICES</li>
                <li> <a class=" waves-effect waves-dark" href="{{route('service','envato')}}" aria-expanded="false"><img src="{{asset('template/admin_template/assets/images/envato_logo.png')}}" width="32px"><span class="hide-menu"> Envato </span></a>
                </li>
                <li> <a class=" waves-effect waves-dark" href="{{route('service','freepik')}}" aria-expanded="false"><img src="{{asset('template/admin_template/assets/images/freepik_logo.png')}}" width="32px"> <span class="hide-menu">Free Pik </a>
                </li>
                <li class="nav-small-cap">ACTIVATION</li>
                <li><a href="#" data-toggle="modal" data-target="#licenseKeyModal" data-whatever="LiceseKey"> License Key </a></li>
                <li class="nav-small-cap">Info</li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-wan"></i><span class="hide-menu">Supports </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href=""> <button class="btn btn-warning"> <i class="mdi mdi-whatsapp"></i> Whatsapp</button> </a></li>
                        <li><a href=""> <button class="btn btn-info"> <i class="mdi mdi-near-me"></i> Telegram</button> </a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
