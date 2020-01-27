<div id="{{$id}}" class="modal">
    <div class="modal-content">
        <form action="{{$action}}" method="POST">
            @csrf
            <div class="modal-header">
                <span>{{ucfirst($type)}}</span>
                <a href="#!" class="modal-action modal-close right ">
                    <i class="material-icons">clear</i>
                </a>
            </div>
            <div class="modal-body">
                {{ Form::hidden('lead_id',$lead['id']) }}
                {{ Form::hidden('agent_id',$value) }}
                <div class="row">
                    <div class="input-field col s12">
                        {{ Form::text('title',null,['class'=>'form-control','placeholder'=>'title']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        {{ Form::textarea('note','', ['class' => 'form-control','placeholder'=>'Note' ]) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input href="#" type="submit" class=" btn theme-btn"/>
            </div>
        </form>
    </div>
</div>