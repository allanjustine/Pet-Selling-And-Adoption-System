<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Campus;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Role;
use App\Models\SellerAccount;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function __construct()
    {
        DB::statement("SET SQL_MODE=''"); // set the strict to false
    }

    public function __invoke()
    {
        $pets = Pet::query();
        $orders = Order::query();

        // dd($this->getTopRatedSeller());
        
        return view('admin.dashboard.index', [
            'activities' => Activity::latest()->take(5)->get(),
            'total_order' => $orders->count(),
            'total_pet' => $pets->count(),
            'total_active_user' => User::byRole([Role::BUYER, Role::SELLER])->active()->count(),
            'total_inactive_user' => User::byRole([Role::BUYER, Role::SELLER])->inactive()->count(),
            'orders' => $orders->groupBy('transaction_no')->paginate(10),
            'pets' => $pets->paginate(10),
            'users' => User::whereRelation('role', 'name', '!=', 'admin')->latest()->paginate(10),
            'chart_monthly_users' => $this->getMonthlyUsers(),
            'chart_monthly_sales' => $this->getMonthlySales(),
            'chart_total_pets_by_category' => $this->getTotalPetsByCategory(),
            'chart_top_rated_seller' => $this->getTopRatedSeller(),
        ]);
    }

    private function getTotalPetsByCategory()
    {
        $categories = [];
        $total_pets = [];

        foreach (Category::with('pets')->get() as $category) {
            $categories[] = $category->name ; //
            $total_pets[] = $category->pets->count();
        }

        return [$categories, $total_pets];
    }

    private function getMonthlySales($month = "")
    {
        $sales = Order::selectRaw("
        SUM(pets.price) as total_sales, 
        month(orders.created_at) as month_no, 
        DATE_FORMAT(orders.created_at, '%M-%Y') AS new_date, 
        YEAR(orders.created_at) AS year, 
        monthname(orders.created_at) AS month
        ")
        ->join('pets', 'orders.pet_id', 'pets.id')
        // ->when(blank($month), fn($query) => $query->whereMonth('orders.created_at', now()))
        ->when($month, fn($query) => $query->whereMonth('orders.created_at', $month))
        ->where('orders.status', Order::DELIVERED)
        ->groupBy('month_no')
        ->orderByRaw('month_no')
        ->get();

        $months = array();
        
        $total_monthly_sales = array();

        foreach ($sales as $sale) {
            $months[] = $sale->month;
            $total_monthly_sales[] = $sale->total_sales;

        }

        return [$months, $total_monthly_sales];
    }


    public function getMonthlyUsers()
    {
        $monthly_users = User::selectRaw("
        count(id) AS total_users, 
        month(created_at) as month_no, 
        DATE_FORMAT(created_at, '%M-%Y') AS new_date,
        YEAR(created_at) AS year,
        monthname(created_at) AS month"
        )
        ->groupBy('new_date')
        ->orderByRaw('month_no')
        ->get();

        $months = array();
        
        $total_monthly_users = array();

        foreach ($monthly_users as $month) {
            $months[] = $month->month;
        }

        foreach ($monthly_users as $total) {
            $total_monthly_users[] = $total->total_users;
        }

        return [$months, $total_monthly_users]; // sorted
    }


    private function getTopRatedSeller($limit = 5)
    {
        $results = User::leftJoin('ratings as received_ratings', 'users.id', '=', 'received_ratings.receiver_id')
        ->selectRaw('users.id, CONCAT(users.first_name, " ", users.last_name) as name, AVG(received_ratings.rating) as average_rating')
        ->whereNotNull('received_ratings.rating') // Exclude users with no ratings as sellers
        ->groupBy('users.id')
        ->orderByDesc('average_rating')
        ->take($limit)
        ->get();

        $top_sellers = [];
        $ratings = [];

        foreach($results as $result)
        {
            $top_sellers[] = $result->name;
            $ratings[] = $result->average_rating;
        }

        return [$top_sellers, $ratings];
        
    }


}