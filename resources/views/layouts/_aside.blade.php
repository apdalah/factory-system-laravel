<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li><a href="{{ route('index') }}"><i class="fa fa-th"></i><span>لوحة التحكم</span></a></li>

            <li><a href="{{ route('users.index') }}"><i class="fa fa-users"></i><span>المشرفين</span></a></li>

            <li><a href="{{ route('categories.index') }}"><i class="fa fa-th"></i><span>الأقسام</span></a></li>

            <li><a href="{{ route('clients.index') }}"><i class="fa fa-th"></i><span>العملاء</span></a></li>

            <li><a href="{{ route('productions.index') }}"><i class="fa fa-th"></i><span>الإنتاج</span></a></li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>المصروفات</span>
                <i class="fa fa-angle-left pull-left"></i>
              </a>
              <ul class="treeview-menu">

                <li><a href="{{ route('materials.index') }}"><i class="fa fa-circle-o"></i> الخامات</a></li>

                <li><a href="{{ route('workers.index') }}"><i class="fa fa-circle-o"></i> العمال</a></li>

                <li><a href="{{ route('days_car.index') }}"><i class="fa fa-circle-o"></i> العربيه</a></li>

                <li><a href="{{ route('expenses.index') }}"><i class="fa fa-circle-o"></i> مصروفات عامه</a></li>

              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>المبيعات</span>
                <i class="fa fa-angle-left pull-left"></i>
              </a>
              <ul class="treeview-menu">

                <li><a href="{{ route('orders.index') }}"><i class="fa fa-circle-o"></i> الطلبات</a></li>

                <li><a href="{{ route('sales.index') }}"><i class="fa fa-circle-o"></i> مبيعات عامه</a></li>

              </ul>
            </li>
            
        </ul>

    </section>

</aside>