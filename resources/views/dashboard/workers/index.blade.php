@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>العمال</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li class="active">العمال</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">العمال <small>{{ $workers->total() }}</small></h3>

                    <form action="{{ route('workers.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="بحث" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                                
                                <a href="{{ route('workers.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> أضف عامل</a>
                                
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($workers->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th> الوظيفه</th>
                                <th>اليوميات</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($workers as $index=>$worker)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $worker->name }}</td>
                                    <td>{{ $worker->job }}</td>
                                    <td><a href="{{ route('workers.days_worker.index', $worker->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i> مشاهده</a></td>
                                    <td>
                                        
                                        <a href="{{ route('workers.edit', $worker->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                        
                                        
                                        <form action="{{ route('workers.destroy', $worker->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> حذف</button>
                                        </form><!-- end of form -->
                                        
                                    </td>
                                </tr>
                            
                            @endforeach
                            </tbody>

                        </table><!-- end of table -->
                        
                        {{ $workers->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>لا يوجد اى سجلات لهذا الطلب</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
