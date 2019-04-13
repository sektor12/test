<?php

namespace Snippets;

class Messages 
{
    public static $login = array(
        'missing_username' => 'Please enter username.',
        'missing_password' => 'Please enter password.',
        'wrong_username_or_password' => 'Wrong username or password. Please try again.',
        'loging_successful' => 'Login successful',
    );
    
    public static $article = array(
        'wrong_image_type' => 'Allowed images format is jpeg.',
        'missing_title' => 'Article title is missing.',
        'missing_body' => 'Article body is missing.',
        'add_article_success' => 'Successfully added article.',
        'update_article_success' => 'Successfully modified article.',
        'delete_article_success' => 'Successfully deleted article'
    );
}