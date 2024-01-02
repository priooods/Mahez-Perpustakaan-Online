<div>
    <label class="block mb-2 text-sm font-medium text-gray-900">{{$label}}</label>
    @switch($inputType)
        @case('select')
            <select {{$attributes}} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:outline-none placeholder:text-gray-400
                focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-1.5">
                @isset($selectOptions)
                    @foreach ($selectOptions as $item)
                    <option value="{{$item->id}}">{{$item->title}}</option>
                    @endforeach
                @endisset
            </select>
            @break
        @case('textarea')
            <textarea {{$attributes}} class="block px-2.5 py-1.5 w-full text-sm text-gray-900 focus:outline-none
                placeholder:text-gray-400
                text-start bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 
                focus:border-blue-500">{{$defaulttextarea}}</textarea>
            @break
        @case('number')
            <input type="number" {{$attributes}} 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                placeholder:text-gray-400
                focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-1.5">
            @break
        @case('file')
            <input class="block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100"
                accept="{{$acceptFile}}"
                {{$attributes}} 
                aria-describedby="upload" type="file">
            @break
        @default
            <input type="{{$inputType}}" {{$attributes}} 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                placeholder:text-gray-400
                focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-1.5">
            
    @endswitch
</div>