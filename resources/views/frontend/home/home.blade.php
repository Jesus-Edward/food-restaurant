@extends('frontend.layouts.master')

@section('content')
    <!--=============================
        SLIDER START
    ==============================-->
    @include('frontend.home.components.sliders')
    <!--=============================
        SLIDER END
    ==============================-->


    <!--=============================
        WHY CHOOSE START
    ==============================-->
    @include('frontend.home.components.choose-us')
    <!--=============================
        WHY CHOOSE END
    ==============================-->


    <!--=============================
        OFFER ITEM START
    ==============================-->
    @include('frontend.home.components.offer-item')


    <!--=============================
        MENU ITEM START
    ==============================-->
    @include('frontend.home.components.menu-item')
    <!--=============================
        MENU ITEM END
    ==============================-->

    <!--=============================
        BANNER STARTS
    ==============================-->
    @include('frontend.home.components.banner')
    <!--=============================
        BANNERS END
    ==============================-->

    <!--=============================
        TEAM START
    ==============================-->
   @include('frontend.home.components.team')
    <!--=============================
        TEAM END
    ==============================-->

    <!--=============================
        DOWNLOAD APP START
    ==============================-->
    @include('frontend.home.components.download-app')
    <!--=============================
        DOWNLOAD APP END
    ==============================-->

    <!--=============================
       TESTIMONIAL  START
    ==============================-->
    @include('frontend.home.components.testimonial')
    <!--=============================
        TESTIMONIAL END
    ==============================-->

    <!--=============================
        COUNTER START
    ==============================-->
    @include('frontend.home.components.counter')
    <!--=============================
        COUNTER END
    ==============================-->

    <!--=============================
        BLOG 2 START
    ==============================-->
   @include('frontend.home.components.blog')
    <!--=============================
        BLOG 2 END
    ==============================-->
@endsection
