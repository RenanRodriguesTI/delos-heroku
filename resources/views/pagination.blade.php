<div class="form-inline">
    <div class="form-group">
        <div class="btn-group" role="group" aria-label="...">
            @if($pagination['total_pages'] > 1 )
                @if($pagination['current_page'] == 1)
                    <a href="" class="btn btn-default disabled"><span class="glyphicon glyphicon-fast-backward dct-color"></span> </a>
                @else
                <a href="?page=1" class="btn btn-default"><span class="glyphicon glyphicon-fast-backward dct-color"></span> </a>
                @endif
            @else
                <a href="" class="btn btn-default disabled"><span class="glyphicon glyphicon-fast-backward dct-color"></span> </a>
            @endif
            @if(!isset($pagination['links']['previous']))
                <a href="" class="btn btn-default disabled"><span class="glyphicon glyphicon-step-backward dct-color"></span> </a>
            @else
                <a href="{{$pagination['links']['previous']}}" class="btn btn-default"><span class="glyphicon glyphicon-step-backward dct-color"></span> </a>
            @endif

            @if(!isset($pagination['links']['next']))
                <a href="" class="btn btn-default disabled"><span class="glyphicon glyphicon-step-forward dct-color"></span> </a>
            @else
                <a href="{{$pagination['links']['next']}}" class="btn btn-default"><span class="glyphicon glyphicon-step-forward dct-color"></span> </a>
            @endif

            @if($pagination['current_page'] == $pagination['total_pages'] || $pagination['total_pages'] <= 1)
                <a href="" class="btn btn-default disabled"><span class="glyphicon glyphicon-fast-forward dct-color"></span> </a>
            @else
                <a href="?page={{$pagination['total_pages']}}" class="btn btn-default"><span class="glyphicon glyphicon-fast-forward dct-color"></span> </a>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon bold bg-gradient dct-color" id="basic-addon1">Ir para pagina:</span>
            <input id="page" type="number" class="form-control bold dct-color" max="{{$pagination['total_pages']}}" min="1" placeholder="{{$pagination['current_page']}}" value="{{$pagination['current_page']}}"  @if($pagination['total_pages'] > 1) @else disabled @endif>
            <span class="input-group-btn">
                @if($pagination['total_pages'] > 1)
                    <button class="btn btn-default" value="" onclick="paginate()"><span class="glyphicon glyphicon-arrow-right dct-color" aria-hidden="true"></span></button>
                @else
                    <button class="btn btn-default disabled" value=""><span class="glyphicon glyphicon-arrow-right dct-color" aria-hidden="true"></span></button>
                @endif
            </span>
        </div>
    </div>

    <div class="form-group">
        <span><b>Pagina</b>: <span class="dct-color bold">{{$pagination['current_page']}}</span> <b>de</b> <span class="dct-color bold">{{$pagination['total_pages']}}</span> - <b>Exatamente <span class="dct-color bold">{{$pagination['total']}}</span> Registro(s).</b></span>
    </div>
</div>
