@extends('frontend.layouts.master')

@section('css')
@endsection

@section('content')



<section class="contact py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="title mb-5">
                            Contact us today:
                        </div>
                        <div class="theme-para ">
                            Fill out the form below and we’ll get back to you as   soon as we can.
                        </div>
                        <form action="" class="form-custom"> 
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Name"> 
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Email"> 
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Subject"> 
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Message"></textarea> 
                            </div>
                            <div class="form-group">
                                <a href="#" class="btn-theme bg-primary">Send</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('front/images/contact page top 1.svg')}}" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="default contactInfo">
    <div class="container">
        <div class="row ">
            <div class="col-lg-3 d-flex flex-column align-items-center">
                <div class="paratitle text-center">Phone</div>
                <p class="theme-para text-center">  {{\App\Models\CompanyDetail::where('id',1)->first()->phone1 }}  </p>
                <a href="#" class="btn-theme bg-primary btn-line">Call</a>
            </div>
            <div class="col-lg-3 d-flex flex-column align-items-center">
                <div class="paratitle text-center">Whatsapp</div>
                <p class="theme-para text-center">  {{\App\Models\CompanyDetail::where('id',1)->first()->phone2 }}  </p>
                <a href="#" class="btn-theme bg-primary btn-line">Message</a>
            </div>
            <div class="col-lg-3 d-flex flex-column align-items-center">
                <div class="paratitle text-center">Email</div>
                <p class="theme-para text-center"> {{\App\Models\CompanyDetail::where('id',1)->first()->email1 }}  </p>
                <a href="#" class="btn-theme bg-primary btn-line">Email</a>
            </div>
            <div class="col-lg-3 d-flex flex-column align-items-center">
                <div class="paratitle text-center">Address</div>
                <p class="theme-para text-center"> {{\App\Models\CompanyDetail::where('id',1)->first()->address1 }} <br>
                    {{\App\Models\CompanyDetail::where('id',1)->first()->address2 }}</p>
                <a href="#" class="btn-theme bg-primary btn-line">Visit</a>
            </div>
            
        </div>
    </div>
</section>




@endsection

@section('scripts')
@endsection