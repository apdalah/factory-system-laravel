@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1> {{ $order->title }} </h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li class="active">التفاصيل</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">عدد الطلبات<small> {{ $sub_orders->total() }} </small></h3>

                    <form action="{{ route('orders.sub_orders.index', $order->id) }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="بحث" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                                
                                <a href="{{ route('orders.sub_orders.create', $order->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> أضف طلب</a>
                                
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($sub_orders->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الخامه</th>
                                <th> الكميه</th>
                                <th>سعر الوحده</th>
                                <th>المدفوع</th>
                                <th>المتبقى</th>
                                <th>تاريخ اليوم</th>
                                <th>تاريخ اخر تحديث</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($sub_orders as $index=>$subOrder)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $subOrder->category->name }}</td>
                                    <td>{{ $subOrder->amount }}</td>
                                    <td>{{ $subOrder->unit_price }}</td>
                                    <td>{{ $subOrder->paid }}</td>
                                    <td>{{ $subOrder->remain }}</td>
                                    <td>{{ $subOrder->created_at }}</td>
                                    <td>{{ $subOrder->updated_at }}</td>
                                    <td>
                                        
                                        <a href="{{ route('orders.sub_orders.edit', [$order->id, $subOrder->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                        
                                        
                                        <form action="{{ route('orders.sub_orders.destroy', [$order->id, $subOrder->id]) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> حذف</button>
                                        </form><!-- end of form -->
                                        
                                    </td>
                                </tr>
                            
                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        <div class="card">
                            @if($sub_orders->sum('remain') > 0)

                                <p class="lead"> المتبقى على العميل : <span class="text-danger"> {{ $sub_orders->sum('remain') }} </span> جنيه</p>
                            @else

                                <p class="lead"> المتبقى للعميل : <span class="text-danger"> {{ abs($sub_orders->sum('remain')) }} </span> جنيه</p>

                            @endif

                        </div>
                        
                        {{ $sub_orders->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>لا يوجد اى سجلات لهذا الطلب</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
