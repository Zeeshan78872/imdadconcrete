<header>
    <nav class="navbar navbar-expand-md navbar-light bg-white  d-none d-lg-block">
        <div class="container">
            <a class="navbar-brand" style="width: 136px;" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.svg') }}" class="img-fluid" alt="image desc">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li>
                        <div class="input-group p-2">
                            <input type="search" class="form-control" placeholder="Search..." aria-label="Search..."
                                aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="button" id="button-addon2">Search</button>
                        </div>

                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.view') }}">
                                    Edit Account
                                </a>
                                <a class="dropdown-item" href="{{ route('user.view') }}">
                                    View User Listing
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-md navbar-light bg-blue" id="main_navbar">
        <div class="container">
            <a class="navbar-brand d-block d-md-block d-lg-none " href="{{ url('/') }}" style="width: 136px;">
                <img src="{{ asset('img/logo.svg') }}" class="img-fluid" alt="image desc">
            </a>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav main-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/dashboard"><i
                                class="fa-solid fa-grip-vertical me-1"></i><span>Dashboard</span></a>
                    </li>
                    {{-- Stock Management  --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-chart-bar me-1"></i> Stock Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {{-- Add / View Stock --}}
                            <li>
                                <a class="dropdown-item" href="#">
                                    Add / View Stock <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            Tuff Tiles and Blocks <i class="right-icon fa-solid fa-caret-right"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-submenu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('tuffTile.create') }}">Add
                                                    Stock
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('tuffTile.index') }}">View
                                                    Stock Listing</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            Chemical Concrete Pavers <i class="right-icon fa-solid fa-caret-right"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-submenu">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('chemicalTiles.create') }}">Add
                                                    Stock
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('chemicalTiles.index') }}">View
                                                    Stock Listing</a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            {{-- In / Out Stock Summary --}}
                            <li>
                                <a class="dropdown-item" href="#">
                                    In / Out Stock Summary <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">

                                    <li>
                                        <a class="dropdown-item" href="{{ route('tuffTile.InOutSummery') }}">Tuff
                                            Tiles and Blocks
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('chemicalTiles.InOutSummery') }}">Chemical
                                            Concrete Pavers</a>
                                    </li>
                                </ul>
                            </li>
                            {{-- Current Stock --}}
                            <li>
                                <a class="dropdown-item" href="#">
                                    Current Stock <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">

                                    <li>
                                        <a class="dropdown-item" href="{{ route('currentStock', 'tuffTile') }}">Tuff
                                            Tiles and Blocks
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('currentStock', 'chemicalTiles') }}">Chemical
                                            Concrete Pavers</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- Dispatch Order(Bilti)  --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-regular fa-square"></i> Dispatch Order(Bilti)
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="#">
                                    Tuff Tiles & Blocks <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('DtuffTile.create') }}">Add
                                            Dispatched Orders (Create Bilti)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('DtuffTile.index') }}">View
                                            Dispatched Orders (Create Bilti)</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    Commercial Concrete Pavers <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">

                                    <li>
                                        <a class="dropdown-item" href="{{ route('DchemicalTiles.create') }}">Add
                                            Dispatched Orders (Create Bilti)</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('DchemicalTiles.index') }}">View
                                            Dispatched Orders (Create Bilti)</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- payment --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-regular fa-clipboard me-1"></i> Payment
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="#">
                                    Received Payments <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('payment.create') }}">Add a Received
                                            Payment Record
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('payment.index') }}">View a Received
                                            Payment History</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- customer --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-users me-1"></i> Customers
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('customer.create') }}">Add a Customer</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('customer.index') }}">View Existing
                                    Customers</a></li>
                        </ul>
                    </li>
                    {{-- Raw Materials --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-file-circle-plus"></i> Raw Materials
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="#">
                                    Cement <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cement.create') }}">Add Incoming
                                            Stock
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cement.index') }}">View Cement Stock
                                            Details</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cement.current') }}">Cement Packs
                                            Usage Summary</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    Gravel and Sand <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('gravelSand.create') }}">Add Incoming
                                            Stock
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('gravelSand.index') }}">View Stock
                                            Listings</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    {{-- invoice --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-file-invoice me-1"></i> Invoice
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('invoice.create') }}">Create Invoice</a></li>
                            <li><a class="dropdown-item" href="{{ route('invoice.index') }}">View Invoice Listing</a>
                            </li>
                        </ul>
                    </li>
                    {{-- Others --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-rectangle-list"></i> Others
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="#">
                                    Users <i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.create') }}">Add a Users
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.index') }}">View Registered
                                            Users</a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    Products<i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('product.create') }}">Add a Product
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('product.index') }}">View Exsisting
                                            Products</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    Banks<i class="right-icon fa-solid fa-caret-right"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-submenu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('bank.create') }}">Add a Bank
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('bank.index') }}">View All Exsisting
                                            Banks</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item d-md-block d-lg-none">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item d-md-block d-lg-none">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown d-md-block d-lg-none">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.view') }}">
                                    View User Listing
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
