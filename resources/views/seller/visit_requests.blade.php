@extends('layouts.app')

@section('title', 'Visit Requests')

@section('content')

<div class="page-header">
    <div class="container">
        <h2 class="mb-1"><i class="bi bi-person-lines-fill"></i> Visit Requests</h2>
        <p class="mb-0 opacity-75">Requests from users who want to visit your spots</p>
    </div>
</div>

<div class="card spot-card p-4">
    @if($visitRequests->isEmpty())
        <div class="text-center py-4 text-muted">No visit requests yet.</div>
    @else
        @foreach($visitRequests as $req)
            <div class="border-bottom py-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ $req->user->name }}</strong>
                        <div class="small text-muted">For: <strong>{{ $req->foodSpot->name }}</strong></div>
                    </div>
                    <div class="text-end small text-muted">{{ $req->created_at->diffForHumans() }}</div>
                </div>
                @if($req->purpose)
                    <div class="mt-2"><strong>Purpose:</strong> {{ $req->purpose }}</div>
                @endif
                @if($req->message)
                    <div class="mt-2">{{ $req->message }}</div>
                @endif
            </div>
        @endforeach
    @endif
</div>

@endsection
