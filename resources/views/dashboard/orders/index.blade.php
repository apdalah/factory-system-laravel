@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>الطلبات</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li class="active">الطلبات</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">الطلبات <small>{{ $orders->total() }}</small></h3>

                    <form action="{{ route('orders.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="بحث" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                                
                                <a href="{{ route('orders.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> أضف طلب</a>
                                
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($orders->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th> اسم الطلب</th>
                                <th>التفاصيل</th>
                                <th>العميل</th>
                                <th>الحاله</th>
                                <th>تاريخ التسجيل</th>
                                <th>تاريخ اخر تعديل</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($orders as $index=>$order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="" data-toggle="modal" data-target="#order-{{$order->id}}">{{ $order->title }}</a></td>

<!-- Modal -->
<div class="modal fade" id="order-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        {!! $order->description !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

                                    <td><a href="{{ route('orders.sub_orders.index', $order->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> مشاهده</a></td>
                                    <td>{{ $order->client->name }}</td>
                                    <td class="{{$order->status == '0' ? 'text-danger' : ''}}">{{ $order->status == '0' ? 'قيد العمل' : 'منتهى' }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->updated_at }}</td>
                                    <td>
                                        
                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                        
                                        <form action="{{ route('orders.update_status', $order->id) }}" method="post" style="display: inline-block">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i>
                                                
                                                {{$order->status == '0' ? 'إنهاء' : 'تفعيل'}}

                                            </button>
                                        </form><!-- end of form -->
                                        
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> حذف</button>
                                        </form><!-- end of form -->
                                        
                                    </td>
                                </tr>
                            
                            @endforeach
                            </tbody>

                        </table><!-- end of table -->
                        
                        {{ $orders->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>لا يوجد اى سجلات لهذا الطلب</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
