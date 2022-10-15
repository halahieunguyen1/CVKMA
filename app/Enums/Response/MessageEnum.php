<?php

namespace App\Enums\Response;
use App\Enums\AbstractEnum;

class MessageEnum extends AbstractEnum
{
    const BASE_FAILD = 'Đã có lỗi xảy ra, vui lòng liên hệ với quản trị hệ thống';
    const LOGIN_FAILD = 'Sai tên đăng nhập hoặc mật khẩu';
    const PASSWORD_FAILD = 'Mật khẩu không chính xác';
    const AUTHENTICATE_FAILD = 'Yêu cầu đăng nhập để có thể truy cập';
    
    const CHANGE_PASSWORD_SUCCESS = 'Thay đổi mật khẩu thành công';
    const UPDATE_FAILD = 'Cập nhập thông tin thất bại';
    const SAVE_CV_ERROR = 'Lưu CV thất bại';

}
