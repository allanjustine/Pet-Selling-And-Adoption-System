<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GeneralReportController extends Controller
{
    public function __invoke()
    {
        DB::statement("SET SQL_MODE=''"); // set the strict to false

        return view('admin.general_report.index', [
            'chart_total_monthly_sales' => $this->get_total_monthly_sales(),
            'chart_total_yearly_sales' => $this->get_total_yearly_sales(),
            'chart_total_pets_by_category' => $this->get_total_pets_by_category(),
            'chart_top_selling_pet' => $this->get_top_selling_pet(),
            'chart_top_seller' => $this->get_top_seller(),
            'chart_monthly_seller' => $this->get_monthly_sellers(),
            'chart_monthly_buyer' => $this->get_monthly_buyers(),
        ]);
    }

    /**
    * get top selling pet
    *
    */
    private function get_top_selling_pet()
    {
        $orders = Order::query()
        ->with('pet')
        ->where('status', Order::DELIVERED)
        // ->groupBy('transaction_no')
        ->get();
        

        $unfiltered_pets = array();

        foreach ($orders as $order) {

            $unfiltered_pets[] = $order->pet->name;
        }

        $results = array_count_values($unfiltered_pets);

        $pets = array_keys($results);
        $total = array_values($results);

        return [$pets, $total];
    }


    /**
    * get top selling pet
    *
    */
    private function get_top_seller()
    {
        $orders = Order::query()
        ->with('pet.user')
        ->where('status', Order::DELIVERED)
        // ->groupBy('transaction_no')
        ->get();
        

        $unfiltered_pets = array();

        foreach ($orders as $order) {

            $unfiltered_pets[] = $order->pet->user->full_name;
        }

        $results = array_count_values($unfiltered_pets);

        $pets = array_keys($results);
        $total = array_values($results);

        return [$pets, $total];
    }

    /**
    * get all pet by category
    *
    */
    private function get_total_pets_by_category()
    {
        $categories = [];
        $total_pets = [];
        $category = request()->query('category');

        $get_categories = Category::query()
        ->when($category, fn($query) => $query->whereId($category))
        ->with('pets')
        ->get();

        foreach ($get_categories as $cat) {
            $categories[] = $cat->name;
            $total_pets[] = $cat->pets->count();
        }

        return [$categories, $total_pets];
    }

    /**
    * get pet monthly sales
    *
    */
    private function get_total_monthly_sales()
    {
        $month = request()->query('month');
        
        $sales = Order::selectRaw("
        SUM(pets.price) as total_sales, 
        month(orders.created_at) as month_no, 
        DATE_FORMAT(orders.created_at, '%M-%Y') AS new_date, 
        YEAR(orders.created_at) AS year, 
        monthname(orders.created_at) AS month
        ")
        ->join('pets', 'orders.pet_id', 'pets.id')
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

    /**
    * get pet yearly sales
    *
    */
    private function get_total_yearly_sales()
    {
        $year = request()->query('year');
        
        $sales = Order::selectRaw("
        SUM(pets.price) as total_sales, 
        month(orders.created_at) as month_no, 
        DATE_FORMAT(orders.created_at, '%M-%Y') AS new_date, 
        YEAR(orders.created_at) AS year, 
        monthname(orders.created_at) AS month
        ")
        ->join('pets', 'orders.pet_id', 'pets.id')
        ->when($year, fn($query) => $query->whereYear('orders.created_at', $year))
        ->where('orders.status', Order::DELIVERED)
        ->groupBy('year')
        ->orderByRaw('year')
        ->get();

        $years = array();
        
        $total_yearly_sales = array();

        foreach ($sales as $sale) {
            $years[] = $sale->year;
            $total_yearly_sales[] = $sale->total_sales;

        }

        return [$years, $total_yearly_sales];
    }


    private function get_monthly_buyers()
    {
        $monthly_buyers = User::byRole('buyer')->selectRaw("
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
        
        $total_monthly_buyers = array();

        foreach ($monthly_buyers as $month) {
            $months[] = $month->month;
        }

        foreach ($monthly_buyers as $total) {
            $total_monthly_buyers[] = $total->total_users;
        }

        return [$months, $total_monthly_buyers]; // sorted
    }

    private function get_monthly_sellers()
    {
        $monthly_sellers = User::byRole('seller')->selectRaw("
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
        
        $total_monthly_sellers = array();

        foreach ($monthly_sellers as $month) {
            $months[] = $month->month;
        }

        foreach ($monthly_sellers as $total) {
            $total_monthly_sellers[] = $total->total_users;
        }

        return [$months, $total_monthly_sellers]; // sorted
    }

}