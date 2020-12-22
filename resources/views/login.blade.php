
       
 @extends('layouts.app')

 @section('content')
 
 <div class="flex-center position-ref full-height">
 

     <div class="content">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
         <div class="title m-b-md">


                 <a
                 href="https://github.com/login/oauth/authorize?client_id={{ env('GH_CLIENT_ID') }}&scope=public_repo">login</a>
         </div>
     </div>
 </div>
 
 @endsection