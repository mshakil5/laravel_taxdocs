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
                        <div class="inner w-75">
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
                    <div class="col-lg-8">
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


<section class="bleesed default">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            
            <div class="title"><span class="txt-primary">Your Options</span> </div>
            <div class="row">

                <div class="col-lg-6 col-md-6 upperGap">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <div class="plan-title">Self Employed £5.95/Month</div>
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
                            <div class="plan-title">Limited Company £10.95/Month</div>
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