<?php

return [

    'heading' => [
        'welcome' => 'Xin chào',
        'intro' => '',
        'users-intro' => '',

    ],

    'side-menu' => [
        'profile' => 'Hồ sơ',
        'categories' => 'Danh mục',
        'system' => 'Hệ thống',
        'security' => 'Thay đổi mật khẩu',
    ],

    'button'    => [
        'save' => 'Lưu thay đổi',
        'add-category' => 'Thêm danh mục',
        'close' => 'Đóng',
        'add-user' => 'Thêm người dùng',
        'create-account' => 'Tạo tài khoản',
        'continue' => 'Tiếp tục'
    ],

    'profile-form' => [
        'title' => 'Hồ sơ',
        'intro' => 'Cập nhật thông tin cá nhân của bạn',
        'label' => [
            'picture' => 'Ảnh đại diện',
            'first-name' => 'Họ đệm',
            'last-name' => 'Tên',
            'email' => 'Địa chỉ email',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'currency' => 'Loại tiền tệ',
            'timezone' => 'Múi giờ',
        ],
        'placeholder' => [
            'first-name' => '',
            'last-name' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
        ],
    ],

    'password-form' => [
        'title' => 'Thay đổi mật khẩu',
        'intro' => 'Cập nhật mật khẩu tài khoản của bạn tại đây',
        'label' => [
            'current-password' => 'Mật khẩu',
        ],
        'placeholder' => [
            'current-password' => 'Mật khẩu',
        ],
    ],

    'category-table' => [
        'title' => 'Danh mục',
        'intro' => '',
        'number' => 'STT.',
        'category-name' => 'Tên danh mục',
        'actions' => 'Hành động',
        'edit' => 'Chỉnh sửa',
        'delete' => 'Xóa',
        'empty' => 'Trống!',
    ],

    'category-form' => [
        'add-title' => 'Thêm danh mục',
        'update-title' => 'Chỉnh sửa danh mục',
        'label' => [
            'name' => 'Tên danh mục',
        ],
        'placeholder' => [
            'name' => '',
        ],
    ],

    'system-form' => [
        'title' => 'Hệ thống',
        'intro' => 'Quản lý cài đặt và tùy chọn hệ thống',
        'label' => [
            'name' => 'Tên hệ thống',
            'logo' => 'Logo hệ thống',
            'favicon' => 'Biểu tượng/biểu tượng hệ thống',
            'smtp-user' => 'Tên đăng nhập SMTP',
            'smtp-sender' => 'Người gửi SMTP/Địa chỉ',
            'smtp-host' => 'Máy chủ MTP',
            'smtp-port' => 'Cổng SMTP',
            'smtp-password' => 'Mật khẩu SMTP',
            'smtp-encryption' => 'Mã hóa SMTP',
            'smtp-auth' => 'Xác thực SMTP',
            'allow-signup' => 'Cho phép người dùng và doanh nghiệp mới đăng ký',
        ],
    ],

    'users-table' => [
        'title' => 'Người dùng hệ thống',
        'number' => '#',
        'image' => 'Hình ảnh',
        'name' => 'Tên',
        'contact' => 'Liên hệ',
        'edit' => 'Chỉnh sửa',
        'joined-on' => 'Đã tham gia vào',
        'date-joined' => 'Ngày tham gia',
        'status' => 'Trạng thái',
        'actions' => 'Hành động',
        'edit' => 'Chỉnh sửa',
        'delete' => 'Xóa',
        'empty' => 'Trống!',  
    ],

    'user-form' => [
        'add-title' => 'Tạo tài khoản người dùng',
        'add-intro' => 'Điền thông tin người dùng, thông tin đăng nhập sẽ được gửi đến email của người dùng.',
        'update-title' => 'Cập nhật tài khoản người dùng',
        'update-intro' => 'Cập nhật thông tin tài khoản người dùng',
        'label' => [
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'picture' => 'Ảnh đại diện',
            
        ],
        'placeholder' => [
            'phone' => '',
            'address' => '',
        ],
        'status' => [
            'active' => 'Hoạt dộng',
            'inactive' => 'Không hoạt động',
            'suspended' => 'Cấm sử dụng',
        ]
    ],

    'messages' => [
        'profile-edit-success' => 'Hồ sơ được cập nhật thành công',
        'company-edit-success' => 'Thông tin công ty được cập nhật thành công',
        'password-edit-success' => 'Đã cập nhật mật khẩu thành công',
        'password-incorrect' => 'Bạn đã nhập sai mật khẩu.',
        'already-exists' => 'Đã tồn tại',
        'are-you-sure' => 'Bạn có chắc chắn không?',
        'proceed' => 'Tiếp tục',
        'delete-category' => 'Danh mục này và các hồ sơ liên quan sẽ bị xóa.',
        'category-edit-success' => 'Đã cập nhật danh mục thành công',
        'category-add-success' => 'Đã thêm danh mục thành công.',
        'category-delete-success' => 'Đã danh mục thành công.',
        'category-deleted' => 'Đã xóa danh mục',
        'settings-edit-success' => 'Đã cập nhật cài đặt hệ thống thành công',
        'delete-user' => 'Hồ sơ và dữ liệu của người dùng này sẽ bị xóa.',
        
        'account-created' => 'Tài khoản đã được tạo!',
        'account-created-success' => 'Tạo tài khoản thành công.',
        'account-updated-success' => 'Tài khoản được cập nhật thành công.',
        'account-deleted' => 'Tài khoản đã bị xóa!',
        'account-delete-success' => 'Tài khoản vừa tạo đã được xóa thành công.',

    ],

    'email-content' => [
        'new-account-title' => 'Xin chào!',
        'new-account-subtitle' => 'Một tài khoản mới đã được tạo cho bạn tại %s.',
        'new-account-message' => 'Đây là Thông tin xác thực đăng nhập của bạn:<br><br><strong>Email:</strong> %s<br><strong>Mật khẩu:</strong> %s<br><br>Chúc mừng!<br>%s Nhóm',
        'new-account-button' => 'Đăng nhập ngay bây giờ',
    ]

];
