<table class="table table-bordered table-hover" data-toggle="table"
       data-editable-emptytext="This field is empty"
       data-id-field="id"
       data-url="{{route('coastUsers.index')}}">
    <thead>
    <tr>
        <td>Nome</td>
        <td>Valor</td>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td><a href="javascript:void(0);" data-name="value" data-pk="{{$user->id}}"
                   data-url="{{route('coastUsers.update', ['userID' => $user->id])}}"
                   @php($coastFromMonth = $user->getCoastFromMonth($month, $user))
                   class="editable-money">{{$coastFromMonth ? "R$ {$coastFromMonth->value}" : ''}}</a>
            </td>

        </tr>
    @endforeach
    </tbody>
</table>