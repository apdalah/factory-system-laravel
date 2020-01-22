@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>العملاء</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li><a href="{{ route('productions.index') }}"> العملاء</a></li>
                <li class="active">إضافه</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">تعديل</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('productions.update', $production->id) }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

@php
    $days = ['السبت', 'الاحد', 'الاثنين', 'الثلاثاء', 'الاربعاء', 'الخميس', 'الجمعه'];    
@endphp

                        <div class="form-group">
                            <label>اليوم</label>
                            <select name="day" class="form-control" required>
                                <option value="">أيام الأسبوع</option>
                                  @foreach($days as $day)
                                    <option value="{{$day}}" {{ $production->day == $day ? 'selected' : '' }}>{{$day}}</option>
                                  @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>القسم</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">الأقسام</option>
                                  @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ $production->category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                  @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>الكميه</label>
                            <input type="number" required step="0.01" name="amount" class="form-control" value="{{ $production->amount }}">
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> حفظ</button>
                            <button type="reset" class="btn btn-primary"><i class="fa fa-edit"></i> إلغاء</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection

