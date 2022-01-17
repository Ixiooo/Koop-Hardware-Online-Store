@extends('layouts.app')

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>

@endsection

@section('styles')
<style>

    .jumbotron {
        position:relative;
        overflow:hidden;
    }

    .jumbotron .container {
        position:relative;
        z-index:2;
        
        background:rgba(0,0,0,0.2);
        padding:4em;
        border:1px solid rgba(0,0,0,0.1);
        border-radius:3px;
    }

    .jumbotron-background {
        background: url("/storage/logo/banner.jpg") no-repeat center;
        background-size:cover;
        font-family: 'object-fit: cover;';
        position:absolute;
        top:0;
        z-index:1;
        width:100%;
        height:100%;
        opacity:0.5;

        
        -webkit-filter: blur(2px);
        filter: blur(2px);
        filter:progid:DXImageTransform.Microsoft.Blur(PixelRadius='4');
    }

    .blur{
        max-width: 100%;
    }

    img.blur {
        -webkit-filter: blur(2px);
        filter: blur(2px);
        filter:progid:DX
        ImageTransform.Microsoft.Blur(PixelRadius='4');
    }

    .parag{
        font-size: 24px;
    }

</style>
@endsection

@section('content')

<div class="jumbotron jumbotron-fluid bg-dark">
  
    <div class="jumbotron-background">
    </div>
  
    <div class="container text-white text-center">
  
        <h1 class="display-4">Koop Hardware and Construction Supply</h1>
        <hr class="my-4">
        <p class="parag">The First DIY store of SIDC established at December 2017 in Tinga Itaas, Batangas. It provides qualiy and reasonable price materials for construction and home improvement.</p>
        <a class="btn page-btn btn-lg" href="/store" role="button"><i class="fas fa-shopping-cart"> </i> Proceed to Store</a>
        
    </div>
   
</div>

<div class="row m-0 justify-content-center" id="contact">
    <div class="col-12 text-center py-3">
        <h2>ABOUT US</h2>
    </div>


    <div class="col-12 col-md-6" >
        <hr>
        <div class="row">
            <div class="col-6 align-self-center">
                <img src="/storage/logo/sidc_logo.jpg" alt="SIDC Logo" style="width:100%;">
            </div>
            <div class="col-6 align-self-center">
                <h4 class="pb-3 pt-sm-0 text-center">Soro Soro Ibaba Development Cooperative (SIDC)</h4>
            </div>
        </div>
        <p class="pt-2 text-center">Sorosoro Ibaba Development Cooperative (SIDC) is first established as Sorosoro Ibaba Farmers' Association in March 19, 1969, thru Mr. Victoriano E. Barte. The association was funded initially by 59 members and as of December 2020, the cooperative has 27,254 regular members and 17,520 associate members.</p>
        <p class=" text-center">SIDC grows to a Coorporative providing with a sustainable Lifcycle in Agriculture, Financial Services, Retail and Wholesale as well in Ecotourism -all with participaion on their Members.</p>
        <p class=" text-center">Be a Part of SIDC Sorosoro Ibaba Development Cooperative and benefit from the Community.</p>
    </div>

    <div class="col-12 col-md-6">
        <hr>
        <div class="row">
            <div class="col-6 align-self-center">
                <img src="/storage/logo/kh-logo.png" alt="SIDC Logo" width="100%">
            </div>
            <div class="col-6 align-self-center">
                <h4 class="pb-3 pt-sm-0 text-center">Koop Hardware and Construction Supply</h4>
            </div>
        </div>

        <div class="map-container d-flex align-items-center justify-content-center">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7749.559113710037!2d121.0834152201919!3d13.7921584226327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd1021dc4f55a3%3A0x901b1b716abfd68a!2sKoop%20Hardware%20%26%20Construction%20Supply!5e0!3m2!1sen!2sph!4v1639851580124!5m2!1sen!2sph" 
            width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>

        <p class="pt-2 text-center">Tinga Labac, Batangas City, Batangas</p>
        <p class="text-center">Phone No: (+6343) (043) 774-2599</p>

    </div>
</div>

@endsection

@section('post-scripts')


@endsection