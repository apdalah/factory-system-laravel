@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>العملاء</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
                <li><a href="{{ route('clients.index') }}"> العملاء</a></li>
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

                    <form action="{{ route('clients.update', $client->id) }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">
                            <label>الإسم </label>
                            <input type="text" name="name" class="form-control" value="{{ $client->name }}">
                        </div>

                        <div class="form-group">
                            <label> رقم الهاتف الأساسى</label>
                            <input type="text" name="phone[]" class="form-control" value="{{ $client->phone[0] }}">
                        </div>

                        <div class="form-group">
                            <label> رقم الهاتف البديل</label>
                            <input type="text" name="phone[]" class="form-control" value="{{ $client->phone[1] }}">
                        </div>

                        <div class="form-group">
                            <label> العنوان</label>
                            <input type="text" name="address" class="form-control" value="{{ $client->address }}">
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

