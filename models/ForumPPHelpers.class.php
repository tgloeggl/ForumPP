<?php

class ForumPPHelpers {

    static $page = 1;

    /**
     * helper_function for highlight($text, $highlight)
     *
     * @param  string  $text
     * @param  array   $highlight
     * @return string
     */
    static function do_highlight($text, $highlight) {
        $text = preg_replace($highlight, '####${1}####', $text);
        $text = preg_replace('/####(.*)####/U', '<span class="highlight">${1}</span>', $text);
        return $text;
    }

    /**
     * This function highlights Text HTML-safe
     * (tags or words in tags are not highlighted, words between tags ARE highlighted)
     *
     * @param string $text the text where to words shall be highlighted, may contain tags
     * @param array $highlight an array of words to be highlighted
     * @return string the highlighted text
     */
    function highlight($text, $highlight) {
        if (empty($highlight)) return $text;

        $unsafe_symbols = array('/\./', '/\*/', '/\?/', '/\+/');
        $unsafe_replace = array('\\.', '\\*', '\\?', '\\+');

        foreach ($highlight as $key => $val) {
            $highlight[$key] = '/(' . preg_replace($unsafe_symbols, $unsafe_replace, $val) . ')/i';
        }

        $data = array();
        $treffer = array();

        // split text at every tag
        $pattern = '/<[^<]*>/U';
        preg_match_all($pattern, $text, $treffer, PREG_OFFSET_CAPTURE);

        if (sizeof($treffer[0]) == 0) {
            return self::do_highlight($text, $highlight);
        }

        $last_pos = 0;
        foreach ($treffer[0] as $taginfo) {
            $size = strlen($taginfo[0]);
            if ($taginfo[1] != 0) {
                $data[] = self::do_highlight(substr($text, $last_pos, $taginfo[1] - $last_pos), $highlight);
            }

            $data[] = substr($text, $taginfo[1], $size);
            $last_pos = $taginfo[1] + $size;
        }

        // don't miss the last portion of a posting
        if ($last_pos < strlen($text)) {
            $data[] = substr($text, $last_pos, strlen($text) - $last_pos);
        }

        return implode('', $data);
    }

    /**
     * Returns a human-readable version of the passed global Stud.IP permission.
     *
     * @param  string  $perm
     * @return string
     */
    static function translate_perm($perm) {
        switch ($perm) {
            case 'root':
                return _('Chef im Ring');
                break;

            case 'admin':
                return _('Administrator/In');
                break;

            case 'dozent':
                return _('Dozent/In');
                break;

            case 'tutor':
                return _('Tutor/In');
                break;

            case 'autor':
                return _('Autor/In');
                break;

            case 'user':
                return _('Leser/In');
                break;

            default:
                return '';
                break;
        }
    }

    /**
     * Return the user specific access key.
     *
     * @author Elmar Ludwig
     */
    private function get_user_key($user_id)
    {
        return UserConfig::get($user_id)->getValue('FORUMPP_KEY');
    }

    /**
     * Calculate user specific access key.
     *
     * @author Elmar Ludwig
     */
    private function set_user_key($user_id)
    {
        $key = '';

        for ($i = 0; $i < 32; ++$i) {
            $key .= chr(mt_rand(0, 63) + 48);
        }

        UserConfig::get($user_id)->store('FORUMPP_KEY', sha1($key));
    }

    /**
     * Clear the user specific access key.
     *
     * @author Elmar Ludwig
    */
    private function clear_user_key($user_id)
    {
        UserConfig::get($user_id)->delete('FORUMPP_KEY');
    }

    /**
     * return the currently chosen page
     *
     * @return  int
     */
    static function getPage() {
        return self::$page - 1;
    }

    /**
     * set the current page
     *
     * @return  int
     */
    static function setPage($page_num) {
        self::$page = $page_num;
    }
}