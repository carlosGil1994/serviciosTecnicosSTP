@extends('layouts.menu')

@section('contenido')
    <create-new :route="'{{ route('add_banco') }}'">
        <div slot="inputs">
            <i-text :name="'TextValue'"></i-text>
        </div>
    </create-new>
@endsection
