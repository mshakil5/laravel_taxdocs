<section class="siteHeader ">
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light py-0 ">
                <a class="navbar-brand" href="{{ route('homepage')}}">
                    <img src="{{ asset('images/company/'.\App\Models\CompanyDetail::where('id',1)->first()->header_logo)}}" class="py-2 img-fluid mx-auto" width="200px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav mx-auto navCustom">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.about')}}">About </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.contact')}}">Contact </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('register')}}">Open an account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="{{route('login')}}">Log in</a>
                        </li>

                    </ul>
                </div>

            </nav>

        </div>
    </div>
</section>