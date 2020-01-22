@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>الإنتاج</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li class="active">الإنتاج اليومى</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">أيام الإنتاج <small>{{ $productions->total() }}</small></h3>

                    <form action="{{ route('productions.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="بحث" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                                
                                <a href="{{ route('productions.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> أضف  انتاج اليوم</a>
                                
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($productions->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اليوم</th>
                                <th> الإنتاج </th>
                                <th> القسم </th>
                                <th> تاريخ اليوم</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($productions as $index=>$client)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $client->day }}</td>
                                    <td>{{ $client->category->name }}</td>
                                    <td>{{ $client->amount }}</td>
                                    <td>{{ $client->created_at }}</td>
                                    <td>
                                        
                                        <a href="{{ route('productions.edit', $client->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                        
                                        
                                        <form action="{{ route('productions.destroy', $client->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> حذف</button>
                                        </form><!-- end of form -->
                                        
                                    </td>
                                </tr>
                            
                            @endforeach
                            </tbody>

                        </table><!-- end of table -->
                        
                        {{ $productions->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>لا يوجد اى سجلات لهذا الطلب</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
