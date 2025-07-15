<ul class="navbar-nav navbar-right">
    {{-- notifikasi --}}
    {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notifications
          <div class="float-right">
            <a href="#">Mark All As Read</a>
          </div>
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
          <a href="#" class="dropdown-item dropdown-item-unread">
            <div class="dropdown-item-icon bg-primary text-white">
              <i class="fas fa-code"></i>
            </div>
            <div class="dropdown-item-desc">
              Template update is available now!
              <div class="time text-primary">2 Min Ago</div>
            </div>
          </a>



        </div>
        <div class="dropdown-footer text-center">
          <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li> --}}
    {{-- end notifikasi --}}
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        @php
            if (auth()->user()->img_user == null) {
                $img = '/file/img/static/avatar.png';
            } else {
                $img = '/file/img/profile/'. auth()->user()->img_user;
            }
        @endphp
        <img alt="image" src="{{ $img }}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{auth()->user()->name}}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
            @php
                $time = auth()->user()->last_login_at?->diffForHumans();
                $short = str_replace(['minutes', 'minute', 'seconds', 'second', 'hours', 'hour'], ['min', 'min', 'sec', 'sec', 'hr', 'hr'], $time);
            @endphp
            <div class="dropdown-title">Logged in {{ $short }}</div>
            <a href="{{ url('profile') }}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profile
            </a>
            {{-- <a href="features-settings.html" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Settings
            </a> --}}
            <div class="dropdown-divider"></div>
            <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </li>
</ul>
