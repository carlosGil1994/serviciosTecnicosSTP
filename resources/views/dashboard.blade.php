@extends('layouts.menu')

@section('content')
    {{-- El content menu es una bulgar card xd --}}
    <content-menu>
        <div slot="header">
            Dashboard
        </div>

        <div slot="body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

           <i-text :name="'TextField'"></i-text>
           {{Auth::user()->email}}
        </div>
        
        
        <div slot="footer">
            Aqui un footer
        </div>
    </content-menu>

@endsection
