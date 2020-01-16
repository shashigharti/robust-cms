@extends('core::admin.layouts.default')

@section('content')
    @set('ui', new $ui)
    <div class="page leads">
        <div id="main" class="content">
            <div class="row">
                <div class="container">
                    <div class="row breadcrumbs-inline" id="breadcrumbs-wrapper">
                        {!! Breadcrumb::getInstance()->render()  !!}
                        <div class="col s2 m6 l6 right--button">
                            @section('left_menu')
                                @if(isset($ui->right_menu))
                                    <span class="create-btn clearfix pull-right">
                                        @include("core::admin.layouts.sub-layouts.partials.tables.create",
                                        [
                                            'ui' => isset($child_ui)?$child_ui:$ui
                                        ])
                                    </span>
                                @endif
                            @show
                        </div>
                    </div>
                </div>
            </div>
            <div class="row content__table">
                <div class="col s12 content__">
                    <div class="container-fluid">
                        @include("core::admin.partials.tabs.tabs")
                        @include("core::admin.partials.messages.info")
                        @if(method_exists($ui, 'getModel'))
                            <div class="col s6">
                                {{ Form::open(['url' => route($ui->getSearchURL()), 'method' => 'get']) }}
                                <div class="input-group row">
                                    <span class="col s3">{{ Form::select('type', $ui->getSearchable(), null) }}</span>
                                    <span
                                        class="pull-left">{{ Form::text('keyword', (isset($keyword))? $keyword:'', ['class' => 'form-control']) }}</span>
                                    <span class="input-group-btn">
                                            {{ Form::button('Search', ['type' => 'submit', 'class' => 'btn theme-btn']) }}
                                        </span>
                                </div>
                                {{ Form::close() }}
                            </div>
                        @endif
                        @include('real-estate::admin.leads.partials.filter')
                        <div class="row">
                            <div class="col s12">
                                <div class="panel col s12">
                                    <table class="card table striped leads-table responsive-table">
                                        @include('real-estate::admin.leads.partials.table-header')
                                        <tbody>
                                        @foreach($records as $lead)
                                            <tr>
                                                <td><input type="checkbox" value="[object Object]"></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col s12">
                                                            <span class="name lead">
                                                                <a href="#" class="">Buyer</a>
                                                            </span>
                                                            <div>
                                                                <small>{{$lead->phone}}</small>
                                                            </div>
                                                            <div>
                                                                <small>{{$lead->user->email}}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td class="center-align"><small>unknown</small></td>
                                                <td>
                                                    <div>
                                                        <a href="#">{{$lead->agent->first_name ?? 'Not Assigned'}}</a>
                                                    </div>
                                                    <div class="status-dlg">
                                                        <a href="#">[+ Set Status]</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <small><span>20 days ago</span></small> <br>
                                                    <small>19 Total</small> <br>
                                                </td>
                                                <td>
                                                    <small>
                                                        1 Months Ago
                                                    </small> <br>
                                                    <small>-</small> <br>
                                                </td>
                                                <td>
                                                    <table class="table-custom">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="info-unit has-tooltip">
                                                                    @include('real-estate::admin.leads.partials.popups.properties-viewed')
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="info-unit has-tooltip">
                                                                    @include('real-estate::admin.leads.partials.popups.favorite')
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="info-unit has-tooltip">
                                                                    @include('real-estate::admin.leads.partials.popups.neighborhood')
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="info-unit has-tooltip">
                                                                    @include('real-estate::admin.leads.partials.popups.market-report')
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="info-unit">
                                                                    @include('real-estate::admin.leads.partials.popups.listing-alerts')
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="info-unit">
                                                                    @include('real-estate::admin.leads.partials.popups.distance-drivetime')
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
