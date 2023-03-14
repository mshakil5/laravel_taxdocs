@extends('frontend.layouts.master')

@section('css')
@endsection

@section('content')



    <!-- about us section -->
<section class="bleesed default">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">

            <div class="title">{{ \App\Models\Master::where('id','3')->first()->title }}</div>
            <div class="para text-center my-5">
                {!! \App\Models\Master::where('id','3')->first()->description !!}
            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
@endsection