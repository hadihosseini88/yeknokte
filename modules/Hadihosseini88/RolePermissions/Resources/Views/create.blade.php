<p class="box__title">ایجاد نقش های کاربری جدید</p>
<form action="{{route('role-permissions.store')}}" method="post" class="padding-30">
    @csrf
    <input type="text" name="name" required placeholder="نام نقش کاربری"
           class="text @error('name') is-invalid @enderror" value="{{ old('name') }}">
    @error('name')
    <span class="invalid-feedback margin-bottom-10" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <p class="box__title margin-bottom-15">انتخاب مجوزها</p>

    @foreach($permissions as $permission)
        <label class="ui-checkbox margin-bottom-10">
            <input type="checkbox" name="permissions[{{$permission->name}}]" class="sub-checkbox" data-id="2"
                   value="true"
                   @if(is_array(old('permissions')) && array_key_exists($permission->name,  old('permissions'))) checked @endif
            >
            <span class="checkmark @error('permissions') is-invalid @enderror"></span>
            <span class="select-role-permissions">@lang($permission->name)</span>
        </label>
    @endforeach

    @error('permissions')
    <span class="invalid-feedback margin-bottom-10" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <br>

    <button class="btn btn-webamooz_net">اضافه کردن</button>
</form>
