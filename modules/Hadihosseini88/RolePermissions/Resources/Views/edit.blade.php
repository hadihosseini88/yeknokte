@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('role-permissions.index') !!}" title="نقش های کاربری">نقش های کاربری</a></li>
    <li><a href="#" title="ویرایش نقش کاربری">ویرایش نقش کاربری</a></li>
@endsection

@section('content')

    <div class="main-content padding-0 categories">
        <div class="row no-gutters  ">
            <div class="col-4 border-radius-3 bg-white" style="margin-left: auto;margin-right: auto;">
                <p class="box__title">بروزرسانی نقش کاربری</p>
                <form action = "{{ route('role-permissions.update', $role->id) }}" method = "post" class = "padding-30" >
                @csrf
                @method('patch')

                <input type="hidden" name="id" value="{{$role->id}}">
                <input type="text" name="name" required placeholder="نام نقش کاربری" class="text"
                       value="{{$role->name}}">
                @error('name')
                    <span class="invalid-feedback margin-bottom-10" role="alert">
                         <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <p class="box__title margin-bottom-15">انتخاب مجوزها</p>
                @foreach($permissions as $permission)
                    <label class="ui-checkbox margin-bottom-10">
                        <input type="checkbox" name="permissions[{{ $permission->name }}]" class="sub-checkbox"
                               data-id="2"
                               value="{{ $permission->name }}"
                               @if($role->hasPermissionTo($permission->name)) checked @endif
                        >
                        <span class="checkmark "></span>
                        <span class="select-role-permissions">@lang($permission->name)</span>
                    </label>
                @endforeach
                @error('permissions') @error('permissions') is-invalid @enderror
                <span class="invalid-feedback margin-bottom-10" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror

                <br>

                <button class="btn btn-yeknokte_ir">بروزرسانی</button>

                </form>
            </div>
        </div>
    </div>
@endsection
