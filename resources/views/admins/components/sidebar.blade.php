<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" style="width: 48px; aspect-ratio: 1/1; object-fit: cover;" class="img-circle" src="storage/uploads/khachhang/3cmeZ0UFQo3rADQUldEERulGHWDWCjuW2q9CiHSG.jpg">
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Lê Văn Long</strong>
                            </span> <span class="text-muted text-xs block">Giám đốc <b class="caret"></b></span>
                        </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{route('logout')}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="<?=$active === 'Trang Chủ' ? 'active' : ''?>">
                <a href="{{route('admin')}}"><i class="fa fa-home"></i> <span class="nav-label">Trang Chủ</span></a>
            </li>
            <li class="<?=$active === 'Danh Sách Slide Show' ? 'active' : ''?>">
                <a href="{{route('slideshow.index')}}"><i class="fa fa-sliders"></i> <span class="nav-label">Danh Sách Slide Show</span></a>
            </li>
            <li class="<?=$active === 'Danh Sách Bài Viết' ? 'active' : ''?>">
                <a href="{{route('baiviet.index')}}"><i class="fa fa-book"></i> <span class="nav-label">Danh Sách Bài Viết</span></a>
            </li>
            <li class="<?=$active === 'Danh Sách Danh Mục' ? 'active' : ''?>">
                <a href="{{route('danhmuc.index')}}"><i class="fa fa-align-left"></i> <span class="nav-label">Danh Sách Danh Mục</span></a>
            </li>
            <li class="<?=$active === 'Danh Sách Sản Phẩm' ? 'active' : ''?>">
                <a href="{{route('sanpham.index')}}"><i class="fa fa-flask"></i> <span class="nav-label">Danh Sách Sản Phẩm</span></a>
            </li>
            <li class="<?=$active === 'Danh Sách Khách Hàng' ? 'active' : ''?>">
                <a href="{{route('khachhang.index')}}"><i class="fa fa-address-book"></i> <span class="nav-label">Danh
                        Sách Khách
                        Hàng</span></a>
            </li>
            <li class="<?=$active === 'Trạng Thái Đơn Hàng' || $active === 'Danh Sách Đơn Hàng' || $active === 'Hình Thức Thanh Toán' ? 'active' : ''?>">
                <a href="#"
                  ><i class="fa fa-list-alt"></i> <span class="nav-label">Quản Lý Đơn Hàng</span
                  ><span class="fa arrow"></span
                ></a>
                <ul class="nav nav-second-level collapse">
                    <li class="<?=$active === 'Trạng Thái Đơn Hàng' ? 'active' : ''?>"><a href="{{route('trangthaidonhang.index')}}">Trạng Thái Đơn Hàng</a></li>
                  <li class="<?=$active === 'Hình Thức Thanh Toán' ? 'active' : ''?>"><a href="{{route('hinhthucthanhtoan.index')}}">Hình Thức Thanh Toán</a></li>
                  <li class="<?=$active === 'Danh Sách Đơn Hàng' ? 'active' : ''?>"><a href="{{route('donhang.index')}}">Danh Sách Đơn Hàng</a></li>
                </ul>
            </li>
            <li class="<?=$active === 'Thùng Rác Đơn Hàng' || $active === 'Thùng Rác Danh Mục' || $active === 'Thùng Rác Sản Phẩm' || $active === 'Thùng Rác Khách Hàng' || $active === 'Thùng Rác Hình Thức Thanh Toán' || $active === 'Thùng Rác Trạng Thái Đơn Hàng' ? 'active' : ''?>">
                <a href="#"
                  ><i class="fa fa-trash"></i> <span class="nav-label">Thùng rác</span
                  ><span class="fa arrow"></span
                ></a>
                <ul class="nav nav-second-level collapse">
                    <li class="<?=$active === 'Thùng Rác Danh Mục' ? 'active' : ''?>"><a href="{{route('danhmuctrash.index')}}">Danh Mục Đã Xóa</a></li>
                  <li class="<?=$active === 'Thùng Rác Sản Phẩm' ? 'active' : ''?>"><a href="{{route('sanphamtrash.index')}}">Sản Phẩm Đã Xóa</a></li>
                  <li class="<?=$active === 'Thùng Rác Khách Hàng' ? 'active' : ''?>"><a href="{{route('khachhangtrash.index')}}">Khách Hàng Đã Xóa</a></li>
                  <li class="<?=$active === 'Thùng Rác Đơn Hàng' || $active === 'Thùng Rác Hình Thức Thanh Toán' || $active === 'Thùng Rác Trạng Thái Đơn Hàng' ? 'active' : ''?>">
                    <a href="#"
                      ><span class="nav-label">Thùng Rác Đơn Hàng</span
                      ><span class="fa arrow"></span
                    ></a>
                    <ul class="nav nav-second-level collapse">
                      <li class="<?=$active === 'Thùng Rác Trạng Thái Đơn Hàng' ? 'active' : ''?>"><a href="{{route('trangthaidonhangtrash.index')}}">Trạng Thái Đã Xóa</a></li>
                      <li class="<?=$active === 'Thùng Rác Hình Thức Thanh Toán' ? 'active' : ''?>"><a href="{{route('hinhthucthanhtoantrash.index')}}">Hình Thức Đã Xóa</a></li>
                      <li class="<?=$active === 'Thùng Rác Đơn Hàng' ? 'active' : ''?>"><a href="{{route('trangthaidonhang.index')}}">Đơn Hàng Đã Xóa</a></li>
                    </ul>
                </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>