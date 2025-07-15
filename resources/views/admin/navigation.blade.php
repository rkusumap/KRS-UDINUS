<ul class="sidebar-menu">
    @foreach ($moduleAppServiceProvider as $module)
        @php
            //role config
            $role_access = isAccess('read',$module->id_module,auth()->user()->level_user);
            if(!$role_access){continue;}
        @endphp
        @if (count($module->modules) > 0)
        {{-- menu jika punya child --}}
        <li class="dropdown
                        @if (collect($module->modules)->pluck('link_module')->filter(function($link) {
                            return Request::is(trim($link, '/')) || Request::is(trim($link, '/').'/*');
                        })->isNotEmpty())
                            active
                        @endif
                    ">
            <a href="#" class="nav-link has-dropdown">
                <i class="{{ $module->icon_module }}"></i>
                <span>{{ $module->name_module }}</span>
            </a>
            <ul class="dropdown-menu">
                @foreach ($module->modules as $chmod)
                    @php
                        //role config
                        $role_access = isAccess('read',$chmod->id_module,auth()->user()->level_user);
                        if(!$role_access){continue;}
                        $isActive = Request::is(trim($chmod->link_module, '/')) || Request::is(trim($chmod->link_module, '/').'/*');
                    @endphp
                    <li class="{{ $isActive ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url($chmod->link_module) }}">{{ $chmod->name_module }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
        {{-- end menu jika punya child --}}
        @endif

        @if (count($module->modules) == 0)
        {{-- menu jika tidak punya child --}}
            @if ((str_contains($module->link_module, '#mainheader')))
                <li class="menu-header">{{$module->name_module}}</li>
            @else
                @php
                    $isActive = Request::is(trim($module->link_module, '/')) || Request::is(trim($module->link_module, '/').'/*');
                @endphp
                <li class="{{ $isActive ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url($module->link_module) }}"><i class="{{$module->icon_module}}"></i> <span>{{$module->name_module}}</span></a>
                </li>
            @endif
        {{-- end menu jika tidak punya child --}}
        @endif
    @endforeach


</ul>
