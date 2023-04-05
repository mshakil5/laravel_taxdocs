@extends('frontend.layouts.master')

@section('css')
@endsection

@section('content')

<section class="banner py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-center">
                        <img src="{{ asset('front/images/taxdocs.svg')}}" class="img-fluid mx-auto" alt="">
                    </div>
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="inner w-75" style="font-size: 20px; font-family: Roboto-Regular; color: #4E4B44;">
                            <div class="intro-title">
                                {{ \App\Models\Master::where('id','4')->first()->title }}
                            </div>
                            <p class="txt-theme mb-4">{!! \App\Models\Master::where('id','4')->first()->description !!}</p>
                            <div>
                                <a href="{{ route('register')}}" class="btn-theme bg-secondary">Open an account</a>
                                <a href="#howwework" class="btn-theme bg-primary">How it works</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- about us section  --}}
<section class="bleesed default">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">

            <div class="title">{{ \App\Models\Master::where('id','1')->first()->title }}</div>
            <div class="para text-center my-5">
                {!! \App\Models\Master::where('id','1')->first()->description !!}
            </div>
            {{-- <img src="{{ asset('front/images/down-arrow-01.svg')}}" class="arrow"> --}}

        </div>
    </div>
</section>
{{-- How we works section  --}}
<section class="help default" id="howwework">
    <div class="container">
        <div class="row">
            <div class="title">
                How we works
            </div>
        </div>
        <div class="row">

            @foreach (\App\Models\HowWeWork::orderby('id','DESC')->limit(4)->get() as $work)

            <div class="col-lg-6 col-md-6 upperGap">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="{{ asset('images/'.$work->image)}}" class="arrow">
                    </div>
                    <div class="col-lg-8" style="font-size: 20px; font-family: Roboto-Regular; color: #4E4B44;">
                        <div class="paratitle">{{ $work->title }}</div>
                        <p class="theme-para">
                            {!! $work->description !!}
                        </p>
                        <a href="{{ route('frontend.workDetails', $work->id)}}" class="btn-theme bg-primary btn-line">Get started</a>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
</section>

{{-- new section start  --}}




<section class="bleesed default">
    <div class="container-fluid">
        <div class="row mb-5"> 
            <div class="title">
                Our Plan
            </div> 
        </div>
        <br> 
        <div class="row ">
            <div class=" mx-auto">
                <div class="row gx-1">
                    <div class="col-md-4">
                        <div class="plan p-4 mb-3 rounded shadow-sm plan-bg-1">
                            <div class="text-center border-bottom">
                                <a href="{{route('register')}}" style="text-decoration: none"><h3 class="txt-primary fw-bold">Individual Plan</h3></a>
                                 
                                 <h4 class="txt-secondary fw-bold mb-3">£5.95/Month</h4>
                            </div>
                            <div class="planContent pt-4 text-center">
                                @foreach (\App\Models\Option::where('plan','1')->get() as $item)
                                <p class="optionItems">{{ $item->title }}  </p>
                                @endforeach
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="plan p-4 mb-3 rounded shadow-sm plan-bg-3">
                            <div class="text-center border-bottom">
                                <a href="{{route('register')}}" style="text-decoration: none"><h3 class="txt-primary fw-bold">Standard Business Plan</h3>
                                </a>
                                 <h4 class="txt-secondary fw-bold mb-3">£10.95/Month</h4>
                            </div>
                            <div class="planContent pt-4 text-center">
                                
                                @foreach (\App\Models\Option::where('plan','2')->get() as $item2)
                                <p class="optionItems">{{ $item2->title }} </p>
                                @endforeach

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="plan p-4 mb-3 rounded shadow-sm plan-bg-2">
                            <div class="text-center border-bottom">
                                <a href="{{route('register')}}" style="text-decoration: none"><h3 class="txt-primary fw-bold">Premier Business Plan</h3>
                                </a>
                                 
                                 <h4 class="txt-secondary fw-bold mb-3">£15.95/Month</h4>
                            </div>
                            <div class="planContent pt-4 text-center">

                                @foreach (\App\Models\Option::where('plan','3')->get() as $item2)
                                <p class="optionItems">{{ $item2->title }} </p>
                                @endforeach
                                 
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<section class="advertisement default fs-5">
    <div class="container">
       <div class="row col-lg-10 mx-auto">
     <div class="row">
        <div class="col-lg-4">
            <h2 class="txt-primary fw-bold mb-4">Download Apps</h2>
            <a href="#">
                <img src="{{ asset('front/images/apps.png')}}" class="img-fluid mb-2">
            </a>
           <a href="#">
            <img src="{{ asset('front/images/play.png')}}" class="img-fluid mb-2">
           </a>
        </div>
        <div class="col-lg-8 pt-4">
            <p class="text-dark mb-1 darkerGrotesque-semibold " style="font-size: 20px; font-family: Roboto-Regular; color: #4E4B44;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam natus vel dolorem, dicta inventore sed excepturi, harum veniam maxime officiis officia a! Nisi totam magnam incidunt molestiae, eum corporis minus.</p>
            <div class="d-flex mt-2 txt-primary darkerGrotesque-semibold shadow-sm px-3 py-1">
                <a href="#" class="me-2 px-0 txt-primary fw-bold" title="link">some</a>
                <a href="#" class="me-2 px-0 txt-primary fw-bold" title="link">link</a>
                <a href="#" class="me-2 px-0 txt-primary fw-bold" title="link">goes</a>
                <a href="#" class="me-2 px-0 txt-primary fw-bold" title="link">here</a>
            </div>
        </div>
     </div>
       </div>
    </div>
</section>
{{-- new section end --}}
<section class="bleesed default" style="display: none">
    <div class="container">
        <div class="row mb-5"> 
            <div class="title">
                Our Plan
            </div> 
        </div>
        <br> 
        <div class="row ">
            <div class="col-lg-12 mx-auto">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="plan p-5 mb-3 rounded shadow-sm">
                            <div class="text-center border-bottom">
                                 <h3 class="txt-primary fw-bold" style="font-size: 40px">Self Employed</h3>
                                 <h4 class="txt-secondary fw-bold">£5.95/Month</h4>
                            </div>
                            <div class="planContent pt-4 text-left">

                                @foreach (\App\Models\Option::where('plan','1')->get() as $item)
                                
                                <p class="fs-5 mb-1 text-dark fw-bold" style="font-family: Roboto-Regular;">
                                    {{ $item->title }}
                                </p>
                                @endforeach
                                
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">

                        <div class="plan p-5 mb-3 rounded shadow-sm">
                            <div class="text-center border-bottom">
                                 <h3 class="txt-primary fw-bold" style="font-size: 40px">Business</h3>
                                 <h4 class="txt-secondary fw-bold">£10.95/Month</h4>
                            </div>
                            <div class="planContent pt-4 text-left">
                                
                                @foreach (\App\Models\Option::where('plan','2')->get() as $item2)
                                <p class="fs-5 mb-1 text-dark fw-bold" style="font-family: Roboto-Regular;">
                                    {{ $item2->title }}
                                </p>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bleesed default" style="display: none">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            
            <div class="title"><span class="txt-primary">Your Options</span> </div>
            <div class="row">

                <div class="col-lg-6 col-md-6 upperGap">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <div class="plan-title text-center">Self Employed £5.95/Month</div>
                            <ul class="list-theme">

                                @foreach (\App\Models\Option::where('plan','1')->get() as $item)
                                <li>{{ $item->title }}</li>
                                @endforeach


                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 upperGap">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="plan-title text-center">Limited Company £10.95/Month</div>
                            <ul class="list-theme">
                                @foreach (\App\Models\Option::where('plan','2')->get() as $item2)
                                <li>{{ $item2->title }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
    
            </div>

        </div>
    </div>
</section>


    
@endsection

@section('scripts')
@endsection