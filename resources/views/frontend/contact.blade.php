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
                        <div class="ermsg"></div>
                        <div class="form-custom"> 
                            <div class="form-group">
                                <input class="form-control" type="text" id="name" name="name" placeholder="Name"> 
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" id="email" name="email" placeholder="Email"> 
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="subject" name="subject" placeholder="Subject"> 
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" id="message" name="message" placeholder="Message"></textarea> 
                            </div>
                            <div class="form-group">
                                <button id="submit" class="btn-theme bg-primary">Send</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('front/images/contact page top 1.svg')}}" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="default contactInfo" style="display: none">
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


<section class="client faq default " id="faq"  style="display: none">
    <div class="container">
        <div class="row">
            <div class="title txt-primary">
                Frequently asked questions:
            </div>
            <br>
            <div class="mt-5">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                How do you charge and how much?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora quos fugiat nostrum voluptas quas laboriosam explicabo harum illo deleniti cupiditate optio hic iure, quae officia.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How can I check how much money I have in my charity account?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora quos fugiat nostrum voluptas quas laboriosam explicabo harum illo deleniti cupiditate optio hic iure, quae officia.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Can I donate to charities abroad with my Donation account?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora quos fugiat nostrum voluptas quas laboriosam explicabo harum illo deleniti cupiditate optio hic iure, quae officia.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                When will my donation reach the recipient?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora quos fugiat nostrum voluptas quas laboriosam explicabo harum illo deleniti cupiditate optio hic iure, quae officia.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                What is GiftAid and how does it work?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Gift aid is an arrangement between the government and charities in the United
                                Kingdom where charities can claim back basic rate tax on donations from qualifying
                                donors. This means that for every pound donated by a qualifying donor, the charity
                                can reclaim 25p from HMRC.

                                For example, if somebody donates £100 to a charity, the charity can reclaim an
                                additional £25 from HM Revenue and Customs (HMRC), making the total value of the
                                donation £125.

                                The system works by the taxpayer completing a self-assessment form (known as a Gift
                                Aid declaration) which authorises the charity to reclaim tax on their behalf. The
                                money is then paid back to the charity by HMRC.

                                At Donation, we’ll do that for you. You just need to open an account and we’ll make
                                sure that your donation is increased by 25%.

                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="w-100 d-flex align-items-center justify-content-center">
                <a href="#" class="mx-auto mt-5 btn-theme bg-secondary ">Ask another question</a>
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')
<script>
     $(document).ready(function () {


 //header for csrf-token is must in laravel
 $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

            //  make mail start
            var url = "{{URL::to('/contact-submit')}}";
            $("#submit").click(function(){

                    var name= $("#name").val();
                    var email= $("#email").val();
                    var subject= $("#subject").val();
                    var message= $("#message").val();
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {name,email,subject,message},
                        success: function (d) {
                            if (d.status == 303) {
                                $(".ermsg").html(d.message);
                            }else if(d.status == 300){
                                $(".ermsg").html(d.message);
                                window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error: function (d) {
                            console.log(d);
                        }
                    });

            });
            // send mail end


});
</script>
@endsection