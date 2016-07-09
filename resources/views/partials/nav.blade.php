<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">{{ trans('Toggle Navigation') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/web/images/logo.png') }}"> LR CRM</a>
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @if(isset($balance))
            <ul class="nav navbar-top-links navbar-left flip">
                <li><a class="text-danger"><i class="fa fa-times-circle"></i> {{$balance[0]}} </a></li>
                <li><a><i class="fa fa-copyright bg-blue"></i> {{$balance[1]}} credits</a></li>
            </ul>
            @endif
            <ul class="nav navbar-top-links navbar-right language_bar_chooser flip">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language"></i> {{ trans('site/site.languages') }} <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @if (Sentinel::guest())
                    <li class="{{ (Request::is('auth/login') ? 'active' : '') }}"><a href="{{ URL::to('auth/login') }}"><i
                                    class="fa fa-sign-in"></i> Login</a></li>
                    <!--<li class="{{ (Request::is('auth/register') ? 'active' : '') }}"><a
                                href="{{ URL::to('auth/register') }}">Register</a></li>-->
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"><i class="fa fa-user"></i> {{ Sentinel::getUser()->name }} <i
                                    class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu" role="menu">
                                @if(Sentinel::inRole('administrator'))
                                    <li>
                                        <a href="{{ route('admin.index') }}"><i class="fa fa-tachometer"></i> Admin Dashboard</a>
                                    </li>
                                    <li role="presentation" class="divider"></li>
                                @endif
                            <li>
                                <a href="{{ URL::to('auth/logout')}}"><i class="fa fa-sign-out"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    @section('sidebar')
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{ route('agent.lead.create') }}" class="dialog"><i class="icon icon-add-user"></i>@lang('site/sidebar.add_lead')</a>
                </li>
                <li>
                    <a href="{{ route('agent.sphere.index') }}"><i class="fa fa-sitemap"></i> Filtration customer</a>
                </li>
                <li>
                    <a href="{{ route('agent.lead.obtain')  }}"><i class="icon icon-buy"></i>@lang('site/sidebar.lead_obtain')</a>
                </li>
                <li>
                    <a href="{{ route('agent.lead.deposited')  }}"><i class="icon icon-sell"></i>@lang('site/sidebar.lead_deposit')</a>
                </li>
                <li>
                    <a href="#"><i class="icon icon-document"></i>@lang('site/sidebar.lead_opened')</a>
                </li>
                <li>
                    <a href="{{ route('agent.salesman.index') }}"><i class="fa fa-users"></i> Salesmen</a>
                </li>
                <hr/>
                <li>
                    <a href="{{ route('operator.sphere.index') }}" ><i class="fa fa-list"></i> Leads filter</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
    @show
</nav>