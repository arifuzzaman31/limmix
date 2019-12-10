@extends('app')
	@section('content')
        <!-- Hero area start -->
        @include('section.hero_area')
        <!-- Hero area end -->
        <!-- Feature area start -->
        @include('section.feature')
        <!-- Feature area end -->
        <!-- About area start -->
        
        <!-- About area end -->
        <!-- Service area start -->
        @include('section.service')
        <!-- Service area end -->
        <!-- Portfolio area start -->
        @include('section.portfolio')
        <!-- Portfolio area end -->
        <!-- Team area start -->
        @include('section.team_area')
        <!-- Team area end -->
        <!-- Video area Start -->
        @include('section.video')
        <!-- Video area end -->
        <!-- Price area start -->
        @include('section.price_area')
        <!-- Price area end -->
        <!-- Plan area Start -->
        @include('section.blog')
        <!-- Plan area end -->
        <!-- Testinonial area Start -->
 
        <!-- Testinonial area end -->
        <!-- Blog area satrt -->

        <!-- Blog area end -->
        <!-- Contact area Start -->
        @include('section.contact')
        <!-- Contact area end -->
 	@endsection

        @push('script')

        <script src="{{ asset('js/app.js') }}" ></script>

        @endpush