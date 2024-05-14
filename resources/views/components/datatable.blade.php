
   <table id="{{ $id }}" class="table table-bordered display {{ $class ?? "" }}" {{ $attributes }}>
       <thead>
           <tr>
               @foreach ($th as $key => $item)
               <th>{{ $item }}</th>
               @endforeach
           </tr>
       </thead>
       <tbody>
       </tbody>
   </table>

