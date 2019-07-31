<?PHP
function gen_512($password) {
  $salt = '8fds93hf<32§42xc';
  //return crypt($password, '$6$rounds=1337'. $salt .'$');
  return crypt($password, '$6$');
}

function modern_openssl_sha512($password, $salt = "", $rounds = 20000)
{
    if ($salt == "")
    {
        // Generate random salt
        $salt = substr(bin2hex(openssl_random_pseudo_bytes(16)),0,16);
    }
    // $6$ specifies SHA512
    $hash = crypt($password, sprintf('$6$rounds=%d$%s$', $rounds, $salt));

    $hasharray = array();
    array_push($hasharray, $hash);
    array_push($hasharray, $salt);
    return $hasharray;
}
?>
