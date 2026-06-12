@extends('layouts.app')

@section('content')
    @if (!have_posts())
        <x-alert type="warning">
            {!! __('Sorry, no results were found.', 'sage') !!}
        </x-alert>

        {!! get_search_form(false) !!}
    @endif

    <div class="m-5 text-lg text-dark">
        <h2 class="text-3xl font-bold text-center capitalize">
            We encourage you to also visit our valued friends and partners who could also use
            your support!
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7.5">
        @while (have_posts())
            @php(the_post())
            @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
        @endwhile
    </div>
@endsection

@section('sidebar')
    @include('sections.sidebar')
@endsection
