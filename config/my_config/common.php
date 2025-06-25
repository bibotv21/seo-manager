<?php

return [
    'query_string_checking' => 'tet+2024',
    'text-link-type' => 'text_link',
    'guest-post-type' => 'guest_post',
    'invalid_csv_file_message' => 'Vui lòng kiểm tra lại file text link csv!',
    'invalid_data_message' => 'Những domain hoặc CTV màu đỏ hiện tại chưa có trong dữ liệu. Thêm những Domain hoặc CTV trước khi thêm bằng CSV!',
    'text_link_status' => [
        [
            'id' => 0,
            'title' => 'Chưa Đặt'
        ],
        [
            'id' => 1,
            'title' => 'Đã Đặt'
        ]
    ],
    'guest_post_status' => [
        [
            'id' => 0,
            'title' => 'Chưa Index'
        ],
        [
            'id' => 1,
            'title' => 'Indexed'
        ]
    ],
    'redirect_status' => [
        [
            'id' => 0,
            'title' => 'Không check'
        ],
        [
            'id' => 1,
            'title' => 'Check'
        ]
    ]
];
