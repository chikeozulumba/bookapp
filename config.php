<?php
  define('BASEURL',$_SERVER['DOCUMENT_ROOT'].'/CEPA/');
  define('CART_COOKIE','COeokbimhuCrO39');
  define('CART_COOKIE_EXPIRE',time() + (86400 * 30));
  define('TAXRATE', 0.05);
  define('PAYSTACK_SECRET_KEY', 'sk_test_3db08cf0806fc59c03e9ee97fc0fc7b6acb16fae');

  function getIp()
  {
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
          $ip = $_SERVER['REMOTE_ADDR'];
      }
      return $ip;
  }


  function getUnusedCode()
  {
  // to generate our random string code
      $newcode = createLuhnCheckedRandomString(10);

  // while the new string exists, get a new code
      while (file_exists('results/' . $newcode . '-response.json')) {
          $newcode = createLuhnCheckedRandomString(10);
      }

      return $newcode;
  }



class VirtualDirectory
{
    var $protocol;
    var $site;
    var $thisfile;
    var $real_directories;
    var $num_of_real_directories;
    var $virtual_directories = array();
    var $num_of_virtual_directories = array();
    var $baseURL;
    var $thisURL;

    function VirtualDirectory()
    {
        $this->protocol = (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
        $this->site = $this->protocol . '://' . $_SERVER['HTTP_HOST'];
        $this->thisfile = basename($_SERVER['SCRIPT_FILENAME']);
        $this->real_directories = $this->cleanUp(explode("/", str_replace($this->thisfile, "", $_SERVER['PHP_SELF'])));
        $this->num_of_real_directories = count($this->real_directories);
        $this->virtual_directories = array_diff($this->cleanUp(explode("/", str_replace($this->thisfile, "", $_SERVER['REQUEST_URI']))),$this->real_directories);
        $this->num_of_virtual_directories = count($this->virtual_directories);
        $this->baseURL = $this->site . "/" . implode("/", $this->real_directories) . "/";
        $this->thisURL = $this->baseURL . implode("/", $this->virtual_directories) . "/";
    }

    function cleanUp($array)
    {
        $cleaned_array = array();
        foreach($array as $key => $value)
        {
            $qpos = strpos($value, "?");
            if($qpos !== false)
            {
                break;
            }
            if($key != "" && $value != "")
            {
                $cleaned_array[] = $value;
            }
        }
        return $cleaned_array;
    }
}
 ?>
