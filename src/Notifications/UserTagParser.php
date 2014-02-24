<?php  namespace Lio\Notifications; 

class UserTagParser
{
    public function parseForUsers($content)
    {
        return $this->getMatches($content);
    }

    private function getMatches($content)
    {
        preg_match_all('/@(\w*)/', $content, $matches);
        return $matches[1];
    }
} 
