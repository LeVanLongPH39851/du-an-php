<!DOCTYPE html>
<html lang="en">

<head>
    @include('admins.components.head')
</head>

<body>
    <div id="wrapper">
        @include('admins.components.sidebar')
        <div id="page-wrapper" class="gray-bg">
            @include('admins.components.nav')
            @include($template)
            @include('admins.components.footer')
        </div>
    </div>
    @include('admins.components.script')
</body>

</html>
{{-- -Blade là một Template Engine được cung cấp bởi Laravel
     -Các file Blade View có phần mở rộng là .blade.php và được lưu trữ trong resources/views   
--}}
{{-- -Cách hiển thị dữ liệu phiên dịch html: {!! $text !!} --}}
{{-- Vòng lặp for @for() @endfor --}}
{{-- Vòng lặp forelse 
@forelse($array -> $key) 
@emty 
<p>Chưa có dữ liệu được thêm vào</p> 
@endforelse 
-> Nếu mảng rỗng thì hiển thị text chưa có dữ liệu --}}
{{-- @php Viết mã php @endphp --}}
{{-- @if(true) 
<p>Long</p> 
@elseif 
<p>Long1</p> 
@else <p>Long2</p>
@endif --}}
