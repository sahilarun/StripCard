<?php 

namespace Project\Installer\Helpers;

class ErrorHelper {

    /**
     * Return Common Error View
     * @param string|array $content
     */
    public function redirectErrorPage(string | array $content) {
        $page_title = "Installation - Error - " . (is_array($content)) ? $content[0] : $content;
        return view('installer.pages.error',compact('page_title','content'));
    }
}