<?php

namespace App\Enums\Response;
use App\Enums\AbstractEnum;

class MessageEnum extends AbstractEnum
{
    final const BASE_FAILD = 'Đã có lỗi xảy ra, vui lòng liên hệ với quản trị hệ thống';
    final const LOGIN_FAILD = 'Sai tên đăng nhập hoặc mật khẩu';
    final const PASSWORD_FAILD = 'Mật khẩu không chính xác';
    final const AUTHENTICATE_FAILD = 'Yêu cầu đăng nhập để có thể truy cập';
    
    final const CHANGE_PASSWORD_SUCCESS = 'Thay đổi mật khẩu thành công';
    final const UPDATE_FAILD = 'Cập nhập thông tin thất bại';
    final const SAVE_CV_ERROR = 'Lưu CV thất bại';
    final const CV_NOT_EXISTS = 'CV không tồn tại';
    final const JOB_NOT_EXISTS = 'Tin tuyển dụng không tồn tại';
    final const JOB_IS_EXPIRED = 'Tin tuyển dụng đã hết hạn nộp hồ sơ';
    const LIMIT_TIME_APPLY = 'Bạn vừa mới gửi CV ứng tuyển tin tuyển dụng. Vui lòng đợi %s để gửi CV ứng tuyển lần tiếp theo';
    final const COMPANY_NOT_EXISTS = 'Công ty không tồn tại';
    final const ACCOUNT_CREATING = 'Tài khoản đang được tạo, vui lòng không spam';

}
