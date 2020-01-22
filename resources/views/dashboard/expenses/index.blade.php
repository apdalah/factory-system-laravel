@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>مصروفات عامه</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li class="active">مصروفات عامه</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">مصروفات عامه <small>{{ $expenses->total() }}</small></h3>

                    <form action="{{ route('expenses.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="بحث" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                                
                                <a href="{{ route('expenses.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> إضافه</a>
                                
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($expenses->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>مدفوع لـ</th>
                                <th>السعر</th>
                                <th> المدفوع</th>
                                <th>المتبقى</th>
                                <th> تاريخ اليوم</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($expenses as $index=>$expense)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="#" data-toggle="modal" data-target="#{{$expense->id}}">{{ $expense->supplier }}</a></td>
                                    <td>{{ $expense->price }}</td>
                                    <td>{{ $expense->paid }}</td>
                                    <td>{{ $expense->remain }}</td>
                                    <td>{{ $expense->created_at }}</td>
                                    <td>
                                        
                                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                        
                                        
                                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> حذف</button>
                                        </form><!-- end of form -->
                                        
                                    </td>
                                </tr>


<!-- Modal -->
<div class="modal fade" id="{{$expense->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        {!! $expense->description !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                            
                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        <div class="card">
                            @if($expenses->sum('remain') > 0)
                                
                                <hr>
                                <p class="lead"> المتبقى الكلى : <span class="text-danger"> {{ $expenses->sum('remain') }} </span> جنيه</p>

                            @endif

                        </div>
                        
                        {{ $expenses->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>لا يوجد اى سجلات لهذا الطلب</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
