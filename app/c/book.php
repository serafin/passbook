<?php

class c_book extends f_c_action
{
    
    public function indexAction()
    {
        $workspace = $_GET[1];
        
        $this->notFound->ifNot($workspace != '');
        
        // save or delete
        if ($_POST) {
            
            $_SESSION['cipher'] = $_POST['cipher'];
            
            // delete
            if (isset($_POST['del'])) {
                m_book::_()->delete($_POST['book_id']);
                $this->flash('Deleted', 'error');
                $this->redirect(array('book', $workspace));
            }
            
            
            
            $book = new m_book();
            if ($_POST['book_id'] > 0) {
                $book->id($_POST['book_id']);
            }
            $book->val($_POST);
            $book->save();
            
            if (!$book->id()) {
                $book->selectInserted();
            }
            
            $this->v->modified = $book->id();
            
            $this->flash('Saved', null, array('id' => $book->id()));
            $this->redirect(array('book', $workspace));
            
            
        }
        
        // view
        $this->v->book = m_book::_()
            ->param(array('book_workspace' => $workspace, 'order' => 'book_id'))
            ->selectAll()
        ;
        
    }
    
}