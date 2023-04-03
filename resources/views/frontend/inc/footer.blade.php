<footer class="py-4">
    <div class="container">
        <div class="row">
            <div class="footer-link mt-4 pb-3">
                <a href="{{ route('homepage')}}">home</a>
                <a href="{{ route('frontend.about')}}">about</a>
                <a href="{{ route('frontend.contact')}}">contact</a>
                <a href="{{ route('register')}}">open an account</a>
                <a href="{{ route('login')}}">log in</a>
            </div>
            <p class="footer-bottom mt-3 mb-0">
                <span class="mx-4"><a href="{{ route('frontend.privacy') }}" style="color: #ffffff">Privacy Policy </a> </span> | <span class="mx-4"><a href="{{ route('frontend.terms')}}"  style="color: #ffffff">Terms of Use</a> </span> | <span class="mx-4"> {{\App\Models\CompanyDetail::where('id',1)->first()->address1 }}{{\App\Models\CompanyDetail::where('id',1)->first()->address2 }}</span> | <span class="mx-4">EMAIL: {{\App\Models\CompanyDetail::where('id',1)->first()->email1 }}</span> | <span class="mx-4"> (C) TAXDOCS </span>
            </p>
        </div>
    </div>
    <div class="col-lg-12 text-center">

        <span style="color: #ffffff">Copyright © 2023 TAXDOCS &nbsp;All Rights Reserved.<br>&nbsp;Design and
          Developed by . <a href="http://www.mentosoftware.co.uk" target="_blank"
            rel="lightbox noopener noreferrer">Mento Software</a></span>
      </div>
</footer>