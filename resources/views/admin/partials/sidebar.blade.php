<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">

        <ul class="nav" id="side-menu">
            <!--<li>
                <a href="{{ route('home') }}"><i class="fa fa-backward"></i> Go to frontend</a>
            </li>-->
            <li>
                <a href="{{ route('admin.index') }}">
                    <i class="fa fa-dashboard fa-fw"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.sphere.index') }}">
                    <i class="fa fa-list"></i> Sphere of influence
                </a>
            </li>
            <li>
                <a href="{{ route('admin.sphere.reprice') }}">
                    <i class="fa fa-list"></i> Sphere filtration re-price
                </a>
            </li>
            <li>
                <a href="{{ route('admin.user.index') }}">
                    <i class="glyphicon glyphicon-user"></i> Users
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav collapse">
                    <li>
                        <a href="{{ route('admin.user.index') }}">
                            <i class="glyphicon glyphicon-list"></i> All users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.agent.index') }}">
                            <i class="glyphicon glyphicon-star"></i> Agents
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.agent.index') }}">
                            <i class="glyphicon glyphicon-star"></i> Operators
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
            </li>
        </ul>
    </div>
</div>