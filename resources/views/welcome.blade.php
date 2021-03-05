@php
use App\Http\Controllers\Globals as Utils;
@endphp

@extends('layouts.landing')

@section('title', __('Investments Plan'))

@section('content')
<section class="inner-page-banner-section gradient-bg">
  <div class="illustration-img"><img src="{{ asset('assets/images/inner-page-banner-illustrations/investment.png') }}" alt="image-illustration"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="inner-page-content-area">
          <h2 class="page-title">Investments</h2>
          <nav aria-label="breadcrumb" class="page-header-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="//bridgecredit.com">Home</a></li>
              <li class="breadcrumb-item">Investment</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="investment-section pb-120">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="main-area">
          <h2 class="title">Investment plans</h2>
          <div class="row mt-4 mb-none-30 investment-item-area list-view">
            @foreach($plans as $plan)
            <div class="col-lg-6 investment-item">
              <div class="investment-single mb-30">
                <div class="thumb  bg_img" data-background="{{ asset($plan->cover) }}">
                </div>
                <div class="content">
                  <div class="left">
                    <h3 class="investment-title">{{ucwords($plan->name) }}</h3>
                    <p>{{ ucfirst($plan->short_desc) }}</p>
                    <div class="share-price">
                      <h3 class="price">₦{{ number_format($plan->min_invest,2) }}<small>min investment</small></h3>
                    </div>
                    <div class="d-flex flex-wrap mt-5">
                      <div class="icon-item d-flex flex-wrap">
                        <div class="icon"><i class="icofont-ui-user-group"></i></div>
                        <div class="content">
                          <span class="counter">{{ Utils::getInvestors($plan->id) }}</span>
                          <p>investors</p>
                        </div>
                      </div>
                      <div class="icon-item d-flex flex-wrap">
                        <div class="icon"><i class="icofont-wall-clock"></i></div>
                        <div class="content">
                          <span class="counter">Monthly</span>
                          <p>Interests</p>
                        </div>
                      </div>
                    </div>
                    <div class="shares-part">
                      <div class="share-item">
                        <span class="caption">Monthly Interest</span>
                        <h4 class="amount">{{ round($plan->interest / 12,2) }}&</h4>
                      </div>
                      <div class="share-item">
                        <span class="caption">Annual Return</span>
                        <h4 class="amount">{{ round(100+$plan->interest,2) }}%</h4>
                      </div>
                      <div class="share-item">
                        <span class="caption">Annual Interest</span>
                        <h4 class="amount">{{ round($plan->interest,2) }}%</h4>
                      </div>
                    </div>
                  </div>
                  <div class="right">
                    <div class="share-price">
                      <h3 class="price">₦{{ number_format($plan->min_invest,2) }}<small>min investment</small></h3>
                    </div>
                    <a href="#0" class="btn btn-primary btn-hover text-small">invest now</a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection