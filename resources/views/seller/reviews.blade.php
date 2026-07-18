@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')

<div class="page-header">
    <div class="container">
        <h2 class="mb-1"><i class="bi bi-chat-dots"></i> Reviews for My Spots</h2>
        <p class="mb-0 opacity-75">Manage customer feedback across all your listings</p>
    </div>
</div>

<div class="card spot-card p-4">
    @if($reviews->isEmpty())
        <div class="text-center py-4 text-muted">No reviews yet.</div>
    @else
        @foreach($reviews as $review)
            <div class="border-bottom py-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ $review->user->name }}</strong>
                        <div class="small text-muted">on <strong>{{ $review->foodSpot->name }}</strong></div>
                    </div>
                    <div class="text-end small text-muted">{{ $review->created_at->diffForHumans() }}</div>
                </div>
                <div class="mt-2">{{ $review->remarks }}</div>
                <div class="mt-2 d-flex gap-2">
                    @if(!$review->seller_reply)
                        <form method="POST" action="{{ route('reviews.reply', $review->id) }}" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="seller_reply" class="form-control form-control-sm" placeholder="Reply to this review">
                            <button class="btn btn-sm btn-primary">Reply</button>
                        </form>
                    @else
                        <div class="small text-success">Seller reply: {{ $review->seller_reply }}</div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection
