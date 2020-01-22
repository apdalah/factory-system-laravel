@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1> {{ $worker->name }} </h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li class="active">اليوميات</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px; margin-left: 10px;">اليوميات <small>{{ $days->total() }}</small></h3>

                    <span><a href="{{ route('workers.index') }}">العوده الى العمال</a></span>

                    <form action="{{ route('workers.days_worker.index', $worker->id) }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="بحث" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
                                
                                <a href="{{ route('workers.days_worker.create', $worker->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> أضف يوميه</a>
                                
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
                                <th>اليوم</th>
                                <th> اليوميه</th>
                                <th>المدفوع</th>
                                <th>المتبقى</th>
                                <th>تاريخ اليوم</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            @foreach ($days as $index=>$day)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="#" data-toggle="modal" data-target="#{{$day->id}}">{{ $day->day }}</a></td>
                                    <td>{{ $day->price }}</td>
                                    <td>{{ $day->paid }}</td>
                                    <td>{{ $day->remain }}</td>
                                    <td>{{ $day->created_at }}</td>
                                    <td>
                                        
                                        <a href="{{ route('workers.days_worker.edit', [$worker->id, $day->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                        
                                        
                                        <form action="{{ route('workers.days_worker.destroy', [$worker->id, $day->id]) }}" method="post" style="display: inline-block">
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

                        <div class="card">
                            @if($days->sum('remain') > 0)

                                <p class="lead">المتبقى الكلى للعامل : <span class="text-danger"> {{ $days->sum('remain') }} </span> جنيه</p>

                            @elseif($days->sum('remain') < 0)

                                <p class="lead"> العامل لديه أجر زائد بمقدار : <span class="text-primary"> {{ abs($days->sum('remain')) }} </span> جنيه</p>

                            @endif
                        </div>
                        
                        {{ $days->appends(request()->query())->links() }}
                        
                    @else
                        
                        <h2>لا يوجد اى سجلات لهذا الطلب</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
