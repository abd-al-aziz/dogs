@php
$content = getContent('packages.content', true);
$packages = App\Models\Package::whereStatus(1)->limit(4)->get();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Plan
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="plan-section pt-120 pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 text-center">
                <div class="section-header">
                    <span class="section-sub-title">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title">{{__($content->data_values->heading)}}</h2>
                    <p>{{__($content->data_values->subheading)}}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="section-header-shpae">
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            @foreach($packages as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="plan-item {{ $item->is_featured == 1 ? 'active two' : null }}">
                    <img src="{{asset($activeTemplateTrue.'images/plan-leg1.png')}}" alt="shape"
                        class="plan-shpae">
                    <div class="plan-header">
                        @if($item->is_featured)
                        <span class="sub-title">@lang('Featured')</span>
                        @endif
                        <h2 class="title">{{__($item->name)}}</h2>
                    </div>
                    <div class="plan-body">
                        <ul class="plan-list">
                            @foreach(json_decode($item->attributes) as $attr)
                            <li>{{__($attr)}} <span><i class="fas fa-check"></i></span></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="plan-footer">
                        <h2 class="price">{{$general->cur_sym}}{{__(showAmount($item->price))}}</h2>
                    </div>
                    <div class="plan-btn">
                        <a href="{{ route('user.paynow', $item->id) }}" class="btn--base w-100">@lang('Purchase
                            Now')</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Plan
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
