<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <div class="user-profile">
            <div class="profile-img"> <img src="{{asset('template/admin_template/assets/images/users/profile.png')}}" alt="user" />
                <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
            </div>
            <div class="profile-text">
                <h5>{{Auth::user()->name}} (admin)</h5>
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
                <li class="nav-small-cap">SERVICES STATS</li>
                <li> <a class=" waves-effect waves-dark" href="#" aria-expanded="false"><img src="{{asset('template/admin_template/assets/images/envato_logo.png')}}" width="32px"><span class="hide-menu"> Envato </span></a>
                </li>
                <li> <a class=" waves-effect waves-dark" href="#" aria-expanded="false"><img src="{{asset('template/admin_template/assets/images/freepik_logo.png')}}" width="32px"> <span class="hide-menu">Free Pik </a>
                </li>
                <li class="nav-small-cap">ACTIVATION</li>
                <li><a href="#" data-toggle="modal" data-target="#licenseKeyModal" data-whatever="LiceseKey"> <i class="mdi mdi-key-plus"></i> Create License </a></li>
                <li><a class=" waves-effect waves-dark" href="{{route('admin.licenseList')}}" aria-expanded="false"><i class="mdi mdi-key"></i> License List </a></li>
                <li class="nav-small-cap">USER MANAGE</li>
                <li> <a class=" waves-effect waves-dark" href="{{route('admin.userList')}}" aria-expanded="false"><i class="mdi mdi-face-profile"></i><span class="hide-menu"> User List  </span></a>
                </li>
                <li class="nav-small-cap">SETTINGS</li>
                    <li> <a class=" waves-effect waves-dark" href="{{route('admin.setCookie')}}" aria-expanded="false"><i class="mdi mdi-codepen"></i><span class="hide-menu"> Cookie  </span></a>
                    </li>
                    <li> <a class=" waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-phone"></i><span class="hide-menu"> Support </span></a>
                    </li>
            </ul>
        </nav>
    </div>
</aside>
