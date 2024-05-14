@extends('admin.layouts.master')
@section('header')
<x-header title="Beranda"></x-header>
@endsection
@section('content')

<div class="card-body">
   <div class="callout callout-info">
     <h5>Selamat Datang, <span style="color:#4543a0">{{ auth()->user()->nama_lengkap }}</span> </h5>
     <p>
      -- BisaASN ---
     </p>
   </div>
 </div>
@endsection
