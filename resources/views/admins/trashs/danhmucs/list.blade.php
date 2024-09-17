@include('admins.components.breakcumb')
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{$title}}</h5>
                @include('admins.trashs.danhmucs.components.toolbox')
            </div>
            <div class="ibox-content">
                @include('admins.trashs.danhmucs.components.filter')
                @include('admins.trashs.danhmucs.components.table')
            </div>
        </div>
    </div>
</div>
</div>