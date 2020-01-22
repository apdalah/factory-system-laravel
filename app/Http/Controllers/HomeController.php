<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Material;
use App\DaysCar;
use App\DaysWorker;
use App\Expense;

use App\SubOrder;
use App\Sale;

use App\Category;
use App\Client;
use App\Order;
use App\User;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    	$total_debt = $this->totalDept();

    	$total_remain = $this->totalRemain();

    	$categories = Category::count();
    	$clients = Client::count();
    	$orders = Order::count();
    	$users = User::count();

        return view('dashboard.index', compact('categories', 'clients', 'orders', 'users', 'total_remain', 'total_debt'));
    }

    protected function totalRemain()
    {
        $remain_sales = Sale::sum('remain');
        $remain_orders = SubOrder::sum('remain');

        return $remain_sales + $remain_orders;
    }

    protected function totalDept()
    {
        $remain_materials = Material::sum('remain');
        $remain_workers = DaysWorker::sum('remain');
        $remain_car = DaysCar::sum('remain');
        $remain_expenses = Expense::sum('remain');

        return $remain_materials + $remain_workers + $remain_car + $remain_expenses;
    }
    
}
