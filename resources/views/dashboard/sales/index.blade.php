@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>مبيعات عامه</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li class="active">مبيعات عامه</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">مبيعات عامه <small>{{ $sales->total() }}</small></h3>

                    <form action="{{ route('sales.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="بحث" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                                
                                <a href="{{ route('sales.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> إضافه</a>
                                
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($sales->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>المشترى</th>
                                <th>الخامه</th>
                                <th> الكميه</th>
                                <th>سعر الوحده</th>
                                <th> المدفوع</th>
                                <th> الباقى</th>
                                <th> تاريخ اليوم</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($sales as $index=>$sale)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sale->buyer }}</td>
                                    <td>{{ $sale->material }}</td>
                                    <td>{{ $sale->amount }}</td>
                                    <td>{{ $sale->unit_price }}</td>
                                    <td>{{ $sale->paid }}</td>
                                    <td>{{ $sale->remain }}</td>
                                    <td>{{ $sale->created_at }}</td>
                                    <td>
                                        
                                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                        
                                        
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="post" style="display: inline-block">
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
                            @if($sales->sum('remain') > 0)
                                
                                <hr>
                                <p class="lead"> المتبقى الكلى : <span class="text-danger"> {{ $sales->sum('remain') }} </span> جنيه</p>

                            @endif

                        </div>
                        
                        {{ $sales->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>لا يوجد اى سجلات لهذا الطلب</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
