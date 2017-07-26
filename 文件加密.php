<?php
$enc_options = 0; 

$iv_length = openssl_cipher_iv_length($method); 

$iv = openssl_random_pseudo_bytes($iv_length); 

 

$ciphertext = openssl_encrypt($plaintext, $method, $enc_key, $enc_options, $iv); 

 

// 定义“私有”的密文结构 

$saved_ciphertext = sprintf('%s$%d$%s$%s', $method, $enc_options, bin2hex($iv), $ciphertext); 

 

// 检查密文格式是否正确、符合定义 

if(preg_match('/.*$.*$.*$.*/', $saved_ciphertext) !== 1) { 

 fprintf(STDERR, "无法解密的密文格式\n"); 

 exit(1); 

} 

 

// 解析密文结构，提取解密所需各个字段 

list($extracted_method, $extracted_enc_options, $extracted_iv, $extracted_ciphertext) = explode('$', $saved_ciphertext); 

 

$decryptedtext = openssl_decrypt($extracted_ciphertext, $extracted_method, $enc_key, $enc_options, hex2bin($extracted_iv)); 

 

// 计算解密后密文的散列值 

$decryptedtext_hash = hash('sha256', $decryptedtext); 

 

var_dump($decryptedtext_hash);
?>