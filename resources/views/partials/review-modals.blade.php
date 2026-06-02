<div class="modal fade" id="reviewModal{{ $booking->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $booking->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="reviewModalLabel{{ $booking->id }}">
                    Rate <span style="color: #FF7A00;">{{ $booking->catererProfile->business_name }}</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="hidden" name="caterer_profile_id" value="{{ $booking->caterer_profile_id }}">
                
                <div class="modal-body py-4 px-4">
                    <div class="mb-4 text-center">
                        <label class="form-label d-block text-muted small text-uppercase fw-bold mb-3">Overall Rating</label>
                        <div class="d-flex justify-content-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" class="btn-check" name="rating" id="rating{{ $i }}-{{ $booking->id }}" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} required>
                                <label class="btn btn-outline-warning border-2 rounded-circle d-flex align-items-center justify-content-center" 
                                       for="rating{{ $i }}-{{ $booking->id }}" 
                                       style="width: 45px; height: 45px;">
                                    <i class="bi bi-star-fill fs-5"></i>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="comment" class="form-label text-muted small text-uppercase fw-bold">Your Feedback</label>
                        <textarea name="comment" class="form-control border-0 bg-light rounded-3 p-3" rows="4" placeholder="How was the food and service?" required></textarea>
                    </div>
                </div>
                
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn rounded-pill px-4 text-white fw-bold shadow-sm" style="background: #FF7A00;">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>