@extends('layouts.app')

@section('schema_json')
@php
    $homeSchemaData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '/#website',
                'url' => url('/'),
                'name' => $settings->site_name,
                'description' => $settings->site_tagline,
                'inLanguage' => 'id-ID',
            ],
            [
                '@type' => 'TravelAgency',
                '@id' => url('/') . '/#agency',
                'name' => $settings->site_name,
                'url' => url('/'),
                'logo' => $settings->favicon_url ?: asset('favicon.ico'),
                'image' => $settings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop',
                'description' => $settings->seo_description ?: $settings->site_tagline,
                'telephone' => $settings->phone_number,
                'priceRange' => 'Rp 325.000 - Rp 1.500.000',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $settings->address,
                    'addressLocality' => 'Wonosobo',
                    'addressRegion' => 'Jawa Tengah',
                    'postalCode' => '56354',
                    'addressCountry' => 'ID',
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => -7.2056,
                    'longitude' => 109.9078,
                ],
                'areaServed' => [
                    '@type' => 'AdministrativeArea',
                    'name' => 'Dataran Tinggi Dieng',
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($homeSchemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
<main class="relative min-h-screen bg-[#07090e] text-slate-100 overflow-hidden">


    @include('partials.home.navbar')
    @include('partials.home.hero')
    @include('partials.home.scrollytelling')
    @include('partials.home.packages')
    @include('partials.home.why-us')
    @include('partials.home.company-profile')
    @include('partials.home.lotus-creative')
    @include('partials.home.calculator')
    @include('partials.home.testimonials')
    @include('partials.home.visitor-counter')
    @include('partials.home.footer')
</main>
@endsection

@push('scripts')
    @include('partials.home.scripts')
@endpush
