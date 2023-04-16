<footer class="pt-3">
    <div class="container">
        <div class="row py-4 fs-5">
            <div class=" col-md-4">
                <a href="{{ route('homepage')}}">
                    <img src="{{ asset('images/company/'.\App\Models\CompanyDetail::where('id',1)->first()->header_logo)}}" width="200px">
                </a>
                <p class="my-3 lh-1"  style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44; font-weight:bold">Company registration number <b>987788888</b>  in England and Wales </p>
                <p class="mb-1 darkerGrotesque-semibold " style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44; font-weight:bold"><iconify-icon class="txt-primary"
                    icon="ic:outline-email"></iconify-icon> Email: {{\App\Models\CompanyDetail::where('id',1)->first()->email1 }}</p>

            </div>

            <div class="col-md-4">
                
                <div class="row mt-5">

                    <div class="col">
                        <ul class="footer-link ">
                            <li class=""><a href="{{ route('frontend.about')}}" style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44; font-weight:bold"> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"> </iconify-icon> About</a></li>
                            <li class=""><a href="{{ route('frontend.terms')}}" style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44; font-weight:bold"> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> T&C</a></li>
                            <li class=""><a href="{{ route('frontend.privacy') }}" style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44; font-weight:bold"> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col">
                    <ul class="footer-link ">
                        <li class=""><a href="{{ route('homepage')}}" style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44; font-weight:bold"> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> Home</a></li>
                        <li class=""><a href="#howwework" style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44; font-weight:bold"><iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> How we works</a></li>
                        <li class=""><a href="{{ route('frontend.faqs')}}" style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44; font-weight:bold"> <iconify-icon class="txt-primary" icon="material-symbols:arrow-forward-ios-rounded"></iconify-icon> FAQs</a>
                        </li>
                    </ul>
                    </div>
                    
                </div>


            </div>

            

            <div class=" col-md-4">
                <h4 class="txt-primary fw-bold mb-3 darkerGrotesque-semibold">About</h4>
                <p class="mb-1 darkerGrotesque-semibold " style="font-size: 19px;font-family: DarkerGrotesque-regular;color: #4E4B44;text-align: justify;line-height: 21px; font-weight:bold">
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