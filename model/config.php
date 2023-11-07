<?php

/** The name of the database*/
define('DB_NAME', 'db_quanlybanhang');
/** MySQL database username */
define('DB_USER', 'root');
/** MySQL database password */
define('DB_PASSWORD', 'vertrigo');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** port number of DB MySQL*/
define('PORT', 3306);
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

//CRUD
// Create (Insert)
// Read (Select)
// Update (Update)
// Delete (Delete)

/**Sok Kim Thanh 1/11/2023 6:46CH */
/** error_code lỗi đầu vào null or empty*/
define('INPUT_ERROR', -1);
/** error_code thực thi câu truy vấn không thành công*/
define('QUERY_ERROR', -2);
/** error_code thực thi câu truy vấn thành công*/
define('SUCCESS', 0);
/** error_code thực thi câu truy vấn select không tìm thấy id tồn tại*/
define('SELECT_ERROR', -3);
/** error_code thực thi câu truy vấn insert tìm thấy id tồn tại*/
define('INSERT_ERROR', -3);
