@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>نقلات العربيه</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li class="active">نقلات العربيه</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">نقلات العربيه <small>{{ $days->total() }}</small></h3>

                    <form action="{{ route('days_car.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="بحث" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                                
                                <a href="{{ route('days_car.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> أضف نقله</a>
                                
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($days->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم السائق</th>
                                <th>اليوم </th>
                                <th>مصروفات العربيه</th>
                                <th> المدفوع</th>
                                <th> المتبقى</th>
                                <th> تاريخ اليوم</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($days as $index=>$day)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="#" data-toggle="modal" data-target="#{{$day->id}}">{{ $day->driver }}</a></td>
                                    <td>{{ $day->day }}</td>
                                    <td>{{ $day->price }}</td>
                                    <td>{{ $day->paid }}</td>
                                    <td>{{ $day->remain }}</td>
                                    <td>
                                        
                                        <a href="{{ route('days_car.edit', $day->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                        
                                        
                                        <form action="{{ route('days_car.destroy', $day->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> حذف</button>
                                        </form><!-- end of form -->
                                        
                                    </td>
                                </tr>

<!-- Modal -->
<div class="modal fade" id="{{$day->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        {!! $day->description !!}
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

                        
                        
                        {{ $days->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>لا يوجد اى سجلات لهذا الطلب</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
