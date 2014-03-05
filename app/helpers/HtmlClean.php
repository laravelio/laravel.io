<?php namespace Helpers;

class HtmlClean{
    
    public function make($html){
        
        $html  = strip_tags($html,"<b><strong><em><i><p><br><ul><li><ol><br><h1><h2><h3><h4><h5><h6><span><blockquote><code><label><pre><div>");
        $tidy  = new tidy();
        $clean = $tidy->repairString($html);
        return $clean;

    }
    
}