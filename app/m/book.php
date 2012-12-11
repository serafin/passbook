<?php

class m_book extends f_m
{
    
    public $book_id;      
    public $book_workspace;
    public $book_type;
    public $book_group;
    public $book_uri;
    public $book_name;
    public $book_user;
    public $book_pass;
    public $book_info;
    
    /**
     * Statyczny konstruktor
     * 
     * @param array $config
     * @return m_book
     */
    public static function _(array $config = array())
    {
        return new self($config);
    }
    
}