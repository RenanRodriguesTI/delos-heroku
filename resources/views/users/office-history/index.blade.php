<div class='panel-body'>
                <table class='table table-bordered'>
                    <thead>
                        <tr><th>Cargo</th><th>Valor</th><th>Inicio</th></tr>
                    </thead>
                    <tbody>
                        @foreach($user->userOffices as $key =>$item)
                            <tr class='office-{{$item->id}}'>
                                <td>{{$item->office->name}}</td>
                                <td> {{ 'R$ '.$item->value}}</td>
                                <td>{{ $item->start->format('d/m/Y')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>