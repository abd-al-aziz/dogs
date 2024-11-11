@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="banner-section bg_img">
    {{-- data-background="{{getImage(getFilePath('frontend').'/banner/'.$banner->data_values->background_image)}}"> --}}
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6">
                <div class="banner-content">
                    <h1 class="title">{{__($banner->data_values->heading)}}</h1>
                    <p>{{__($banner->data_values->description)}}</p>
                    <div class="banner-btn">
                        <a href="{{ route('home').$banner->data_values->button_url }}"
                            class="btn--base color-rev">{{__($banner->data_values->button_text)}}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="banner-right-img">
                    <img src="{{getImage(getFilePath('frontend').'/banner/'.$banner->data_values->background_image)}}" alt="Banner Image">
                </div>
            </div>
        </div>
    </div>
    <div class="banner-shape home-shape-01">
        <img src="{{asset($activeTemplateTrue.'images/inner-shape.png')}}" alt="shape">
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@if($sections->secs != null)
@foreach(json_decode($sections->secs) as $sec)
@include($activeTemplate.'sections.'.$sec)
@endforeach
@endif

@endsection
