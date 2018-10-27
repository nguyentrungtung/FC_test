<?php

class MY_Lang extends CI_Lang
{

    function __construct()
    {
        parent::__construct();
    }

    function switch_to($idiom)
    {
        $CI = & get_instance();
        if (is_string($idiom)) {
            $CI->config->set_item('language', $idiom);
            $loaded = $this->is_loaded;
            $this->is_loaded = array();
            
            foreach (array_keys($loaded) as $file) {
                $this->load(str_replace('_lang.php', '', $file));
            }
        }
    }

    public function load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '')
    {
        if (is_array($langfile)) {
            foreach ($langfile as $value) {
                $this->load($value, $idiom, $return, $add_suffix, $alt_path);
            }
            
            return;
        }
        
        $langfile = str_replace('.php', '', $langfile);
        
        if ($add_suffix === TRUE) {
            $langfile = preg_replace('/_lang$/', '', $langfile) . '_lang';
        }
        
        $langfile .= '.php';
        
        if (empty($idiom) or ! preg_match('/^[a-z_-]+$/i', $idiom)) {
            $config = & get_config();
            $idiom = empty($config['language']) ? 'english' : $config['language'];
        }
        
        if ($return === FALSE && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom) {
            return;
        }
        
        // Load the base file, so any others found can override it
        $basepath = BASEPATH . 'language/' . $idiom . '/' . $langfile;
        if (($found = file_exists($basepath)) === TRUE) {
            include ($basepath);
        }
        
        // Do we have an alternative path to look in?
        if ($alt_path !== '') {
            $alt_path .= 'language/' . $idiom . '/' . $langfile;
            if (file_exists($alt_path)) {
                include ($alt_path);
                $found = TRUE;
            }
        } else {
            foreach (get_instance()->load->get_package_paths(TRUE) as $package_path) {
                $package_path .= 'language/' . $idiom . '/' . $langfile;
                if ($basepath !== $package_path && file_exists($package_path)) {
                    include ($package_path);
                    $found = TRUE;
                    break;
                }
            }
        }
        
        if (! isset($lang) or ! is_array($lang)) {
            log_message('error', 'Language file contains no data: language/' . $idiom . '/' . $langfile);
            
            if ($return === TRUE) {
                return array();
            }
            return;
        }
        
        if ($return === TRUE) {
            return $lang;
        }
        
        $this->is_loaded[$langfile] = $idiom;
        $this->language = array_merge($this->language, $lang);
        
        log_message('info', 'Language file loaded: language/' . $idiom . '/' . $langfile);
        return TRUE;
    }
}

?>
