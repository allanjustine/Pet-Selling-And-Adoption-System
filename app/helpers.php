<?php

use App\Models\Rating;
use Carbon\Carbon;

if(!function_exists('formatDate'))
{
    /**
     * format date
     */
    function formatDate($date, $opt="fulldate")
    {
       return match($opt) {
            'default' => date('m/d/Y'),
           'dateInput' => date('Y-m-d', strtotime($date)),
           'fulldate' => date('F d,Y', strtotime($date)),
           'dateTime' => date('M d,Y h:iA', strtotime($date)),
           'dateTimeWithSeconds' => date('Y-m-d h:i:s', strtotime($date)),
           'dateTimeLocal' => date('Y-m-d\TH:i', strtotime($date)),
           'time' => date('h:iA', strtotime($date)),
       };
    }

}

if(!function_exists('getAge'))
{
    /**
     * calculate the age base on the given date
     */
    function getAge($birth_date)
    {
        if($birth_date) {
            return \Carbon\Carbon::parse($birth_date)->age;
        }
    }
}

if(!function_exists('getPetAge'))
{
    /**
     * get the age of the pet by birth date
     */
     function getPetAge($birth_date)
    {
        $birthDate = Carbon::parse($birth_date);
        $currentDate = Carbon::now();
        $ageYears = $birthDate->diffInYears($currentDate);

        if ($ageYears < 1) {
            $ageMonths = $birthDate->diffInMonths($currentDate);
            if ($ageMonths < 1) {
                return 'Less than 1 month old';
            }
            return $ageMonths . ' months';
        }

        return $ageYears . ' years';
    }
}


if (!function_exists('getOrderMonths')) {
    /**
     * get all the months on the orders table
     */
    function getOrderMonths()
    {
        \DB::statement("SET SQL_MODE=''"); // set the strict to false

        return \App\Models\Order::selectRaw("
        month(created_at) as month_no, 
        DATE_FORMAT(created_at, '%M-%Y') AS new_date,
        YEAR(created_at) AS year,
        monthname(created_at) AS month"
        )
        ->groupBy('new_date')       
        ->orderByRaw('month_no')
        ->get('month');
    }
}

if (!function_exists('getOrderYears')) {
    /**
     * get all the years on the orders table
     */
    function getOrderYears()
    {
        \DB::statement("SET SQL_MODE=''"); // set the strict to false

        return \App\Models\Order::selectRaw("
        DATE_FORMAT(created_at, '%M-%Y') AS new_date,
        YEAR(created_at) AS year,
        monthname(created_at) AS month"
        )
        ->groupBy('year')       
        ->orderByRaw('year')
        ->get('month');
    }
}


if(!function_exists('handleDateType'))
{
    /**
     * determine the date whether  it is T/TH or MWF 
     */
    function handleDateType($given_date)
    {
        $date = Carbon::parse($given_date);

        // Determine if it is T/TH
        if ($date->dayOfWeek === Carbon::TUESDAY || $date->dayOfWeek === Carbon::THURSDAY) {
            return "<span class='badge badge-success'> T/TH </span>";
        } 
        
        echo "\n";
        
        // Determine if it is MWF
        if ($date->dayOfWeek === Carbon::MONDAY || $date->dayOfWeek === Carbon::WEDNESDAY || $date->dayOfWeek === Carbon::FRIDAY) {
            return "<span class='badge badge-success'> M/W/F </span>";
        } 
    }

}

if(!function_exists('handleNullAvatar'))
{
    /**
     * handle Null Avatar Image
     */
    function handleNullAvatar($img)
    {
        return $img ?? '/img/noimg.svg';
    }
}


if(!function_exists('handleNullAvatarForPet'))
{
    /**
     * handle Null Avatar Image
     */
    function handleNullAvatarForPet($img)
    {
        return $img ?? '/img/paw.png';
    }
}



if(!function_exists('handleNullImage'))
{
    /**
     * handle Null Image
     */
    function handleNullImage($img)
    {
        return $img ?? '/img/img_not_found.svg';
    }
}

if(!function_exists('handleAdditionalPaymentStatus'))
{
     /**
     * handle the order status
     */
    function handleAdditionalPaymentStatus($bool)
    {
        return match($bool) {
            0 => "<span class='badge badge-info'>Pending <i class='fas fa-spinner ml-1'></i></span>",
            1 => "<span class='badge badge-success'>Approved <i class='fas fa-check-circle ml-1'></i></span>",
            2 => "<span class='badge badge-danger'>Declined <i class='fas fa-times-circle ml-1'></i></span>",
        };
    }

}


if(!function_exists('handleOrderStatus'))
{
     /**
     * handle the order status
     */
    function handleOrderStatus($bool)
    {
        return match($bool) {
            0 => "<span class='badge badge-info'>Pending <i class='fas fa-spinner ml-1'></i></span>",
            1 => "<span class='badge badge-success'>Approved <i class='fas fa-check-circle ml-1'></i></span>",
            2 => "<span class='badge badge-danger'>Declined <i class='fas fa-times-circle ml-1'></i></span>",
            3 => "<span class='badge badge-info'>To be Delivered <i class='fas fa-shipping-fast ml-1'></i></span>",
            4 => "<span class='badge badge-success'>Delivered <i class='fas fa-check-circle ml-1'></i></span>",
        };
    }

}



if(!function_exists('handleOrderStatusTextOnly'))
{
     /**
     * handle the order status
     */
    function handleOrderStatusTextOnly($bool)
    {
        return match($bool) {
            0 => "<span class='badge badge-info'>Pending <i class='fas fa-spinner ml-1'></i></span>",
            1 => "<span class='badge badge-success'>Approved <i class='fas fa-check-circle ml-1'></i></span>",
            2 => "<span class='badge badge-danger'>Declined <i class='fas fa-times-circle ml-1'></i></span>",
            3 => "<span class='badge badge-info'>To be Delivered <i class='fas fa-shipping-fast ml-1'></i></span>",
            4 => "<span class='badge badge-success'>Delivered <i class='fas fa-check-circle ml-1'></i></span>",
        };
    }

}


if(!function_exists('isActivated'))
{
    function isActivated($bool)
    {
        return $bool ? "<span class='badge badge-success'>Activated</span>" : "<span class='badge badge-danger'>Deactivated</span>";
    }
}

if(!function_exists('isApproved'))
{
     /**
     * check if the status is approved
     */
    function isApproved($bool)
    {
        if ($bool == 0) {
            return "<span class='badge badge-info'>Pending <i class='fas fa-spinner ms-2'></i></span>";
        } else if($bool == 1) {
            return "<span class='badge badge-success'>Approved</span>";
        } else {
            return "<span class='badge badge-danger'>Declined</span>";
        }
    }

}


if(!function_exists('isAdopted'))
{
     /**
     * check if the status is approved
     */
    function isAdopted($bool)
    {
        return $bool 
        ? "<span class='badge badge-success'> Adopted <i class='fas fa-check-circle ml-1'></i></span>"
        : "<span class='badge badge-info'> Open for adoption <i class='fas fa-spinner ml-1'></i></span>";
    }

}


if(!function_exists('isLikedByAuthUser'))
{
     /**
     * check if this model is liked by authenticated user
     */
    function isLikedByAuthUser($auth_user, $likers) 
    {
        $post_likers = [];// users who likes the post

        foreach($likers as $liker) {
        $post_likers[] = $liker->user_id; // get user id 
        }

        return  (in_array($auth_user, $post_likers)) ? true : false; // check if the user has already liked the post
    }
}


if(!function_exists('isRatedByAuthUser'))
{
     /**
     * check if user has already rated the seller by order #
     */
    function isRatedByAuthUser($auth_user, $seller, $order) 
    {
        $check_record = Rating::where('sender_id', auth()->id())
        ->where('receiver_id', $seller)
        ->where('order_id', $order)
        ->first();

        return  $check_record ? true : false; // check if the user has already liked the post
    }
}


if(!function_exists('isOnline'))
{
     /**
     * check if the payment method status is approved
     */
    function isOnline($bool)
    {
        return $bool  ? "<span class='badge badge-success'>Online <i class='fas fa-check-circle ml-1'></i></span>" : "<span class='badge badge-danger'>Offline</span>";
    }

}


if(!function_exists('truncateText'))
{
    /**
     * truncate text
     */
    function truncateText($string, $length = 150)
    {
       return \Illuminate\Support\Str::limit($string, $length, $end='...');
    }

}