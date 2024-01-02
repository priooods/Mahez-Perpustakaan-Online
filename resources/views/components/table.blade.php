<div>
    <div class="flex justify-start items-center">
        <div>
            <h2 class="text-xl font-bold">{{$tableTitle}}</h2>
            <p>{{$tableDesc}}</p>
        </div>
        <div class="my-auto ml-auto flex justify-end gap-x-4 items-center">
            @if ($usefilter)
                <form action="{{$filtering['action']}}" method="get">
                    @csrf
                    <select name="filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                        focus:outline-none placeholder:text-gray-400
                        focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-1.5"
                        onchange="this.form.submit()">
                        @isset($filtering['filterOptions'])
                            <option selected>Pilih filter</option>
                            @foreach ($filtering['filterOptions'] as $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach
                        @endisset
                    </select>
                </form>
            @endif
            <x-button label="Buat baru" variant="green" type="button" 
                onclick="window.location='{{ url($formLink) }}'"></x-button>
        </div>
    </div>
    <div class=" rounded-md border-gray-400/45 mt-8 border">
        <table aria-describedby="tables" class="rtl:text-right w-full table-fixed border-collapse">
            <thead>
                <tr class="border-b border-b-slate-400/45 text-xs text-gray-700 uppercase bg-gray-100">
                    <th class="p-3 text-start  w-[4%]">No</th>
                    @foreach ($column as $item)
                        @if ($item != null)
                            <th class="p-3 text-{{$item['align'] ?? 'center'}}">{{$item['title']}}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($row as $key => $item)
                    <tr class="border-b">
                        <td class="px-3 py-2 align-top text-sm text-center w-[4%]">{{$key+1}}</td>
                        @foreach ($column as $col)
                            @if ($col != null)
                                @switch($col['type'])
                                    @case('action')
                                        <td class="px-3 py-1.5 align-top text-sm
                                            text-{{$col['align'] ?? 'center'}}">
                                            <div class="grid grid-cols-1 gap-2">
                                                @foreach ($col['attr'] as $attr)
                                                    @if ($attr['key'] == 'update')
                                                        <form action="{{url($attr['actionUrl'].$item->id)}}"
                                                            method="get">
                                                            @csrf
                                                            <x-button label="{{$attr['title']}}" variant="green"
                                                                class="uppercase" iswrap="true"></x-button>
                                                        </form>
                                                    @elseif($attr['key'] == 'download')
                                                        <form action="{{url($attr['actionUrl'].$item->id)}}"
                                                            method="post">
                                                            @csrf
                                                            <x-button label="{{$attr['title']}}" variant="blue"
                                                                class="uppercase" iswrap="true"></x-button>
                                                        </form>
                                                    @else
                                                        <form action="{{url($attr['actionUrl'].$item->id)}}" 
                                                            method="post">
                                                            @csrf
                                                            <x-button type="submit" label="{{$attr['title']}}"
                                                                variant="red" 
                                                                class="uppercase" iswrap="true"></x-button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                    @break
                                    @case('number')
                                        <td class="px-3 py-1.5 align-top text-sm text-{{$col['align'] ?? 'center'}}">
                                            {{$item[$col['key']]}}</td>
                                        @break
                                    @default
                                        <td class="px-3 py-1.5 align-top text-sm text-{{$col['align'] ?? 'center'}}">
                                            {{$item[$col['key']]}}</td>
                                        
                                @endswitch
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>