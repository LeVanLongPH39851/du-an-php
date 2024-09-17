@include('admins.components.breakcumb')
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Thông Tin Sản Phẩm</h5>
                @include('admins.donhangs.components.toolbox')
            </div>
            <div class="ibox-content">
                @include('admins.donhangs.components.detail')
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Thông Tin Khách Hàng</h5>
                @include('admins.donhangs.components.toolbox')
            </div>
            <div class="ibox-content">
                @include('admins.donhangs.components.inforuser')
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Hóa Đơn</h5>
                @include('admins.donhangs.components.toolbox')
            </div>
            <div class="ibox-content">
                @include('admins.donhangs.components.bill')
            </div>
        </div>
    </div>
</div>
</div>
