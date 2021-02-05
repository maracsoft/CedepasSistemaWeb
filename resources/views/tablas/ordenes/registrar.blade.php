@extends('layout.plantilla')
@section('contenido')
<!--
<div class="card">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
      <h3 class="card-title">
        <i class="ion ion-clipboard mr-1"></i>
        Control de Mesas/Productos
      </h3>
    </div>

    <div class="card-body">
      
    </div>

</div>
-->
@php
    $temp=1;
@endphp
<div class="card card-tabs">
  <div class="card-header ui-sortable-handle" style="cursor: move;">
    <h3 class="card-title">
      <i class="ion ion-clipboard mr-1"></i>
      Control de Mesas/Productos
    </h3>
  </div>
    <div class="card-header p-0 pt-1">
      <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
        @foreach($salas as $itemsala)
        <li class="nav-item">
          @if($temp==1)
            <a class="nav-link active" id="mesa{{$itemsala->codSala}}-tab" data-toggle="pill" href="#mesa{{$itemsala->codSala}}" role="tab" aria-controls="mesa{{$itemsala->codSala}}-tab" aria-selected="true">SALA {{$itemsala->nombre}}</a>
          @endif
          @if($temp==0)
            <a class="nav-link" id="mesa{{$itemsala->codSala}}-tab" data-toggle="pill" href="#mesa{{$itemsala->codSala}}" role="tab" aria-controls="mesa{{$itemsala->codSala}}-tab" aria-selected="false">SALA {{$itemsala->nombre}}</a>
          @endif
          <?php $temp=0 ?>
        </li>
        @endforeach

        <!--
        <li class="nav-item">
          <a class="nav-link active" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="true">Profile</a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Messages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
        </li>
      -->  
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content" id="custom-tabs-one-tabContent">

        @foreach($salas as $itemsala)
        @if($temp==0)
        <div class="tab-pane fade active show" id="mesa{{$itemsala->codSala}}" role="tabpanel" aria-labelledby="mesa{{$itemsala->codSala}}-tab">
        @endif
        @if($temp==1)
        <div class="tab-pane fade" id="mesa{{$itemsala->codSala}}" role="tabpanel" aria-labelledby="mesa{{$itemsala->codSala}}-tab">
        @endif
          <ul class="users-list clearfix">
            @foreach($itemsala->mesa as $itemmesa)
            <li style="width: 12%">
              @if($itemmesa->estado==1)
                <a href="/orden/mesa/{{$itemmesa->codMesa}}"><img src="/img/mesa.png" /></a>
              @else
                <img src="/img/mesaBloqueada.png" />
              @endif
              <span>MESA {{$itemmesa->nroEnSala}}</span>
            </li>
            @endforeach
          </ul>

        </div>
        <?php $temp=1 ?>
        @endforeach
        <!--
        <div class="tab-pane fade active show" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
           Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam. 
        </div>
        <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
           Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna. 
        </div>
        <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
           Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis. 
        </div>
      -->
      </div>
    </div>
    <!-- /.card -->
  </div>

@endsection