@extends('core::admin.layouts.sub-layouts.create')
@inject('properties_helper','Robust\RealEstate\Helpers\LeadPropertiesHelper')
@inject('group_helper','Robust\RealEstate\Helpers\LeadGroupHelper')
@section('form')
    @set('ui', new $ui)
    {{ Form::model($model, ['route' => $ui->getRoute($model), 'method' => $ui->getMethod($model) ]) }}
    <div id="{{ $title }}" class="col s12">
        <div class="row">
            @if(isset($type))
                @include("real-estate::admin.leads.partials.details.{$type}")
            @else
                @include("real-estate::admin.leads.partials.details.overview")
            @endif
        </div>
    </div>
    {{ Form::close() }}
@endsection