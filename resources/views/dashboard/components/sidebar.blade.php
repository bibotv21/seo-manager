<div class="left-side-wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" src="{{ asset('assets/imgs/piter-logo.png') }}" />
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Piter</strong>
                                </span> </a>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>

                @foreach (config('terms.sidebar') as $key => $val)
                    <li class="{{ request()->segment(1) == $key ? 'active' : '' }}">
                        @if ($val['sub_menu'])
                            <a href="{{ $val['route'] }}"><i class="{{ $val['icon'] }}"></i> <span
                                    class="nav-label">{{ $val['title'] }}</span><span class="fa arrow"></span></a>
                            @foreach ($val['sub_menu'] as $sub_key => $sub_val)
                                <ul class="nav nav-second-level collapse">
                                    <li class="{{ request()->segment(2) == $sub_key ? 'active' : '' }}"><a
                                            href="{{ $sub_val['route'] }}">{{ $sub_val['title'] }}</a></li>
                                </ul>
                            @endforeach
                        @else
                            <a href="{{ $val['route'] }}"><i class="{{ $val['icon'] }}"></i> <span
                                    class="nav-label">{{ $val['title'] }}</span></span></a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</div>
