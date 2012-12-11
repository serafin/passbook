<?php

class c_book extends f_c_action
{
    
    public function indexAction()
    {
        $workspace = $_GET[1];
        
        if ($workspace == '') {
            $this->redirect(array('book', 'default'));
        }
        
        $this->v->book = m_book::_()
            ->param(array(
                'book_workspace' => $workspace,
                'order'          => 'book_id',
            ))
            ->selectAll()
        ;
        
    }
    
}