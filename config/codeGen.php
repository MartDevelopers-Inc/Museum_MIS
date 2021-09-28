<?php

/* Register All System Generated Codes   */

/* System Generated Password */
$sys_gen_password = substr(
    str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890qwertyuioplkjhgfdsazxcvbnm"),
    1,
    8
);

/* SysGenerated Payment Codes */
$sys_gen_paycode = substr(
    str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890"),
    1,
    10
);
/* System Generated ID */
$length = date('y');
$sys_gen_id = bin2hex(random_bytes($length));

/* Alternative Sys Generated ID 1 */
$length = date('y');
$sys_gen_id_alt_1 = bin2hex(random_bytes($length));

/* Alternative System Generated ID 2 */
$length = date('y');
$sys_gen_id_alt_2 = bin2hex(random_bytes($length));
/* System Generated Codes */
$a = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM"), 1, 5);
$b = substr(str_shuffle("1234567890"), 1, 5);

