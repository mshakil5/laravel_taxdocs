<footer class="pt-3">
    <div class="container">
        <div class="row py-4 fs-5">
            <div class=" col-md-4 mb-3 ">
                <a href="{{ route('homepage')}}">
                    <img src="{{ asset('images/company/'.\App\Models\CompanyDetail::where('id',1)->first()->header_logo)}}" width="200px">
                </a>
                <p class="fw-bold my-3 darkerGrotesque-bold lh-1">Company registration number 987788888 in England and Wales </p>
                <p class="mb-1 darkerGrotesque-semibold " style="font-size: 20px;font-family: Roboto-Regular;color: #4E4B44;"><iconify-icon class="txt-primary"
                    icon="ic:outline-email"></iconify-icon> Email: {{\App\Models\CompanyDetail::where('id',1)->first()->email1 }}</p>

            </div>

            <div class="col-md-4 mb-3">
                
                <div class="row">

                    <div class="col">
                        <ul class="footer-link ">
                            <li class="mb-2"><a href="{{ route('frontend.about')}}" class=""> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> About</a></li>
                            <li class="mb-2"><a href="{{ route('frontend.terms')}}" class=""> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> T&C</a></li>
                            <li class="mb-2"><a href="{{ route('frontend.privacy') }}" class=""> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col">
                    <ul class="footer-link ">
                        <li class="mb-2"><a href="{{ route('homepage')}}" class=""> 
                            <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> Home</a></li>
                        <li class="mb-2"><a href="#howwework"><iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> How we works</a></li>
                        <li class="mb-2"><a href="{{ route('frontend.faqs')}}" class=""> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> FAQs</a>
                        </li>
                    </ul>
                    </div>
                    
                </div>


            </div>



            <div class=" col-md-4 mb-3">
                <h4 class="txt-primary fw-bold mb-3 darkerGrotesque-semibold">About</h4>
                <p class="mb-1 darkerGrotesque-semibold " style="font-size: 20px;font-family: Roboto-Regular;color: #4E4B44;">
                    {{\App\Models\CompanyDetail::where('id',1)->first()->footer_content }}
                </p>
            </div>


        </div>
    </div>
</footer>
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="d-flex flex-column flex-sm-row justify-content-between py-3">
                <small class="mb-0 text-dark  ">© 2022 Company, Inc. All rights reserved.</small>
                <ul class="social">
                    <li><a href=""><iconify-icon class="txt-primary" icon="ic:baseline-facebook"></iconify-icon></a>
                    </li>
                    <li><a href=""><iconify-icon class="txt-primary" icon="mdi:twitter"></iconify-icon></a></li>
                    <li><a href=""><iconify-icon class="txt-primary" icon="mdi:pinterest"></iconify-icon></a></li>
                    <li><a href=""><iconify-icon class="txt-primary" icon="mdi:linkedin"></iconify-icon></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- <footer class="py-4">
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
</footer> --}}