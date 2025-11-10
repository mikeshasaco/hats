@extends('layouts.app')
@section('content')
<div class="container py-5">
  <h1 class="mb-3">Hat: {{ $hat->slug }}</h1>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @error('claim') <div class="alert alert-danger">{{ $message }}</div> @enderror

  @auth
    @if($hat->user_id === auth()->id())
      <p class="text-success">You own this hat.</p>
    @elseif($hat->user_id)
      <p class="text-muted">Already claimed by another user.</p>
    @else
      <form method="POST" action="{{ route('hub.claim', $hat->slug) }}">@csrf
        <button class="btn btn-primary">Claim this Hat</button>
      </form>
    @endif
  @else
    @if(!$hat->user_id)
      <p class="mb-3">Sign in to claim this hat.</p>
    @endif
    <a class="btn btn-outline-primary" href="{{ route('login') }}">Sign in</a>
    <a class="btn btn-outline-secondary" href="{{ route('register') }}">Register</a>
  @endauth

  <hr class="my-4"/>
  <h3>Link Hub</h3>
  <ul>
    <li><a href="#">Buy a Hat (placeholder)</a></li>
    <li><a href="#">My Profile (placeholder)</a></li>
  </ul>
</div>
@endsection
