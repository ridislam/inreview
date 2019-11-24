<?php

namespace Ridislam\InReview;
use Illuminate\Support\Facades\Auth;

trait InReviewable
{
    /**
     * @return mixed
     */
    public function reviews()
    {
        return $this->morphMany('Ridislam\InReview\Models\Review', 'reviewable');
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function sumRating()
    {
        return $this->reviews()->sum('rating');
    }

    public function userAverageRating()
    {
        return $this->reviews()->where('user_id', Auth::id())->avg('rating');
    }

    public function userSumRating()
    {
        return $this->reviews()->where('user_id', Auth::id())->sum('rating');
    }

    public function ratingPercent($max = 5)
    {
        $quantity = $this->reviews()->count();
        $total = $this->sumRating();

        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->averageRating();
    }

    public function getSumRatingAttribute()
    {
        return $this->sumRating();
    }

    public function getUserAverageRatingAttribute()
    {
        return $this->userAverageRating();
    }

    public function getUserSumRatingAttribute()
    {
        return $this->userSumRating();
    }

    public function isReviewedByCurrentUser()
    {
        $review = $this->reviews()->where('user_id', Auth::id());
        if ($review->count()) {
            return true;
        }

        return false;
    }
}
