<?php

class c_token extends f_c_action
{
    
    public function indexAction()
    {
        $this->render->off();
        
        $this->response
            ->header('Content-Type', 'text/plain')
            ->body($this->token());
    }
    
}
