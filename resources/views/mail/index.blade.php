@extends('mail.component.head',[
  'data' => " ".$subtitle
])
@section('body')
  <p>
  	<center>
  		<b><h2>Selamat Datang!</h2></b>
  	</center>
  	<center>
  		Terima kasih telah melakukan pendaftaran di Travoys Backend
  	</center>
  </p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <thead>
  </thead>
@if($urls)
  
  <table>
    <tr class="center aligned">
      <td>
      	
      </td>
    </tr>
  </table>
@endif
@endsection
